@extends('layouts.layout')
@section('titulo', 'Produtos')
@section('subtitulo', 'Consultar produto')
@section('content')


<!-- BREADSCRUMBS -->

<nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-chevron p-3 bg-body-tertiary rounded-3">
        <li class="breadcrumb-item">
            <a class="link-body-emphasis" href="#">
                <i class="bi bi-house-door-fill"></i>
                <span class="visually-hidden">Home</span>
            </a>
        </li>
        <li class="breadcrumb-item">
            <a class="link-body-emphasis fw-semibold text-decoration-none" href="#">Produtos</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Configurações
        </li>
    </ol>
</nav>
<!---->


<div class="page-content">
    <!-- ERRORS MESSAGE -->
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message'); }}

    </div>
    @endif
    <!---->

     <!-- EDIT Quantity -->
    <form action="{{ route('updatequantity', $quantity_info->id) }}" method="POST">
        @csrf
        <input type="hidden" value="{{ $quantity_info->id }}" name="id">

        <div class="row mb-3">
            <label for="quantidade_minima" class="col-sm-2 col-form-label">Estoque minimo</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="quantidade_minima" value="{{ $quantity_info->quantidade_minima}}">
            </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            <button type="submit" class="btn btn-success me-md-2">Salvar alterações</button>
        </div>

    </form>

@endsection
