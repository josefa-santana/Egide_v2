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
            <a class="link-body-emphasis fw-semibold text-decoration-none" href="#">Venda</a>
        </li>
    </ol>
</nav>
<!---->

<div class="page-content">
    <!-- ERROR MESSAGES -->

    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <!-- <div class="row" data-masonry='{"percentPosition": true }'>-->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" data-masonry='{"percentPosition": true }'>
                @foreach ($products as $product)
                <div class="col-sm-6 col-lg-4 mb-4">
                    <a href="{{ route('viewproduct', $product->id) }}">
                        <div class="card shadow-sm">
                            <img src="/product_images/{{ $product->images[0]->image }}" alt="img" class="card-img-top"
                                max-width="100%" height="auto" preserveAspectRatio="xMidYMid slice">
                            <div class="card-body">
                                <span class="float-start">{{ $product->nome }}</span>
                                <span class="float-end">R$ {{ number_format($product->preco, 2, ',' , '.') }}</span>
                                <br>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <form action="" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantidade" value="1">
                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                            <button type="button" class="btn btn-sm btn-outline-secondary"> Ver detalhes
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"
    integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async>
</script>

@endsection