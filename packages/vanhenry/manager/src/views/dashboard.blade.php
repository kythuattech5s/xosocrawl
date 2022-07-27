@extends('vh::master')
@section('content')
    @php
        $adminUser = \Auth::guard('h_users')->user();
    @endphp
    <p style="font-size: 20px;">Chào mừng <strong>{{Support::show($adminUser,'name')}}</strong> quay trở lại.</p>
    @if (isset($gaViewKey) && $gaViewKey !='')
        @include('vh::statistical_google_analytics')
    @endif
@stop