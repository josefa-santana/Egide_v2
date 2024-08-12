@extends('layouts.layout')
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
      <a class="link-body-emphasis fw-semibold text-decoration-none" href="#">Relatórios</a>
    </li>

  </ol>
</nav>
<!---->

<!-- ERROR MESSAGES -->
<div class="page-content">

  <button class="btn btn-success btn-lg" onclick="generatePdf()">Gerar PDF</button>  




  <div class="cards">
    <div class="card">
      <div class="card-content">
        <div class="number">{{ $products }}</div>
        <div class="card-name">Produtos cadastrados</div>
      </div>
      <div class="icon-box">
        <i class="bi bi-inboxes"></i>
      </div>
    </div>

    <div class="card">
      <div class="card-content">
        <div class="number">{{$user}}</div>
        <div class="card-name">Usuários cadastrados</div>
      </div>
      <div class="icon-box">
        <i class="bi bi-people"></i>
      </div>
    </div>

    <div class="card">
      <div class="card-content">
        <div class="number">{{ $order }}</div>
        <div class="card-name">Vendas realizadas</div>
      </div>
      <div class="icon-box">
        <i class="bi bi-cart-check"></i>
      </div>
    </div>

    <div class="card">
      <div class="card-content">
        <div class="number"> Laratrust</div>
        <div class="card-name">Painel </div>
      </div>
      <div class="icon-box">
      <a href="{{ url('admin/index-users') }}"> <i class="bi bi-gear"></i></a>
      </div>
    </div>

  </div>

  <div class="row container ">
    <section class="graficos col s12 m6" >            
      <div class="grafico card z-depth-4">
          <h5 class="center"> Relação de produtos</h5>
            <canvas id="myChart" width="400" height="150"></canvas>
            <script>
              const quantUser = @json($user);
       
              const prodNome = {!! json_encode($prodName) !!};
              console.log(prodNome);
              const qtdStockP = {!! json_encode($qtdStockP) !!};
              console.log(qtdStockP);

              document.addEventListener('DOMContentLoaded', function () {
              const ctx = document.getElementById('myChart');
              const myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels: prodNome ,//,['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange']
                      datasets: [{
                          label: 'Quantidade em estoque!',
                          data: qtdStockP, //[12, 19, 3, 5, 4, 3] 
                          backgroundColor: [],
                          borderColor: [],
                          borderWidth: 1
                      }]
              },
              options: {
                        scales:{
                          yAxes: [{
                            ticks: {
                              beginAtZero: true,
                              stepSize: 5
                            }
                          }]
                        }
                      }
              });
          }, true);


          function generatePdf() {
                const data = {
                    prodNome: prodNome,
                    qtdStockP: qtdStockP,
                    quantUser: quantUser,
                    _token: '{{ csrf_token() }}'
                };

                fetch("{{ route('gerarpdf') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'report.pdf';
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                })
                .catch(error => console.error('Error:', error));
            }
            </script>
            
      </div>  
             
    </section>             
</div>




  <!--<div class="charts">

    <div class="chart doughnut-chart">
        <h2>Employees</h2>
        <div>
            <canvas id="doughnut"></canvas>
        </div>
    </div>-->










  </body>
  
</html>

  @endsection

  @push('graph')
  

  @endpush