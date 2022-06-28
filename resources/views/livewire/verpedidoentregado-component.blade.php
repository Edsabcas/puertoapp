<div class="container">
  @section('titulot')
  <div class=text-center>
   PEDIDOS DEL DIA 
  </div>
  @endsection
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script>
    $(document).on('click', '#Editar', function() {
  $('#editorden').modal('show');
  });
  
  </script>
   @if(Session::get('rolus')!=null and (Session::get('rolus')=='1' or Session::get('rolus')=='7'))

    <div class="table-responsive">
    <table class="table align-items-center mb-0">
      <thead>
        <tr  class="align-middle text-sm">
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mesa</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha Atencion</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Monto Consumido</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado Pedido</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">DETALLE</th>
        </tr>
      </thead>
      <tbody>
           @if($pedidos!=null)
          @foreach ($pedidos as $pedido)
          <tr>
            @if($pedido->ID_MESA!=null)
            @foreach($mesass as $mesa)
            @if($mesa->ID_MESA ==$pedido->ID_MESA)
            <td class="align-middle text-center text-sm">
          <span class="text-xs font-weight-bold">
            {{$mesa->NO_MESA}}
          </span>
      </td>
          @endif
          @endforeach
          @else
          <td class="align-middle text-center text-sm">
            <span class="text-xs font-weight-bold"> N/A </span>
        </td>
            @endif
            <td class="align-middle text-center text-sm">
              <span class="text-xs font-weight-bold">
                {{$pedido->FECHA_CREACION_PEDIDO}}
              </span>
          </td>
          <td class="align-middle text-center text-sm">
              <span class="text-xs font-weight-bold">
               Q. {{$pedido->MONTO_CUENTA}}
              </span>
          </td>
            <td class="align-middle text-center text-sm">
                @if($pedido->cancelado==0)
                <span class="badge bg-danger"> Pendiente de Cobro</span>
                @elseif($pedido->cancelado==1)
                <span class="badge rounded-pill bg-warning text-dark">Alerta Generada/pendiente cobro</span>
                @elseif($pedido->cancelado==2)
                <span class="badge rounded-pill bg-warning text-dark">Comprobante Generado/ Pendiente pago</span>
                @elseif($pedido->cancelado==3)
                <span class="badge badge-sm bg-gradient-success">Pagado</span>
                @endif
            </td>
           
          <td >         
          <a  class="material-icons text-sm me-2"  wire:click="editat('{{$pedido->ID_PEDIDO}}','{{$pedido->NO_PEDIDO}}','{{$pedido->ID_MESA}}','{{$pedido->ID_EMPLEADO}}','{{$pedido->MONTO_CUENTA}}','{{$pedido->ESTADO_PEDIDO}}','{{$pedido->FECHA_CREACION_PEDIDO}}','{{$pedido->cancelado}}','{{$pedido->ESTADO_EXTRA}}')">
            <button type="button" id="Editar" class="btn btn-link text-dark px-3 mb-0" title="Ver">
              <i class="material-icons text-sm me-2">edit</i>
          </button>
        </a>
        @include('pedido.modalverpedidoentregado')
          </td>
    
        </tr>
          @endforeach
          @endif
      </tbody>
    </table>
  </div>

  @else
  <div class="table-responsive">
    <table class="table align-items-center mb-0">
      <thead>
        <tr  class="align-middle text-sm">
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Usuario</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tiempo</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ROL</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha Creacion</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha Cambio</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Mesa | T. Pedido</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Detalle</th>
        </tr>
      </thead>
      <tbody>
           @if($logreg!=null)
          @foreach ($logreg as $logre)
        <tr>
          <td>{{$logre->us}}</td>
          <td>{{$logre->tiempo}}</td>
          <td>{{$logre->rol}}</td>
          <td>{{$logre->fecha_pedido}}</td>
          <td>{{$logre->fecha_cambio}}</td>
          <td>{{$logre->TIPO_PEDIDO}}</td>
          <td >         
            <a  class="material-icons text-sm me-2"  wire:click="buscarm({{$logre->id_pedido}})">
              <button type="button" id="Editar" class="btn btn-link text-dark px-3 mb-0" title="Ver">
                <i class="material-icons text-sm me-2">edit</i>
            </button>
          </a>
          @include('pedido.modalverpedidoentregado')
            </td>
        </tr>
           
          @endforeach
          @endif
      </tbody>
    </table>
  </div>

  @endif
  </div>
</div>
