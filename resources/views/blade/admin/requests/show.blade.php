@extends('support-flow::blade.admin.layout')

@section('support-flow-content')
    <h2 class="h5">Demande #{{ $request->getKey() }}</h2>
    @include('support-flow::partials.request-detail', ['request' => $request])
@endsection
