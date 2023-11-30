@extends('layouts.layout')
@section('titulo', 'Produtos')
@section('subtitulo', 'Adicionar produto')
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
            Cadastrar produto
        </li>
    </ol>
</nav>
<!---->

<!-- ERROR MESSAGES -->
<div class="page-content">

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


        <form action="store-product" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row mb-3">
                <label for="nome" class="col-sm-2 col-form-label">Nome</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nome">
                </div>
            </div>

            <div class="row mb-3">
                <label for="categoria" class="col-sm-2 col-form-label">Categoria</label>
                <div class="col-sm-10">
                    <input type="categoria" class="form-control" name="categoria">
                </div>
            </div>

            <div class="row mb-3">
                <label for="preco" class="col-sm-2 col-form-label">Preço</label>
                <div class="col-sm-10">
                    <input type="number" step="any" min="1" class="form-control" name="preco">
                </div>
            </div>

            <div class="row mb-3">
                <label for="fornecedor" class="col-sm-2 col-form-label">Fornecedor</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="fornecedor">
                </div>
            </div>

            <div class="row mb-3">
                <label for="quantidade" class="col-sm-2 col-form-label">Quantidade</label>
                <div class="col-sm-10">
                    <input type="number" step="any" min="1" class="form-control" name="quantidade">
                </div>
            </div>

            <div class="row mb-3">
                <label for="peso" class="col-sm-2 col-form-label">Peso</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="peso">
                </div>
            </div>


            <div class="row mb-3">
                <label for="descricao" class="col-sm-2 col-form-label">Descrição</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="descricao">
                </div>
            </div>

            <br>

            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <label id="files"><i class="las la-upload"></i>Adicionar imagens
                    <input type="file" name="images[]" accept="image/*" required multiple>
                </label>
            </div>

            <br>


            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <button class="btn btn-success me-md-2" type="submit">
                    Adicionar
                </button>

                <button class="btn btn-danger" type="button">
                    <a href="{{ route('indexproducts') }}"></a>Cancelar
                </button>
            </div>




        </form>
    </div>

    @endsection