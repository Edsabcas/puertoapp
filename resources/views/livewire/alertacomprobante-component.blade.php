<div class="container">
    @if(Session::get('estado')!=null)
    {{session()->forget('estado');}}
    <div class="alert alert-success" role="alert">
       Alerta enviada a caja.
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
    <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingOne">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                  Seleccionar Mesa:
            </button>
          </h2>
          <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
                <div class="row">
                    @foreach($pedidos as $pedido)
                    @foreach($mesas as $mesa)
                    @if($mesa->ID_MESA == $pedido->ID_MESA)
                    @if($pedido->extra == 0 or $pedido->extra == 4)
                    @include('cuenta.modalalerta')
                    <div class="list-group">
                    <a class="btn btn-link text-dark px-3 mb-0">
                        <button type="button" class="btn btn-link text-dark px-3 mb-0" data-bs-toggle="modal" data-bs-target="#alerta{{$mesa->ID_MESA}}"title="Alerta Caja">
                            Mesa #: <b> {{$mesa->NO_MESA}}</b> 
                        </button>
                      </a>
                </div>

                @endif
                  @endif
                  @endforeach
                  @endforeach
                  </div>
                  </div>
          </div>
        </div>
    </div>
</div>
