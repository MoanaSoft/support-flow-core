@extends('support-flow::adminlte.admin.layout')

@section('support-flow-content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Top demandes</div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead><tr><th>Intent</th><th>Total</th></tr></thead>
                        <tbody>
                            @foreach($topIntents as $intent)
                                <tr><td>{{ $intent->intent }}</td><td>{{ $intent->total }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Événements</div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead><tr><th>Type</th><th>Total</th></tr></thead>
                        <tbody>
                            @foreach($eventsByType as $event)
                                <tr><td>{{ $event->event_type }}</td><td>{{ $event->total }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
