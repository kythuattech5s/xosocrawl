@extends('index')
@section('main')
    <div class="box box-detail pad10 s-content">
        {!!Support::show($currentItem,'content')!!}
    </div>
@endsection