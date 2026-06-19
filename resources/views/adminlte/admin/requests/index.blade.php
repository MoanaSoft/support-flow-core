@extends('support-flow::adminlte.admin.layout')

@section('support-flow-content')
    <div class="card">
        <div class="card-header">Demandes support qualifiées</div>
        <div class="card-body p-0">
            @include('support-flow::partials.requests-table', ['requests' => $requests])
        </div>
        <div class="card-footer">{{ $requests->links() }}</div>
    </div>
@endsection
