@extends('layouts.layout')
@section('titulo', 'Produtos')
@section('subtitulo', 'Editar produto')
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
            Editar produto
        </li>
    </ol>
</nav>
<!---->


<div class="page-content">
    <!-- ERROR MESSAGES -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!---->

    <!-- EDIT PRODUCT -->
    <form action="{{ route('updateproduct', $product_info->id) }} " method="POST">
        @csrf
        <input type="hidden" value="{{ $product_info->id }}" name="id">

        <div class="row mb-3">
            <label for="nome" class="col-sm-2 col-form-label">Nome</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="nome" value="{{ $product_info->nome }}">
            </div>
        </div>

        <div class="row mb-3">
            <label for="categoria" class="col-sm-2 col-form-label">Categoria</label>
            <div class="col-sm-10">
                <input type="categoria" class="form-control" name="categoria" value="{{ $product_info->categoria }}">
            </div>
        </div>

        <div class="row mb-3">
            <label for="preco" class="col-sm-2 col-form-label">Preço</label>
            <div class="col-sm-10">
                <input type="number" step="any" min="1" class="form-control" name="preco"
                    value="{{ $product_info->preco }}">
            </div>
        </div>

        <div class="row mb-3">
            <label for="fornecedor" class="col-sm-2 col-form-label">Fornecedor</label>
            <div class="col-sm-10">
                <input type="text" name="fornecedor" class="form-control" value="{{ $product_info->fornecedor }}">
            </div>
        </div>

        <div class="row mb-3">
            <label for="quantidade" class="col-sm-2 col-form-label">Quantidade</label>
            <div class="col-sm-10">
                <input type="number" step="any" min="1" class="form-control" name="quantidade"
                    value="{{ $product_info->stock->quantidade }}">
            </div>
        </div>

        <div class="row mb-3">
            <label for="peso" class="col-sm-2 col-form-label">Peso</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="peso" value="{{ $product_info->peso }}">

            </div>
        </div>

        <div class="row mb-3">
            <label for="descricao" class="col-sm-2 col-form-label">Descrição</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="descricao" value="{{ $product_info->descricao }}">
            </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            <button type="submit" class="btn btn-success me-md-2">Salvar alterações</button>
        </div>

    </form>
</div>


@endsection