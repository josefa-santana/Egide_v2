@extends('layouts.layout')
@section('titulo', 'Produtos')
@section('subtitulo', 'Consultar produto')
@section('content')


<!-- BREADSCRUMBS -->

<style>
    .primary {
        color: black;
    }
</style>

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
            Consultar produto
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
    <!--  -->
    <div class="records table-responsive">

        <div class="col-md-6" style="margin-left: 20px">
            <div class="form-group">
                <form method="GET" action="search-products">
                    <div class="input-group">
                        <input class="form-control" name="search" placeholder="Search..."
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
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @forelse ($products as $produto)
                    <tr>
                        <td scope="row">{{$produto->id}}</td>
                        <td scope="row">{{$produto->nome}}</td>
                        <td>
                            <div class="actions">
                                <button class="btn btn-bd-primary">
                                    <a href="{{route('editproduct', $produto->id)}}" style="color: black" ><i
                                            class="bi bi-pencil-square"></i></a>
                                </button>

                                <button type="button" class="btn btn-bd-primary" style="color: black" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <i class="bi bi-trash3"></i>
                                </button>

                                <!--MODAL DELETE-->
                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Você tem certeza que deseja remover esse produto?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <button type="button" class="btn btn-success">
                                                    <a href="{{ route('deleteproduct', $produto->id) }}"
                                                        style="color:black;">
                                                        Sim
                                                    </a>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-bd-primary">
                                    <a href="{{ route('imagesproduct', $produto->id) }}" style="color:black;"><i
                                            class="bi bi-images"></i></a>
                                </button>
                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Sem produtos ainda!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>




            @endsection