<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
            <h5 class="card-title text-center">Restaurante El Puerto</h5>
              <p class="card-title text-center">Detalle del dia | {{$fechaactual}}</p>
             <br>
           
              @foreach($pedidos as $pedido)
            @php
             $total=0;
             @endphp
                  <div class="card text-center">
                      <p class="card-title text-center">
                          Tipo Pedido:
                          @if($pedido->tipo_pedido==0)
                          <b>En Mesa</b>
                          
                          @elseif($pedido->tipo_pedido==2)
                          <b> A domicilio</b>
                         
                          @elseif($pedido->tipo_pedido==3)
                          <b>Para llevar</b>
                          
                          @elseif($pedido->tipo_pedido==4)
                          <b>Personal</b>
                          
                          @else
                          <b>...</b>
                          @endif
                      </p>
                  
                  </div>
                  <div class="card text-center">
                    <p class="card-title text-center">
                        Fecha y Hora: {{$pedido->FECHA_CREACION_PEDIDO}}
                        </p>
                </div>  
                <table class="table table-hover">
                    <thead>
                        <th>CANTIDAD</th>
                        <th>PLATILLO</th>
                        <th>OBSERVACION</th>
                        <th>SUB TOTAL</th>
                    </thead>
                <tbody> 
                    <br>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="background-color: rgb(9, 76, 139);">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @foreach($detalleped as $detallepe)
                    @if($detallepe->ID_PEDIDIO ==$pedido->ID_PEDIDO)
                    <tr>
                        <td class="text-left">{{$detallepe->CANTIDAD_SOLICITADA}}</td>
                        @if($detallepe->TITULO_PLATILLO!=null)
                        <td>{{$detallepe->TITULO_PLATILLO}}</td>
                        @else
                        <td>{{$detallepe->TITUTLO_BEBIDA}}</td>
                        @endif
                        <td>{{$detallepe->OBSERVACION}}</td>
                        <td>Q. {{$detallepe->SUB_TOTAL}}.00</td>
                      
                    </tr>
                      @php
             $total=$total+$detallepe->SUB_TOTAL;
             @endphp
                    @endif
                   
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-center"> <b>Total</b> </td>
                        <td> <b>Q. {{$total}}.00</b> </td>
                    </tr>
                </tbody>
            </table>
    <br>
    <br>  

 @endforeach

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>