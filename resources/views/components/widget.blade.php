@props([
    'instance',
    'context' => [],
])

@php
    $repository = app(\Moanasoft\SupportFlowCore\Contracts\SupportFlowRepositoryContract::class);
    $definition = $repository->instance($instance);
    $intents = $definition ? $repository->intentsForInstance($instance) : collect();
    $widgetId = 'support-flow-'.str_replace(['.', '_'], '-', $instance).'-'.uniqid();
@endphp

@if($definition)
    <div
        id="{{ $widgetId }}"
        class="moanasoft-support-flow"
        data-instance="{{ $instance }}"
        data-context='@json($context)'
    >
        <div class="moanasoft-support-flow__header">
            <strong>{{ $definition->label }}</strong>
            @if($definition->description)
                <p>{{ $definition->description }}</p>
            @endif
        </div>

        <div class="moanasoft-support-flow__intents" data-support-flow-intents>
            @foreach($intents as $intent)
                <button
                    type="button"
                    class="moanasoft-support-flow__intent"
                    data-support-flow-intent="{{ $intent->key }}"
                >
                    <span>{{ $intent->label }}</span>
                    @if($intent->description)
                        <small>{{ $intent->description }}</small>
                    @endif
                </button>
            @endforeach
        </div>

        <div class="moanasoft-support-flow__workflow" data-support-flow-workflow hidden></div>

        <form class="moanasoft-support-flow__contact" data-support-flow-contact hidden>
            @csrf
            <input type="hidden" name="intent" data-support-flow-contact-intent>
            <input type="hidden" name="workflow" data-support-flow-contact-workflow>

            <label>
                Nom
                <input type="text" name="name" autocomplete="name">
            </label>

            <label>
                Email
                <input type="email" name="email" autocomplete="email">
            </label>

            <label>
                Sujet
                <input type="text" name="subject">
            </label>

            <label>
                Message
                <textarea name="message" required rows="5"></textarea>
            </label>

            <button type="submit">Envoyer la demande</button>
        </form>

        <div class="moanasoft-support-flow__message" data-support-flow-message></div>
    </div>

    <script>
        (function () {
            const root = document.getElementById(@json($widgetId));
            const instance = root.dataset.instance;
            const context = JSON.parse(root.dataset.context || '{}');
            const token = root.querySelector('input[name="_token"]')?.value;
            const workflowTarget = root.querySelector('[data-support-flow-workflow]');
            const contactForm = root.querySelector('[data-support-flow-contact]');
            const messageTarget = root.querySelector('[data-support-flow-message]');
            let currentIntent = null;
            let currentWorkflow = null;

            const postJson = async function (url, payload) {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify(payload || {}),
                });

                if (! response.ok) {
                    throw new Error('La demande n’a pas pu être traitée.');
                }

                return response.json();
            };

            const openContact = async function () {
                contactForm.hidden = false;
                contactForm.querySelector('[data-support-flow-contact-intent]').value = currentIntent || '';
                contactForm.querySelector('[data-support-flow-contact-workflow]').value = currentWorkflow || '';

                await postJson(@json(route('support-flow.instances.contact-opened', ['instance' => $instance])), {
                    intent: currentIntent,
                    workflow: currentWorkflow,
                    context: context,
                });
            };

            const renderWorkflow = function (workflow) {
                workflowTarget.hidden = false;
                workflowTarget.innerHTML = '';

                if (! workflow) {
                    openContact();
                    return;
                }

                const title = document.createElement('h4');
                title.textContent = workflow.title || 'Workflow assisté';
                workflowTarget.appendChild(title);

                const list = document.createElement('ol');
                (workflow.steps || []).forEach(function (step) {
                    const item = document.createElement('li');
                    item.textContent = step.title || '';
                    list.appendChild(item);
                });
                workflowTarget.appendChild(list);

                (workflow.actions || []).forEach(function (action) {
                    const link = document.createElement('a');
                    link.href = action.url || '#';
                    link.textContent = action.label || 'Continuer';
                    link.className = 'moanasoft-support-flow__action';
                    workflowTarget.appendChild(link);
                });

                const solved = document.createElement('button');
                solved.type = 'button';
                solved.textContent = 'J’ai résolu ma demande';
                solved.addEventListener('click', async function () {
                    await postJson(@json(url(config('support-flow.routes.prefix', 'support-flow').'/instances/'.$instance.'/workflows')).concat('/' + currentWorkflow + '/complete'), {
                        intent: currentIntent,
                        context: context,
                    });
                    messageTarget.textContent = 'Merci, la résolution a été enregistrée.';
                });
                workflowTarget.appendChild(solved);

                const fallback = document.createElement('button');
                fallback.type = 'button';
                fallback.textContent = 'Je veux contacter le support';
                fallback.addEventListener('click', openContact);
                workflowTarget.appendChild(fallback);
            };

            root.querySelectorAll('[data-support-flow-intent]').forEach(function (button) {
                button.addEventListener('click', async function () {
                    currentIntent = button.dataset.supportFlowIntent;
                    messageTarget.textContent = '';
                    contactForm.hidden = true;

                    const data = await postJson(@json(url(config('support-flow.routes.prefix', 'support-flow').'/instances/'.$instance.'/intents')).concat('/' + currentIntent), {
                        context: context,
                    });

                    currentWorkflow = data.intent.workflow || null;
                    renderWorkflow(data.workflow);
                });
            });

            contactForm.addEventListener('submit', async function (event) {
                event.preventDefault();

                const formData = new FormData(contactForm);
                const payload = Object.fromEntries(formData.entries());
                payload.context = context;

                await postJson(@json(route('support-flow.instances.contact', ['instance' => $instance])), payload);
                contactForm.hidden = true;
                messageTarget.textContent = 'Votre demande a bien été envoyée.';
            });
        })();
    </script>
@else
    @if(config('app.debug'))
        <div class="moanasoft-support-flow moanasoft-support-flow--missing">
            Instance SupportFlow introuvable : {{ $instance }}
        </div>
    @endif
@endif
