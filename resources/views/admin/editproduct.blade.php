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



<style>
    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link  {
        background-color: #6f42c1;
        
    }

    .nav-link {
        color: #6f42c1;
    }

    .nav-link:hover,
    .nav-link:focus {
        color: #6f42c1;
}



</style>

<div class="page-content">
<ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active"  id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Editar produto</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Editar imagens</button>
  </li>

</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">...</div>
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
    
        <a href="{{ route('imagesproduct', $product->id) }}"><i  class="bi bi-images"></i></a> 




        <form action="{{ route('addimages', $product->id) }}" method="POST" enctype="multipart/form-data">
  @csrf

  <div class="input-group">
    <label id="files" class="form-control"><i class="las la-upload"></i>Adicionar imagens
      <input type="file" name="images[]" accept="image/*" multiple>

    </label>
    <button type="submit" class="btn btn-success">Salvar</button>
  </div>
</form>

<!-- DELETE IMAGES-->

<div class="album py-5 bg-body-tertiary">
  <div class="container">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" data-masonry='{"percentPosition": true }'>
      @foreach ($images as $image)
      <div class="col">
      <!--  <div class="card" style="width: 18rem;">-->
        <div class="card shadow-sm">
          <img src="/product_images/{{$image->image}}" alt="img" class="card-img-top" max-width="100%" height="auto"
            preserveAspectRatio="xMidYMid slice">

          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div class="btn-group">
                <button type="button" class="btn btn-danger">
                  <a href="{{  route('deleteimage', $image->id) }}" style="color:aliceblue">Remover</a>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>


   
    </div>

</div>


@endsection