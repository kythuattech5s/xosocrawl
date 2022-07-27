@extends('index')
@section('main')
    <div class="container">
        {{Support::show($currentItem,'content')}}
    </div>
@endsection