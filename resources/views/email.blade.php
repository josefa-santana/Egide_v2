

<!DOCTYPE html>
<html lang="en">
<head>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Egide - Contato</title>
            <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

</head>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="/email">Contato </a>

  <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/"> Home Page</a>
      </li>
    </ul>

  </div>
</nav>
<div class=" mt-5 container-fluid">
    <div class="container">
        <div class="row ">
            <div class="col border border-dark text-light text-left" id="informContact" style="background: url('/img/egide_shield.png'); 
            background-repeat:no-repeat; background-position:center center; background-size:cover; background-color: #000" >
            <div class="text-center">
                <div class="mt-5  ">
                    <p class="font-weight-normal">&#9872 Nossa sede</p>     
                    <p>São Paulo - Guarulhos</p>  
                </div>

                <div class="mt-5">
                    <p class="font-weight-normal">&#9743 Que tal uma ligação?</p>     
                    <p class="text-info">+55 11 4002-8922</p>  
                </div>

                <div class="mt-5">
                    <p class="text-monospace">&#9990 Podemos nos falar por Whatsapp!</p>     
                    <p class="text-info">+55 11 99976-9021</p>  
                </div>

                
                <div class="mt-5">
                    <p class="font-weight-normal">&#9993 Caso prefira falar com o time comercial</p>     
                    <p class="text-info">comercial@egide.com</p>  
                </div>
            </div>
            </div>
            <div class="col border border-dark">
            
                <div class="text-center mt-3 contact100-pic js-tilt" data-tilt>
					<h1><a href="/">Égide</a></h1>
				</div>

				<form action="{{ route('send.email') }}" class="contact100-form validate-form" method="post">
                    @csrf
					<h5 class="text-center">
						Nós envie um email!
                    </h5>
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif

					<div class="wrap-input100 validate-input" data-validate = "Informe seu nome e sobrenome">
                        <label for="name" class="">Nome e Sobrenome</label>
						<input class="form-control input100" type="text" name="name" placeholder="Como podemos te chamar?">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                        @error('name')
                            <span class="text-danger"> {{ $message }} </span>
                        @enderror
                    </div>

					<div class="wrap-input100 validate-input" data-validate = "Digite um email válido: teste.comercial@exemplo.com">
						<label for="email" class="mt-1">Email</label>
                        <input class="form-control input100" type="text" name="email" placeholder="Informe seu melhor email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
                    </div>
                    
                    <div class="wrap-input100 validate-input" data-validate = "Por favor informe um assunto para sua mensagem">
		        		<label for="subject" class="mt-1">Assunto</label>
                        <input class="form-control input100" type="text" name="subject" placeholder="Assunto do Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                        @error('subject')
                            <span class="text-danger"> {{ $message }} </span>
                        @enderror
                        </div>
    

					<div class="wrap-input100 validate-input" data-validate = "Não deixe sua mensagem em branco!!!">
						<label for="message" class="mt-1">Digite aqui sua mesagem!</label>
                        <textarea class="form-control md-textarea input100" name="content" rows="5" placeholder="Não esqueça de se apresentar! :)"></textarea>
                        <span class="focus-input100"></span>
                        @error('content')
                           <span class="text-danger"> {{ $message }} </span>
                        @enderror
                    </div>
                
					<div class="mt-2 mb-3 text-center container-contact100-form-btn">
						<button type="submit" class=" btn btn-success btn-sm contact100-form-btn">
							Enviar
						</button>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
</body>
</html>