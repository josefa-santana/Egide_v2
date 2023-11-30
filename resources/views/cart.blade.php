@extends('layouts.layout')
@section('titulo', 'Produtos')
@section('subtitulo', 'Adicionar produto')
@section('content')

<!-- BREADSCRUMBS -->

<?php

use MercadoPago\Item;
use MercadoPago\Preference;
use MercadoPago\SDK;

    SDK::setAccessToken(config('services.mercadopago.token'));

    $cart = \Cart::getContent();

    $preference = new Preference();

    $itens = [];

    foreach ($cart as $produtos) {
        # code...
        $item = new Item();
        $item->title = $produtos->name;
        $item->quantity = $produtos->quantity;
        $item->unit_price = $produtos->price;
        $item->currency_id = "BRL";

        $itens[] = $item;

    }


    $preference->items = $itens;
    $preference->save();


?>


<nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-chevron p-3 bg-body-tertiary rounded-3">
        <li class="breadcrumb-item">
            <a class="link-body-emphasis" href="#">
                <i class="bi bi-house-door-fill"></i>
                <span class="visually-hidden">Home</span>
            </a>
        </li>
        <li class="breadcrumb-item">
            <a class="link-body-emphasis fw-semibold text-decoration-none"
                href="{{ route('displayproducts') }}">Vendas</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Carrinho
        </li>
    </ol>
</nav>
<!---->

<div class="page-content">

    <!-- ERRORS MESSAGE -->
    @if($message = Session::get('message'))
    <div class="alert alert-success">
        {{ session()->get('message'); }}
    </div>
    @endif

    @if($message = Session::get('warning'))
    <div class="alert alert-warning">
        {{ session()->get('warning'); }}
    </div>
    @endif
    <!--  -->

    @if ($items->count() == 0) 

    <div class="alert alert-warning">
        <span>Carrinho vazio!</span>
    </div>


    @else

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Preço</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            @if($product->stock->quantidade == 0)
                    <p>Sem estoque</p>

            @endif
            @endforeach
        
            @foreach ($items as $item)

                    
                
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>{{ $item->name }}</td>
                        <td>R$ {{ number_format($item->price, 2, ',' , '.') }}</td>

                        <td>R$ {{ number_format(\Cart::getSubtotal(), 2, ',', '.') }}</td>
                        

                        {{-- BTN UPDATE --}}
                            <form action="{{ route('updatecart') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <td><input style="width: 50px" type="number" name="quantity" min="1" value="{{ $item->quantity }}">
                                </td>
                                <td>

                                    <button class="btn btn-bd-primary">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>

                                </form>

                                {{-- BTN DELETE --}}
                                <form action="{{ route('deletecart') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id }}">

                                    <button class="btn btn-bd-primary">
                                        <i class="bi bi-trash3"></i>
                                    </button>

                                </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
            <br>
            <form action="{{  route('finishsale')  }}" method="POST">
                @csrf
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <button  class="btn btn-success" style="border:none;" type="submit"> 

                    Finalizar venda
                </button>
                </div>
            </div>
            </form>

            
            <br>


        <h5>Valor total: R$ {{ number_format(\Cart::getTotal(), 2, ',', '.') }}</h5>
        @endif

    <br>

                <div class="container">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('displayproducts') }}" class="btn btn-bd-primary" type="button"><i
                            class="bi bi-arrow-left"></i> Continuar
                        comprando</a>
                        <a href="{{ route('clearcart') }}" class="btn btn-danger" type="button">Limpar carrinho <i
                            class="bi bi-x-lg"></i></a>
                    </div>
                <br>

            <div class="d-grid gap-2 col-6 mx-auto">
            

    </div>


    
    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script>
        const mp = new MercadoPago("{{config('services.mercadopago.key')}}");

     
        mp.checkout({
            preference: {
                id: '{{ $preference->id }}'
            },
            render: {
                container: '.venda',
                label: 'Finalizar pedido',
            }
        });


    </script>



    



    @endsection