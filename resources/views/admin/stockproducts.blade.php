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
            <a class="link-body-emphasis fw-semibold text-decoration-none" href="#">Estoque</a>
        </li>
    </ol>
</nav>
<!---->

<div class="page-content">

    <div class="records table-responsive">
        <div class="col-md-6" style="margin-left: 20px">
            <div class="form-group">
                <form method="GET" action="search-products">
                    <div class="input-group">
                        <input class="form-control" name="search" placeholder="Digite o nome ou código do produto"
                            value="{{ isset($search) ? $search : ''}}">
                        <button type="submit" class="btn btn" style="background: #5337FF; color:white;">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="record-header">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Valor total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @forelse ($products as $produto)
                    <tr>
                        <td scope="row">{{$produto->id}}</td>
                        <td scope="row">{{$produto->nome}}</td>
                        <td scope="row">R$ {{number_format($produto->preco, 2, ',' , '.') }}</td>
                        <td scope="row">{{$produto->stock->quantidade}}</td>
                        <td scope="row">R$ {{ number_format($produto->stock->quantidade * $produto->preco, 2, ',' , '.') }}</td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Sem produtos ainda!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

            <footer class="py-5 text-center text-body-secondary bg-body-tertiary">
                <p>Estoque total  -  {{ $total }}</p>
                <p class="mb-0">
                  Valor em estoque  -  {{ $valor_total }}
                </p>
              </footer>

@endsection