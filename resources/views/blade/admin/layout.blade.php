@extends('moanasoft-foundation::blade.layout')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">SupportFlow</h1>
            <nav class="d-flex gap-3">
                <a href="{{ route(config('support-flow.routes.backoffice.name', 'moanasoft.support-flow.backoffice.').'dashboard') }}">Dashboard</a>
                <a href="{{ route(config('support-flow.routes.backoffice.name', 'moanasoft.support-flow.backoffice.').'stats') }}">Stats</a>
                <a href="{{ route(config('support-flow.routes.backoffice.name', 'moanasoft.support-flow.backoffice.').'requests.index') }}">Demandes</a>
            </nav>
        </div>

        @yield('support-flow-content')
    </div>
@endsection
