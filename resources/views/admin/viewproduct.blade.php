@extends('layouts.layout')
@section('titulo', $product->nome)
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
            <a class="link-body-emphasis fw-semibold text-decoration-none" href="{{ route('displayproducts') }}">Venda</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            {{ $product->nome }}

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
    <div class="page-detail u-s-p-t-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                        @if($product->images)
                        <a href="/product_images/{{ $product->images[0]->image }}"
                            data-standard="/product_images/{{ $product->images[0]->image }}">
                            <img width="350" src="/product_images/{{ $product->images[0]->image }}" alt="" />
                        </a>
                    </div>
                    <div class="thumbnails" style="margin-top: 30px">
                        @foreach ($product->images as $product_image)
                        <a href="/product_images/{{ $product_image->image }}"
                            data-standard="/product_images/{{ $product_image->image }}">
                            <img width="100" src="/product_images/{{ $product_image->image }}" alt="" />
                        </a>
                        @endforeach
                        </ul>
                    </div>
                    @else
                    Sem imagens adicionadas
                    @endif
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h2 class="mb-0">
                        {{ $product->nome }}
                        <label style="font-size: 16px;" class="float-end badge bg-danger trending_tag">{{
                            $product->categoria }}</label>
                    </h2>
                    <hr>
                    <label class="fw-bold">Preço : R$ {{ $product->preco }}</label>
                    <p class="mt-3">
                        {{ $product->descricao }}
                    </p>
                    <hr>

                    <!-- stock -->
                    @if($product->stock->quantidade > 0)
                    <label class="badge bg-success">Em estoque</label>
                    <div class="col-md-10">
                        <br>
                        <form action="{{ route('addtocart') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="nome" value="{{ $product->nome }}">
                            <input type="hidden" name="preco" value="{{ $product->preco }}">
                            <input type="number" name="quantidade" value="1">
                            <br>
                            <br>
                            <button type="submit" class="btn btn-success me-3 float-start">Adicionar ao
                                carrinho
                            </button>
                        </form>

                    </div>
                    @else
                    <label class="badge bg-danger">Sem estoque</label>
                    <button type="submit" disabled class="btn btn-success me-3 float-start">Adicionar ao
                        carrinho
                    </button>
                    @endif

                    
                </div>

            </div>
        </div>
        <div class="col-md-12">
            <hr>
            <h3>Descrição</h3>
            <p class="mt-3">
                {{ $product->descricao }}
            </p>

        </div>
    </div>
</div>
</div>


@endsection