@extends('support-flow::adminlte.admin.layout')

@section('support-flow-content')
    <div class="row">
        @foreach($stats as $label => $value)
            <div class="col-md-3">
                <div class="small-box bg-light">
                    <div class="inner">
                        <h3>{{ $value }}{{ $label === 'deflection_rate' ? '%' : '' }}</h3>
                        <p>{{ str($label)->replace('_', ' ')->headline() }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card">
        <div class="card-header">Dernières demandes</div>
        <div class="card-body p-0">
            @include('support-flow::partials.requests-table', ['requests' => $latestRequests])
        </div>
    </div>
@endsection
