@extends('support-flow::blade.admin.layout')

@section('support-flow-content')
    <div class="row g-4">
        <div class="col-md-6">
            <h2 class="h5">Top demandes</h2>
            <table class="table">
                <thead><tr><th>Intent</th><th>Total</th></tr></thead>
                <tbody>
                    @foreach($topIntents as $intent)
                        <tr><td>{{ $intent->intent }}</td><td>{{ $intent->total }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h2 class="h5">Événements</h2>
            <table class="table">
                <thead><tr><th>Type</th><th>Total</th></tr></thead>
                <tbody>
                    @foreach($eventsByType as $event)
                        <tr><td>{{ $event->event_type }}</td><td>{{ $event->total }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
