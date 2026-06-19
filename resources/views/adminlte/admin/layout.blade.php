@extends('moanasoft-foundation::adminlte.layout')

@section('title', 'SupportFlow')

@section('content_header')
    <h1>SupportFlow</h1>
@stop

@section('content')
    <div class="mb-3">
        <a class="btn btn-sm btn-outline-primary" href="{{ route(config('support-flow.routes.backoffice.name', 'moanasoft.support-flow.backoffice.').'dashboard') }}">Dashboard</a>
        <a class="btn btn-sm btn-outline-primary" href="{{ route(config('support-flow.routes.backoffice.name', 'moanasoft.support-flow.backoffice.').'stats') }}">Stats</a>
        <a class="btn btn-sm btn-outline-primary" href="{{ route(config('support-flow.routes.backoffice.name', 'moanasoft.support-flow.backoffice.').'requests.index') }}">Demandes</a>
    </div>

    @yield('support-flow-content')
@stop
