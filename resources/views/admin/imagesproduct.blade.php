@extends('layouts.layout')
@section('content')
<!-- ADD MORE IMAGES -->


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


@endsection