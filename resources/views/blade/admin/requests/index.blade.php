@extends('support-flow::blade.admin.layout')

@section('support-flow-content')
    <h2 class="h5">Demandes support qualifiées</h2>
    @include('support-flow::partials.requests-table', ['requests' => $requests])
    <div class="mt-3">{{ $requests->links() }}</div>
@endsection
