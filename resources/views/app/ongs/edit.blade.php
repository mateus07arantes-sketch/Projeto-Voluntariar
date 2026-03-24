@extends('app.layouts.template')

@section('title', 'Editar ONG')

@section('content')
    @component('app.components.form-ongs-edit', ['ong' => $ong])
    @endcomponent
@endsection
