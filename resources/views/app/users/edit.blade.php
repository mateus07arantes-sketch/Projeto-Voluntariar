@extends('app.layouts.template')

@section('title', 'Editar perfil')

@section('content')
    @component('app.components.form-users-edit', ['user' => $user])
    @endcomponent
@endsection
