<dl class="row">
    <dt class="col-sm-3">Instance</dt><dd class="col-sm-9">{{ $request->instance }}</dd>
    <dt class="col-sm-3">Intent</dt><dd class="col-sm-9">{{ $request->intent }}</dd>
    <dt class="col-sm-3">Workflow</dt><dd class="col-sm-9">{{ $request->workflow }}</dd>
    <dt class="col-sm-3">Statut</dt><dd class="col-sm-9">{{ $request->status }}</dd>
    <dt class="col-sm-3">Nom</dt><dd class="col-sm-9">{{ $request->name }}</dd>
    <dt class="col-sm-3">Email</dt><dd class="col-sm-9">{{ $request->email }}</dd>
    <dt class="col-sm-3">Sujet</dt><dd class="col-sm-9">{{ $request->subject }}</dd>
    <dt class="col-sm-3">Message</dt><dd class="col-sm-9"><pre class="mb-0">{{ $request->message }}</pre></dd>
    <dt class="col-sm-3">Contexte</dt><dd class="col-sm-9"><pre class="mb-0">{{ json_encode($request->context, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre></dd>
</dl>
