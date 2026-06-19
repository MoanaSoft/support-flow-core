@extends('support-flow::adminlte.admin.layout')

@section('support-flow-content')
    <div class="card">
        <div class="card-header">Demande #{{ $request->getKey() }}</div>
        <div class="card-body">
            @include('support-flow::partials.request-detail', ['request' => $request])
        </div>
    </div>
@endsection
