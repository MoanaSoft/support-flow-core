@extends('support-flow::blade.admin.layout')

@section('support-flow-content')
    <div class="row g-3 mb-4">
        @foreach($stats as $label => $value)
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-muted small">{{ str($label)->replace('_', ' ')->headline() }}</div>
                        <div class="fs-3 fw-bold">{{ $value }}{{ $label === 'deflection_rate' ? '%' : '' }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <h2 class="h5">Dernières demandes</h2>
    @include('support-flow::partials.requests-table', ['requests' => $latestRequests])
@endsection
