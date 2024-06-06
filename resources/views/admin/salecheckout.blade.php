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
        <li class="breadcrumb-item active" aria-current="page">
            Finalizar venda
        </li>
    </ol>
</nav>
<!---->

<div class="page-content">
    <div class="container">
   
          <div class="py-5 text-center">
            <span class="d-block mx-auto mb-4 bi bi-check-circle" style="font-size: 70px; color: green;"></span>
            <h2>Pedido realizado com sucesso</h2>
            <p class="lead">Detalhes da compra</p>
 

          <div class="row g-5">

            <table class="table">
              <thead>
                  <tr>
             
                      <th scope="col">Produto</th>
                      <th scope="col">Preço</th>
                      <th scope="col">Quantidade</th>

                  </tr>
              </thead>
              <tbody>
              
                  @foreach ($items as $item)
                      
                          <tr>
                              <td>{{ $item->name }}</td>
                              <td>R$ {{ number_format($item->price, 2, ',' , '.') }}</td>
      
                              <td>{{ $item->quantity }}</td>
      
      
                          </tr>
                      @endforeach
                  </tbody>
                  <h5>Valor total: R$ {{ number_format(\Cart::getTotal(), 2, ',', '.') }}</h5>
              </table>

          </div>
          <br>
          <div class="container">
            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <a href="{{ route('displayproducts') }}" class="btn btn-success" type="button"><i
                    class="bi bi-arrow-left"></i> Voltar</a>
              </div>
          </div>
          <br>
          <br>

    </div>
</div>
@endsection