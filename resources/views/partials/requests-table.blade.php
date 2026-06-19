<table class="table table-striped mb-0">
    <thead>
        <tr>
            <th>#</th>
            <th>Instance</th>
            <th>Intent</th>
            <th>Sujet</th>
            <th>Statut</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse($requests as $supportRequest)
            <tr>
                <td><a href="{{ route(config('support-flow.routes.backoffice.name', 'moanasoft.support-flow.backoffice.').'requests.show', $supportRequest->getKey()) }}">{{ $supportRequest->getKey() }}</a></td>
                <td>{{ $supportRequest->instance }}</td>
                <td>{{ $supportRequest->intent }}</td>
                <td>{{ $supportRequest->subject }}</td>
                <td>{{ $supportRequest->status }}</td>
                <td>{{ $supportRequest->created_at?->format('d/m/Y H:i') }}</td>
            </tr>
        @empty
            <tr><td colspan="6">Aucune demande.</td></tr>
        @endforelse
    </tbody>
</table>
