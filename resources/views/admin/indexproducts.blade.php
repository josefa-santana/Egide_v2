@extends('layouts.layout')
@section('titulo', 'Produtos')
@section('content')
<style>
    .card-outer {
        display: flex;
        justify-content: center;
        margin-top: 10%;
        /*min-height: 100vh;*/
    }

    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        width: 30%;
        float: left;
        margin-left: 15px;
        align-self: center;
        background-color: rgb(113, 58, 166);
        border-radius: 0.6em;

    }

    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }


</style>

<head>
    <style>

    </style>
</head>

<body>

    <div class="card-outer">
        <div class="card">
            <div class="container" style="justify-items: center;font-size:0.7rem;">
                <a href="{{ route('createproduct') }}">
                    <p style="text-align:center;color:aliceblue;">
                        <b>Cadastrar Produto</b>
                        <b>
                            <i class="bi bi-search"></i>
                        </b>

                    </p>
                </a>
            </div>
        </div>

        <div class="card">
            <div class="container" style="justify-items: center;font-size:0.7rem;">
                <a href="{{ route('allproducts') }}">
                    <p style="text-align:center;color:aliceblue;">
                        <b>Consultar Produto</b>
                    </p>
                </a>
            </div>
        </div>
    </div>

</body>



@endsection