
<div class="container">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script>
    $(document).on('click', '#Editar', function() {
  $('#editorden').modal('show');
  });
  
  $(document).on('click', '#Eliminar', function() {
  $('#delete').modal('show');
  });
  </script>
    <section>
      
    <div class="inner">
      @if(Session::get('var')!=null)
      {{session()->forget('var');}}
      <div class="alert alert-success d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
      <div>
      Asignado Correctamente.
      </div>
      </div>
      @endif
      @if(Session::get('var2')!=null)
      {{session()->forget('var2');}}
      <div class="alert alert-success d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
      <div>
      Ya existe registrado un DPI, favor validar.
      </div>
      </div>
      @endif
      @if(Session::get('edit')!=null)
      {{session()->forget('edit');}}
      <div class="alert alert-success d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
      <div>
      Editado Correctamente.
      </div>
      </div>
      @endif
      @if(Session::get('delete1')!=null)
      {{session()->forget('delete1');}}
      <div class="alert alert-success d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
      <div>
      Eliminado Correctamente.
      </div>
      </div>
      @endif
      @if(Session::get('error')!=null)
      {{session()->forget('error');}}
      <div class="alert alert-warning d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
      <div>
      No fue posible editar.
      </div>
      </div>
      @endif
      @if(Session::get('errorllave')!=null)
      {{session()->forget('errorllave');}}
      <div class="alert alert-warning d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
      <div>
     No es posible eliminar debido a que la categoria se encuentra relacionada con algun platillo. 
      </div>
      </div>
      @endif
      </div>
    </section>
    @section('titulot')
    HISTORIAL PEDIDOS
    @endsection
    <div class="card position-relative " style="width: 18rem;">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Fecha Busqueda</label>
          <input type="date" class="form-control" wire:model="feseleccion" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <button wire:click="buscar" class="btn btn-primary">Buscar</button>
        
    </div>
    <br>  
    
    @if($fechase!=null)
    <h3>Cantidad de pedidos: <b>{{$cantidad}}</b></h3>
    <div class="table-responsive">
      <table class="table align-items-center mb-0">
        <thead>
          <tr  class="align-middle text-center text-sm">
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mesa</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha Atencion</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Consumo</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cobro</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Accion</th>
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
                  <span class="badge badge-sm bg-gradient-success">Pago Realizado</span>
                  @endif
              </td>
             
            <td >
             
              @if($pedido->cancelado<3)
              @include('pedido.eliminarpedgen')
              <a  class="material-icons text-sm me-2"><button type="button" class="btn btn-link text-dark px-3 mb-0"  data-bs-toggle="modal" data-bs-target="#delete{{$pedido->ID_PEDIDO}}"title="Eliminar">
                <i class="material-icons text-sm me-2">
                delete</i>
              </button>
            </a>
            @endif
           
            <a  class="material-icons text-sm me-2"  wire:click="editat('{{$pedido->ID_PEDIDO}}','{{$pedido->NO_PEDIDO}}','{{$pedido->ID_MESA}}','{{$pedido->ID_EMPLEADO}}','{{$pedido->MONTO_CUENTA}}','{{$pedido->ESTADO_PEDIDO}}','{{$pedido->FECHA_CREACION_PEDIDO}}','{{$pedido->cancelado}}','{{$pedido->extra}}')">
              <button type="button" id="Editar" class="btn btn-link text-dark px-3 mb-0" title="Editar">
                <i class="material-icons text-sm me-2">edit</i>
            </button>
          </a>
          @include('pedido.modaleditpedido')
          @include('pedido.modaleliminaritempedido')
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