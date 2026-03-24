@extends('app.layouts.template')

@section('title', 'Login')

@section('content')
    @component('app.components.form-login')
    @endcomponent
@endsection