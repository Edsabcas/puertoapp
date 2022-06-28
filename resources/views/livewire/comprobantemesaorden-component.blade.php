<div class="container">
  @if(Session::get('var')!=null)
  {{session()->forget('var');}}
  <div class="alert alert-success" role="alert">
      Agregado Correctamente.
    </div>
  @endif

  @if(Session::get('creado')!=null)
  {{session()->forget('creado');}}
  <div class="alert alert-success" role="alert">
      Cobro almacenado correctamente.
    </div>
  @endif

  @if(Session::get('edit')!=null)
  {{session()->forget('edit');}}
  <div class="alert alert-warning" role="alert">
      Editado Correctamente.
    </div>
  @endif

  @if(Session::get('error')!=null)
  {{session()->forget('error');}}
  <div class="alert alert-danger" role="alert">
      No fue posible editar.
  </div>
  @endif 
  @if(Session::get('delete1')!=null)
  <div class="alert alert-light" role="alert">
    Se cancelo el pedido Correctamente.
  </div>
  {{session()->forget('delete1');}}
  @endif
    <div class="accordion accordion-flush" id="accordionFlushExample">
      <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                Comprobante a generar?
          </button>
        </h2>
        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
              <div class="row"  style="font-size: 35px; text-align: center;">
                <div class="input-group input-group-outline mb-3">
                  <div class="form-check">
                    <input class="form-check-input" wire:click="tipo_pedido(1)"  type="radio" name="flexRadioDefaults" id="flexRadioDefaults1">
                    <label class="form-check-label" for="flexRadioDefaults1">
                     En Mesa
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" wire:click="tipo_pedido(2)"  type="radio" name="flexRadioDefaults" id="flexRadioDefaultss2" >
                    <label class="form-check-label" for="flexRadioDefaultss2">
                      A Domicilio
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" wire:click="tipo_pedido(3)"  type="radio" name="flexRadioDefaults" id="flexRadioDefaults3" >
                    <label class="form-check-label" for="flexRadioDefaults3">
                     Para Llevar
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" wire:click="tipo_pedido(4)"  type="radio" name="flexRadioDefaults" id="flexRadioDefaults4" >
                    <label class="form-check-label" for="flexRadioDefaults4">
                     Pedido Interno
                    </label>
                  </div>
                    </div>
                </div>
                </div>

        </div>
      </div>
@if($op==1)
<div class="accordion-item">
  <h2 class="accordion-header" id="flush-headingOne1">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne1" aria-expanded="false" aria-controls="flush-collapseOne1">
          Mesa:
    </button>
  </h2>
  <div id="flush-collapseOne1" class="accordion-collapse" aria-labelledby="flush-headingOne1" data-bs-parent="#accordionFlushExample">
    <div class="accordion-body">
        <div class="row">
            @foreach($pedidos as $pedido)
            @if($pedido->tipo_pedido==0)
            @foreach($mesas as $mesa)
            @if($mesa->ID_MESA == $pedido->ID_MESA)
            @if($pedido->extra == 0 or $pedido->extra == 1)
            @include('cuenta.modalalerta')
            <div class="list-group">
            <a class="btn btn-link text-dark px-3 mb-0">
                <button type="button"  style="font-size: 25px; text-align: center;" class="btn btn-link text-dark px-3 mb-0" wire:click="busquedacuenta('{{$mesa->ID_MESA}}','{{$mesa->NO_MESA}}','{{$pedido->cancelado}}')">
                    Mesa #: <b> {{$mesa->NO_MESA}}</b> 
                </button>
              </a>
        </div>

        @endif
          @endif
          @endforeach
          @endif
          @endforeach
          </div>
          </div>

  </div>
</div>
@elseif($op==2)
<div class="accordion-item">
  <h2 class="accordion-header" id="flush-headingOne2">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne2" aria-expanded="false" aria-controls="flush-collapseOne2">
         Pedidos A Domicilio
    </button>
  </h2>
  <div id="flush-collapseOne2" class="accordion-collapse" aria-labelledby="flush-headingOne2" data-bs-parent="#accordionFlushExample">
    <div class="accordion-body">
        <div class="row">
            @foreach($pedidos as $pedido)
            @if($pedido->tipo_pedido==2)
            <div class="list-group">
            <a class="btn btn-link text-dark px-3 mb-0">
                <button type="button" class="btn btn-link text-dark px-3 mb-0" wire:click="busquedacuenta2('{{$pedido->cancelado}}','{{$pedido->ID_PEDIDO}}')">
                    Cliente: <b> {{$pedido->nombre_cliente}}</b> 
                </button>
              </a>
        </div>
          @endif
          @endforeach
          </div>
          </div>

  </div>
</div>


@elseif($op==3)
<div class="accordion-item">
  <h2 class="accordion-header" id="flush-headingOne3">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne3" aria-expanded="false" aria-controls="flush-collapseOne3">
         Pedidos para llevar:
    </button>
  </h2>
  <div id="flush-collapseOne3" class="accordion-collapse " aria-labelledby="flush-headingOne3" data-bs-parent="#accordionFlushExample">
    <div class="accordion-body">
        <div class="row">
            @foreach($pedidos as $pedido)
            @if($pedido->tipo_pedido==3)
            <div class="list-group">
            <a class="btn btn-link text-dark px-3 mb-0">
                <button type="button" class="btn btn-link text-dark px-3 mb-0" wire:click="busquedacuenta2('{{$pedido->cancelado}}','{{$pedido->ID_PEDIDO}}')">
                    Cliente: <b> {{$pedido->nombre_cliente}}</b> 
                </button>
              </a>
        </div>
          @endif
          @endforeach
          </div>
          </div>

  </div>
</div>

@elseif($op==4)
<div class="accordion-item">
  <h2 class="accordion-header" id="flush-headingOneaaa">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOneaaa" aria-expanded="false" aria-controls="flush-collapseOneaaa">
        Pedidos  del personal:
    </button>
  </h2>
  <div id="flush-collapseOneaaa" class="accordion-collapse" aria-labelledby="flush-headingOneaaa" data-bs-parent="#accordionFlushExample">
    <div class="accordion-body">
        <div class="row">
            @foreach($pedidos as $pedido)
            @if($pedido->tipo_pedido==4)
            <div class="list-group">
            <a class="btn btn-link text-dark px-3 mb-0">
                <button type="button" class="btn btn-link text-dark px-3 mb-0" wire:click="busquedacuenta2('{{$pedido->cancelado}}','{{$pedido->ID_PEDIDO}}')">
                    Empleado: <b> {{$pedido->nombre_cliente}}</b> 
                </button>
              </a>
        </div>
          @endif
          @endforeach
          </div>
          </div>

  </div>
</div>
@endif
        @if($nopedido!=null)
        <div class="accordion-item">
          @php 
          $subtotalp=0;
          $subtotalex=0;
          $sumacuenta=0;
          $valorpro=0;
          @endphp
          <h2 class="accordion-header" id="flush-collapseFOR222">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFOR222" aria-expanded="false" aria-controls="flush-collapseFOR222">
              <h4 class="font-weight-bolder">Detalles:   </h4>
            </button>
          </h2>
          <div id="flush-collapseFOR222" class="accordion-collapse" aria-labelledby="flush-collapseFOR222" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
              <form wire:submit.prevent="" class="form-floating">
                
                <div class="row">
                  <div class="table-responsive">
                  <table class="table table-hover">
                      <thead>
                         <tr>

                        
                          <th>
                            @if($cancelado==2)
                            <button class="btn btn-primary" wire:click="cargainfo()">Imprimir</button>
                          @endif
                          </th>
                          <th></th>
                          <th class="text-center"><p>
                             <p> <b> Pedido Mesa. # {{$no_mesa}}</b> </p>
                             <p>{{$fecha}}</p>
                             <p>Mesero: {{$nombreMesero}}</p>
                          </p>
                          </th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <thead>
                        <th >Cantidad</th>
                        <th >Titulo</th>
                        <th >Observacion</th>
                        <th >Costo</th>
                        <th >Totales</th>
                        <th>Accion</th>
                        <th>Estado</th>
                      </thead>
                      <tbody>
            
                  @foreach(Session::get('detallepedidos') as $detalle_p)
                  @php
                      $listo=0;
                  @endphp
                  <tr>
                  @foreach(Session::get('platillosc') as $platillo)

                  @if($detalle_p->ID_PLATILLO==$platillo->ID_PLATILLO && $detalle_p->extra==0)
                  
                  @php
                  $subtotalp=$subtotalp+(($detalle_p->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+($detalle_p->costo_cambio-$detalle_p->costo_guarnicion)); @endphp

                  <td class="text-center">{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                      <td> {{$platillo->TITULO_PLATILLO}}</td>
                      @if(strlen($detalle_p->OBSERVACION)>3)
                      <td><b><span class="badge bg-warning text-dark">{{$detalle_p->OBSERVACION}}</span></b></td>
                      @else
                      <td> {{$detalle_p->OBSERVACION}} </td>
                      @endif
                      <td>Q. {{$platillo->COSTO_PLATILLO}}</td>
                      <td>Q. {{(($detalle_p->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+($detalle_p->costo_cambio-$detalle_p->costo_guarnicion))}} </td>
                      @if($detalle_p->OBSERVACION=="N/A")                      
                      <td></td>
                      @else
                      <td>
                        <div class="row g-2">
                          <div class="col-md">
                          <label class="form-label">Cambio: </label>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(1)" id="inlineRadio1" value="option1">
                            <label class="form-check-label" for="inlineRadio1">Si</label>
                          </div>
                       
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(2)" id="inlineRadio2" value="option2">
                            <label class="form-check-label" for="inlineRadio2">No</label>
                          </div>
                        </div>
                        <div class="col-md">
                          <div class="input-group input-group-outline mb-2">
                            <input type="text" class="form-control" wire:model="valorcambio" placeholder="Q.">
                          </div>
                        </div>
                        <div class="col-md">
                          <div class="form-check form-check-inline">
                            <button type="button" class="btn btn-primary" wire:click="advalorcambio('{{$detalle_p->ID_DETALLE_PEDIDO}}','{{$detalle_p->ID_PEDIDIO}}')" title="Conf Orden">+</button>
                        </div>
                      </div>
                      </div>
                   
                      </td>
                      @endif
                      @if($pedido->ESTADO_PEDIDO<=2)
                      @php
                      $listo=$listo+1;
                      @endphp
                      <td>
                        <span class="badge bg-danger">Pendiente E.</span>
                      </td>
                      @else
                      <td></td>
                      @endif
                       @endif
                       @endforeach
                
                  @foreach(Session::get('bebidasc') as $bebida)
                  @if( $detalle_p->ID_PLATILLO == $bebida->ID_BEBIDA  && $detalle_p->extra==0)
                  @php
                 $subtotalp=$subtotalp+$detalle_p->SUB_TOTAL;  @endphp
                  <?php$ca=$ca+1;?>
                  <td class="text-center">{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                  <td>  {{$bebida->TITUTLO_BEBIDA}} </td>
                  <td> {{$detalle_p->OBSERVACION}} </td>
                  <td>Q. {{$bebida->COSTO_BEBIDA}}</td>
                  <td>Q. {{$detalle_p->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA+($detalle_p->costo_cambio-$detalle_p->costo_guarnicion)}} </td>
                  @if($detalle_p->OBSERVACION=="N/A")                      
                  <td></td>
                  @else
                  <td>
                    <div class="row g-2">
                      <div class="col-md">
                      <label class="form-label">Cambio: </label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(1)" id="inlineRadio1" value="option1">
                        <label class="form-check-label" for="inlineRadio1">Si</label>
                      </div>
                   
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(2)" id="inlineRadio2" value="option2">
                        <label class="form-check-label" for="inlineRadio2">No</label>
                      </div>
                    </div>
                    <div class="col-md">
                      <div class="input-group input-group-outline mb-2">
                        <input type="text" class="form-control" wire:model="valorcambio" placeholder="Q.">
                      </div>
                    </div>
                    <div class="col-md">
                      <div class="form-check form-check-inline">
                        <button type="button" class="btn btn-primary" wire:click="advalorcambio('{{$detalle_p->ID_DETALLE_PEDIDO}}','{{$detalle_p->ID_PEDIDIO}}')" title="Conf Orden">+</button>
                    </div>
                  </div>
                  </div>
               
                  </td>
                  @endif
                
                  @if($pedido->ESTADO_PEDIDO<=2)
                  @php
                  $listo=$listo+1;
                  @endphp
                  <td>
                    <span class="badge bg-danger">Pendiente E.</span>
                  </td>
                  @else
                  <td></td>
                  @endif
                @endif
                  @endforeach

                  </tr>
                  @endforeach

                  <tr>
                    
                      <th></th>
                      <th class="text-center">Extras</th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                  </tr>


                  @foreach(Session::get('detallepedidos') as $detalle_p)
                  <tr>
                  @foreach(Session::get('platillosc') as $platillo)

                  @if($detalle_p->ID_PLATILLO==$platillo->ID_PLATILLO && ($detalle_p->extra==2 or  $detalle_p->extra==1))
                  @php
                  $subtotalex=($subtotalex+$detalle_p->SUB_TOTAL);
                  @endphp
                      <td class="text-center">{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                      <td> {{$platillo->TITULO_PLATILLO}}</td>
                      @if(strlen($detalle_p->OBSERVACION)>3)
                      <td><b><span class="badge bg-warning text-dark">{{$detalle_p->OBSERVACION}}</span></b></td>
                      @else
                      <td> {{$detalle_p->OBSERVACION}} </td>
                      @endif
                      <td>Q. {{$platillo->COSTO_PLATILLO}}</td>
                      <td>Q. {{(($detalle_p->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+($detalle_p->costo_cambio-$detalle_p->costo_guarnicion))}} </td>
                      @if($detalle_p->OBSERVACION=="N/A")                      
                      <td></td>
                      @else
                      <td>
                        <div class="row g-2">
                          <div class="col-md">
                          <label class="form-label">Cambio: </label>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(1)" id="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}" value="option1">
                            <label class="form-check-label" for="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}">Si</label>
                          </div>
                       
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(2)" id="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}" value="option2">
                            <label class="form-check-label" for="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}">No</label>
                          </div>
                        </div>
                        <div class="col-md">
                          <div class="input-group input-group-outline mb-2">
                            <input type="text" class="form-control" wire:model="valorcambio" placeholder="Q.">
                          </div>
                        </div>
                        <div class="col-md">
                          <div class="form-check form-check-inline">
                            <button type="button" class="btn btn-primary" wire:click="advalorcambio('{{$detalle_p->ID_DETALLE_PEDIDO}}','{{$detalle_p->ID_PEDIDIO}}')" title="Conf Orden">+</button>
                        </div>
                      </div>
                      </div>
                   
                      </td>
                      @endif
                      @if($pedido->ESTADO_EXTRA<=2)
                      @php
                      $listo=$listo+1;
                      @endphp
                      <td>
                        <span class="badge bg-danger">Pendiente E.</span>
                      </td>
                      @else
                      <td></td>
                      @endif
                       @endif
                       @endforeach
                
                  @foreach(Session::get('bebidasc') as $bebida)
                  @if( $detalle_p->ID_PLATILLO == $bebida->ID_BEBIDA  && ($detalle_p->extra==2 or  $detalle_p->extra==1))
                  @php
                  $subtotalex=$subtotalex+$detalle_p->SUB_TOTAL;
                  @endphp
                  <?php$ca=$ca+1;?>
                  <td class="text-center">{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                  <td>  {{$bebida->TITUTLO_BEBIDA}} </td>
                  <td> {{$detalle_p->OBSERVACION}} </td>
                  <td>Q. {{$bebida->COSTO_BEBIDA}}</td>
                  <td>Q. {{$detalle_p->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA+($detalle_p->costo_cambio-$detalle_p->costo_guarnicion)}} </td>
                  @if($detalle_p->OBSERVACION=="N/A")                      
                      <td></td>
                      @else
                      <td>
                        <div class="row g-2">
                          <div class="col-md">
                          <label class="form-label">Cambio: </label>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(1)" id="inlineRadio1" value="option1">
                            <label class="form-check-label" for="inlineRadio1">Si</label>
                          </div>
                       
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(2)" id="inlineRadio2" value="option2">
                            <label class="form-check-label" for="inlineRadio2">No</label>
                          </div>
                        </div>
                        <div class="col-md">
                          <div class="input-group input-group-outline mb-2">
                            <input type="text" class="form-control" wire:model="valorcambio" placeholder="Q.">
                          </div>
                        </div>
                        <div class="col-md">
                          <div class="form-check form-check-inline">
                            <button type="button" class="btn btn-primary" wire:click="advalorcambio('{{$detalle_p->ID_DETALLE_PEDIDO}}','{{$detalle_p->ID_PEDIDIO}}')" title="Conf Orden">+</button>
                        </div>
                      </div>
                      </div>
                   
                      </td>
                      @endif
                    
                  @if($pedido->ESTADO_EXTRA<=2)
                  @php
                  $listo=$listo+1;
                  @endphp
                  <td>
                    <span class="badge bg-danger">Pendiente E.</span>
                  </td>
                  @else
                  <td></td>
                  @endif
                @endif
                  @endforeach

                  </tr>
                  @endforeach

                  
                  <tr>
                    <td></td>
                    <td></td>
                    
                    <td>Sub-Total</td>
                    @php
                    $sumacuenta=$subtotalp+$subtotalex;
                    @endphp
                    <td>Q. {{$subtotalp+$subtotalex}}.00</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @php
                $avalorpro=0;
                @endphp
                @foreach(Session::get('propinas') as $propina)
                  @if($propina->monto_inicial<=$sumacuenta and $propina->monto_final>=$sumacuenta)
                     @php
                     $avalorpro=$propina->monto;
                     @endphp
                 @endif
            @endforeach
                <tr>
                  <td></td>
                    <td></td>
                    
                    <td>Propina</td>
                        <td>Q. {{$avalorpro}}</td>
                        <td></td>
                    <td></td>
                    <td></td>
                    </tr>
                   @if($tpago!=null)
                    @if($tpago==2)
                    <tr>
                      <th></th>
                        <th></th>
                        
                        <th>Recargo Tarjeta:</th>    
                        <th>Q. {{($sumacuenta+$avalorpro)*0.05}}</th>
                  
                        <th></th>
                        <th></th>
                        <td></td>
                      </tr>
                    @else

                    @endif
                    @endif


                    <tr>
                      <td></td>
                        <th></th>
                        
                        <th>Total Cuenta:</th>
                  
                    @if($tpago==2)
                    <th>Q. {{$sumacuenta+$avalorpro+(($sumacuenta+$avalorpro)*0.05)}}</th>
                    @else
                    <th>Q. {{$sumacuenta+$avalorpro}}.00</th>
                    @endif
                        <th></th>
                        <th></th>
                        <td></td>
                      </tr>
                  </tbody>

                      
                </table>
              </div>
                  </div> 
                  
                  @if($cancelado==1 or $cancelado==0 && $listo==0)
                  @include('cuenta.modalvalboleta')
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmarboleta"title="Editar Orden">
                      Confirmar Cuenta
                  </button>
                  @elseif($cancelado==2)
                  <h4 class="font-weight-bolder">
                      Metodo de Pago:
                  </h4>
                  <div class="input-group input-group-outline mb-3">
                  <div class="form-check"  style="font-size: 25px; text-align: center;">
                      <input class="form-check-input" wire:click="tipopago('1','{{$idpedido}}')" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                      <label class="form-check-label" for="flexRadioDefault1">
                       Efectivo
                      </label>
                    </div>
                    <div class="form-check"  style="font-size: 25px; text-align: center;">
                      <input class="form-check-input" wire:click="calpagotc('2','{{$idpedido}}','{{$sumacuenta+$avalorpro}}')" type="radio" name="flexRadioDefault" id="flexRadioDefault2" >
                      <label class="form-check-label" for="flexRadioDefault2">
                       Tarjeta Debito/Credito
                      </label>
                    </div>
                    <div class="form-check"  style="font-size: 25px; text-align: center;">
                      <input class="form-check-input" wire:click="pagomixto('1','{{$idpedido}}','{{$sumacuenta+$avalorpro}}')" type="radio" name="flexRadioDefault" id="flexRadioDefault20" >
                      <label class="form-check-label" for="flexRadioDefault20">
                       Mixto
                      </label>
                    </div>
                  </div>
                  @endif
  
                  @if($tpago!=null)
                  @if($tpago==1)
                  <div class="row g-2">
                    <div class="col-md"  style="font-size: 25px; text-align: center;">
                      <label class="form-label">Monto Efectivo: </label>
                      <div class="input-group input-group-outline mb-3">
                        <input type="text" class="form-control" wire:model='monto_efec' wire:keydown='calcambio("{{$sumacuenta+$avalorpro}}")' vwire:click='calcambio("{{$sumacuenta+$avalorpro}}")' placeholder="Q." required>
                      </div>
                  </div>
                  <div class="col-md"  style="font-size: 25px; text-align: center;">
                    <label class="form-label">Cambio Efectivo: </label>
                    <div class="input-group input-group-outline mb-3">
                      <input type="text" class="form-control" wire:model='cambio' placeholder="Q." disabled>
                    </div>
                  </div>
                  @if($monto_efec!=null && $monto_efec>0 && $cambio>=0)
                  @include('cuenta.modalvaltippago')
                  @include('cliente.modalcliente')
                  @include('cliente.modalinsertarcliente')
                  @if($dte==null)
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalcliente"title="Confirmar Orden">
                      Confirmar Cuenta
                  </button>
                  @endif
                {{--   <button type="button" class="btn btn-danger" wire:click="cargainfo_fel()" title="Confirmar Orden">
                    FEL Prueba
                  </button> --}}
                  @if($respuesta!=null)
              {{--     @php 
                  foreach($respuesta as $codigo=>$mensaje)
                    {
                    echo "El " . $codigo . " es " . $mensaje;
                    echo "<br>";
                    }
                @endphp
         <h1>Respuesta</h1>
        
         @if(Session::get('xml')!=null)
         <div onload="imprimir();">
          {{Session::get('xml')}}
         </div> --}}
          @if($serie!=null)
          <center>              
            <div  class="card" style="width: 28rem;">
              <div id="imp1" class="card-body">
               {{--  <p class="card-subtitle mb-2 text-muted text-center" style="font-size: 12px; text-align: center; "><b>-----DATOS DEL EMISOR-----</b></p> --}}
                <p class="card-text text-center" style="font-size: 9px; text-align: center;"> <b>{{$nombre_comercial_emisor}}</b> <br> NIT: {{$nit_emisor}} <br> {{$nombre_emisor}} <br> {{$direccion_emisor}} </p>
                <p class="card-subtitle mb-2 text-muted text-center;" style="font-size: 8px; text-align: center;"><b>DOCUMENTO TRIBUTARIO ELECTRONICO</b></p>              
                <p class="card-subtitle mb-2 text-muted text-center;" style="font-size: 9px; text-align: center;"><b>FACTURA</b></p>
                <p class="card-text text-center"style="font-size: 8px; text-align: left;"> <b>Numero de Autorización: </b>  <br>
                  {{$autorizacion}}  <br> <b>Serie: </b>{{$serie}}  <br> <b>Numero de DTE: </b> {{$dte}} </p>
                  <p class="card-text text-center"style="font-size: 9px; text-align: center;">Fecha de Emisión: <br>{{$fecha_cert}}</p>
                <p class="card-subtitle mb-2 text-muted text-center" style="font-size: 9px;text-align: center;"> <b> -----DATOS DEL COMPRADOR-----</b></p>
               
                <p class="card-text text-center"style="font-size: 9px; text-align: center;">NIT: {{$nitcliente}} <br> {{$nombcliente}}  <br> {{$direccioncliente}}</p>
                <br>
                <div class="table-responsive">
                <table class="table" style="font-size: 10px; text-align: center;">
                  <thead>
                    <tr>
                      <th>Cantidad</th>
                      <th>Descripcion</th> 
                      <th>Precio</th>                      
                      <th>SubTotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($this->forma_fac!=null &&  $this->forma_fac==1)
                    @php
                    $subtotalp=0;
                    $cambio=0;
                    $subtotalex=0;
                    $avalorpro=0;
                    @endphp

                  @foreach(Session::get('detallepedidos') as $detalle_p)
                  @php
                  $cambio=$cambio+($detalle_p->costo_cambio-$detalle_p->costo_guarnicion);
                  @endphp
                  <tr>
                  @foreach(Session::get('platillosc') as $platillo)
                  @if($detalle_p->ID_PLATILLO==$platillo->ID_PLATILLO && $detalle_p->extra==0)                  
                  @php
                  $subtotalp=$subtotalp+(($detalle_p->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)); 
                  @endphp
                  <td class="text-center">{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                      <td> {{$platillo->TITULO_PLATILLO}}</td>
                      <td>Q. {{$platillo->COSTO_PLATILLO}}</td>
                      <td>Q. {{(($detalle_p->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO))}} </td>
                  @endif
                  @endforeach
                
                  @foreach(Session::get('bebidasc') as $bebida)
                  @if( $detalle_p->ID_PLATILLO == $bebida->ID_BEBIDA  && $detalle_p->extra==0)
                  @php
                  $subtotalp=$subtotalp+$detalle_p->SUB_TOTAL;
                  @endphp
                  <?php$ca=$ca+1;?>
                  <td class="text-center">{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                  <td>  {{$bebida->TITUTLO_BEBIDA}} </td>
                  <td>Q. {{$bebida->COSTO_BEBIDA}}</td>
                  <td>Q. {{$detalle_p->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA}} </td>
                  @endif
                  @endforeach
                  </tr>
                  @endforeach

                  @foreach(Session::get('detallepedidos') as $detalle_p)
                  @php
                  $cambio=$cambio+($detalle_p->costo_cambio-$detalle_p->costo_guarnicion);
                  @endphp
                  <tr>
                  @foreach(Session::get('platillosc') as $platillo)
                  @if($detalle_p->ID_PLATILLO==$platillo->ID_PLATILLO && ($detalle_p->extra==2 or  $detalle_p->extra==1))
                  @php
                  $subtotalex=($subtotalex+$detalle_p->SUB_TOTAL);
                  @endphp
                      <td class="text-center">{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                      <td> {{$platillo->TITULO_PLATILLO}}</td>
                      <td>Q. {{$platillo->COSTO_PLATILLO}}</td>
                      <td>Q. {{(($detalle_p->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO))}} </td>
                  @endif
                  @endforeach
                
                  @foreach(Session::get('bebidasc') as $bebida)
                  @if( $detalle_p->ID_PLATILLO == $bebida->ID_BEBIDA  && ($detalle_p->extra==2 or  $detalle_p->extra==1))
                  @php
                  $subtotalex=$subtotalex+$detalle_p->SUB_TOTAL;
                  @endphp
                  <?php$ca=$ca+1;?>
                  <td class="text-center">{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                  <td>  {{$bebida->TITUTLO_BEBIDA}} </td>
                  <td>Q. {{$bebida->COSTO_BEBIDA}}</td>
                  <td>Q. {{$detalle_p->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA}} </td>
                  @endif
                  @endforeach
                  </tr>
                  @endforeach
                @php
                $avalorpro=0;
                @endphp
                @foreach(Session::get('propinas') as $propina)
                  @if($propina->monto_inicial<=$sumacuenta and $propina->monto_final>=$sumacuenta)
                     @php
                     $avalorpro=$propina->monto;
                     @endphp
                 @endif
            @endforeach
            <tr>
              <td>1</td>
              <td>Extras y cambios</td>
              <td>{{$cambio}}</td>
              <td>{{$cambio}}</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Propina</td>
              <td>{{$avalorpro}}</td>
              <td>{{$avalorpro}}</td>
            </tr>
                    @elseif($this->forma_fac!=null &&  $this->forma_fac==2)
                    <tr>
                      <td>1</td>
                      <td>Por consumo de alimentos.</td>
                      <td>1</td>
                      <td>Q. {{$sumacuenta+$avalorpro}}.00</td>
                    </tr>
                    @endif
                  </tbody>
                </table>
                @if($this->forma_fac!=null &&  $this->forma_fac==1)
                <p class="card-text text-center"style="font-size: 11px; text-align: center;"><b> Q.  {{$sumacuenta+$avalorpro}}.00</b></p>
                @elseif($this->forma_fac!=null &&  $this->forma_fac==2)
                <p class="card-text text-center"style="font-size: 11px; text-align: center;"><b> Q. {{$sumacuenta+$avalorpro}}.00</b></p>
                @endif
              </div>
            
               <br>
                <p class="card-text text-center"style="font-size: 9px; text-align: center;">* SUJETO A RETENCION DEFINITIVA</p>
                    <p class="card-subtitle mb-2 text-muted text-center" style="font-size: 9px; text-align: center;"><b>-----DATOS DEL CERTIFICADOR-----</b></p>                  
                    <p class="card-text text-center"style="font-size: 9px; text-align: center;">NIT: {{$nit_cert}}  <br> {{$nomb_cert}} </p>
              </div>
            </div> 
            <br>
            <button class="btn btn-success" onclick="javascript:imprim1(imp1);">Imprimir Factura</button>
          </center>
          @endif
          <br><br>
     {{--      <button type="button" onclick="javascript:imprim1(imp1);">imprmir </button>
          {{Session::get('xml')}} --}}

       {{--   @endif --}}
                  @endif
                  @else
                  <button type="button" class="btn btn-danger" title="Conf Orden" disabled>
                    Confirmar Cuenta
                </button>
                  @endif
                  </div>
                  @elseif($tpago==2)
                  @if($cuentamasrecargo!=null)
                  <div class="col-md">
                    <label class="form-label">Monto Final  + Recargo <b> 5%. </b> </label>
                <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" wire:model="cuentainput" required disabled>
                  </div>
                </div>
                @endif
                  <div class="col-md">
                      <label class="form-label">Fact. Voucher </label>
                  <div class="input-group input-group-outline mb-3">
                      <input type="text" class="form-control" wire:model="notc">
                    </div>
                  </div>
                  @error('notc') 
                    <div class="alert alert-danger" role="alert">
                     Ingrese # de Voucher.
                   </div>
                    @enderror
                  @if($cuentamasrecargo!=null)
                  @include('cuenta.modalvaltippago')
                  @include('cliente.modalcliente')
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalcliente" title="Confirmar Orden">
                  
                      Confirmar Pago
                  </button>

                  @endif
                  @endif
                  @endif

                  @if($tpago!=null && $tpago==3)
                @if($pago_mixto!=null && $pago_mixto==3)
                <div class="row g-2">
                    <div class="col-md">
                      <label class="form-label">Monto Efectivo: </label>
                      <div class="input-group input-group-outline mb-3">
                        <input type="text" class="form-control" wire:model='monto_efec2' wire:keydown='pen_pag_tc("{{$sumacuenta+$avalorpro+$valoradomicilio}}")' vwire:click='calcambio("{{$sumacuenta+$avalorpro+$valoradomicilio}}")' placeholder="Q." required>
                      </div>
                  </div>
                  </div>
                  <div class="row g-2">
                    <div class="col-md">
                      <label class="form-label">Monto TC: </label>
                      <div class="input-group input-group-outline mb-3">
                        <input type="text" class="form-control" wire:model='monto_tc_par' wire:keydown='caltc("{{$sumacuenta+$avalorpro+$valoradomicilio}}")' vwire:click='calcambio("{{$sumacuenta+$avalorpro+$valoradomicilio}}")' placeholder="Q." required>
                      </div>
                  </div>
                 
                  <div class="col-md">
                    <label class="form-label">Monto TC + Recargo: </label>
                    <div class="input-group input-group-outline mb-3">
                      <input type="text" class="form-control" wire:model='cuentainput2' placeholder="Q." disabled>
                    </div>
                  </div>
                  </div>

                  <div class="row g-2">
                  <div class="col-md">
                      <label class="form-label">Fact. Voucher </label>
                  <div class="input-group input-group-outline mb-3">
                      <input type="text" class="form-control" wire:model="notc" >
                    </div>
                    @error('notc') 
                    <div class="alert alert-danger" role="alert">
                     Ingrese # de voucher.
                   </div>
                    @enderror
                  </div>

                  <div class="col-md">
                    <label class="form-label">Monto Total: </label>
                    <div class="input-group input-group-outline mb-3">
                     <b>
                     <input type="text" class="form-control" wire:model='sumaefetc' placeholder="Q." disabled>
                     </b>
                    </div>
                  </div>
                  </div> 
                  @if($sumaefetc!=null and $notc!=null)
                  @include('cuenta.modalvaltippago')
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmartippago"title="Confirmar Orden">
                      Confirmar Cuenta
                  </button>
                  @endif


                @endif
                @endif




                

                  
              </form>
            </div>
          </div>
        </div>
        @endif
        @if($op!==null && $op==2 && Session::get('platillosc')!=null)
        @if(Session::get('detallepedidos')!=null)
        <div class="accordion-item">
          @php 
          $subtotalp=0;
          $subtotalex=0;
          $sumacuenta=0;
          $valorpro=0;
          @endphp
          <h2 class="accordion-header" id="flush-collapseFOR2">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFOR2" aria-expanded="false" aria-controls="flush-collapseFOR2">
              <h4 class="font-weight-bolder">Detalles:   </h4>
            </button>
          </h2>
          <div id="flush-collapseFOR2" class="accordion-collapse" aria-labelledby="flush-collapseFOR2" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
                <div class="row">
                  <div class="table-responsive">
                  <table class="table table-hover">
                      <thead>
                         
                          <th>
                            @if($cance==2)
                            <button class="btn btn-primary" wire:click="cargainfo()">Imprimir</button>
                          @endif
                          </th>
                          <th></th>
                          <th class="text-center"><p>
                             @if($op==2)
                             <p> <b> Pedido a domicilio</b> </p>
                             @endif
                             <p>{{$fecha}}</p>
                             <p>Mesero: {{$nombreMesero}}</p>
                          </p>
                          </th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                      </thead>
                      @if($op==2 or $op==3)
                      <tbody>
                       
                        <th >Cliente: {{$nom_cliente}}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tbody>
                      <tbody>
                        
                        <th >Telefono: {{$telef}}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tbody>
                      <tbody>
                        
                        <th >Direccion: {{$dire}}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tbody>
                      @endif

                      <thead>
                        <th  class="text-center">Cantidad</th>
                        <th >Titulo</th>
                        <th >Observacion</th>
                        <th >Costo</th>
                        <th >Totales</th>
                        <th >Accion</th>
                        <th>Estado</th>
                      </thead>
                      <tbody>
                  @foreach(Session::get('detallepedidos') as $detalle_p)

                  <tr>
                  @foreach(Session::get('platillosc') as $platillo)

                  @if($detalle_p->ID_PLATILLO==$platillo->ID_PLATILLO && $detalle_p->extra==0)
                  
                  @php
                  $subtotalp=($subtotalp+$detalle_p->SUB_TOTAL); @endphp

                  <td class="text-center">{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                      <td> {{$platillo->TITULO_PLATILLO}}</td>
                      @if(strlen($detalle_p->OBSERVACION)>3)
                      <td><b><span class="badge bg-warning text-dark">{{$detalle_p->OBSERVACION}}</span></b></td>
                      @else
                      <td> {{$detalle_p->OBSERVACION}} </td>
                      @endif
                  
                      <td>Q. {{$platillo->COSTO_PLATILLO}}</td>
                      <td>Q. {{($detalle_p->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+($detalle_p->costo_cambio-$detalle_p->costo_guarnicion)}} </td>
                      @if($detalle_p->OBSERVACION=="N/A")                      
                      <td></td>
                      @else
                      <td>
                        <div class="row g-2">
                          <div class="col-md">
                          <label class="form-label">Cambio: </label>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(1)" id="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}" value="option1">
                            <label class="form-check-label" for="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}">Si</label>
                          </div>
                       
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(2)" id="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}" value="option2">
                            <label class="form-check-label" for="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}">No</label>
                          </div>
                        </div>
                        <div class="col-md">
                          <div class="input-group input-group-outline mb-2">
                            <input type="text" class="form-control" wire:model="valorcambio" placeholder="Q.">
                          </div>
                        </div>
                        <div class="col-md">
                          <div class="form-check form-check-inline">
                            <button type="button" class="btn btn-primary" wire:click="advalorcambio('{{$detalle_p->ID_DETALLE_PEDIDO}}','{{$detalle_p->ID_PEDIDIO}}')" title="Conf Orden">+</button>
                        </div>
                      </div>
                      </div>
                   
                      </td>
                      @endif
                      @if($pedido->ESTADO_PEDIDO<=2)
                      <td>
                        <span class="badge bg-danger">Pendiente E.</span>
                      </td>
                      @else
                      <td></td>
                      @endif
                       @endif
                       @endforeach
                
                  @foreach(Session::get('bebidasc') as $bebida)
                  @if( $detalle_p->ID_PLATILLO == $bebida->ID_BEBIDA  && $detalle_p->extra==0)
                  @php
                 $subtotalp=$subtotalp+$detalle_p->SUB_TOTAL;  @endphp
                  <?php$ca=$ca+1;?>
                  <td class="text-center">{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                  <td>  {{$bebida->TITUTLO_BEBIDA}} </td>
                  <td> {{$detalle_p->OBSERVACION}} </td>
                  <td>Q. {{$bebida->COSTO_BEBIDA}}</td>
                  <td>Q. {{$detalle_p->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA}} </td>
                  <td></td>
                  @if($pedido->ESTADO_PEDIDO<=2)
                  <td>
                    <span class="badge bg-danger">Pendiente E.</span>
                  </td>
                  @else
                  <td></td>
                  @endif
                @endif
                  @endforeach

                  </tr>
                  @endforeach
                  
                      
                      <tr>
                    <td class="text-center"> <b>Extras</b> </td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      </tr>


                  @foreach(Session::get('detallepedidos') as $detalle_p)
                  <tr>
                  @foreach(Session::get('platillosc') as $platillo)

                  @if($detalle_p->ID_PLATILLO==$platillo->ID_PLATILLO && ($detalle_p->extra==2 or  $detalle_p->extra==1))
                  @php
                  $subtotalex=($subtotalex+$detalle_p->SUB_TOTAL); 
               
                  @endphp
                      <td class="text-center">{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                      <td> {{$platillo->TITULO_PLATILLO}}</td>
                      @if(strlen($detalle_p->OBSERVACION)>3)
                      <td><b><span class="badge bg-warning text-dark">{{$detalle_p->OBSERVACION}}</span></b></td>
                      @else
                      <td> {{$detalle_p->OBSERVACION}} </td>
                      @endif
                      <td>Q. {{$platillo->COSTO_PLATILLO}}</td>
                      <td>Q. {{($detalle_p->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+($detalle_p->costo_cambio-$detalle_p->costo_guarnicion)}} </td>
                      @if($detalle_p->OBSERVACION=="N/A")                      
                      <td></td>
                      @else
                      <td>
                        <div class="row g-2">
                          <div class="col-md">
                          <label class="form-label">Cambio: </label>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(1)" id="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}" value="option1">
                            <label class="form-check-label" for="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}">Si</label>
                          </div>
                       
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(2)" id="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}" value="option2">
                            <label class="form-check-label" for="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}">No</label>
                          </div>
                        </div>
                        <div class="col-md">
                          <div class="input-group input-group-outline mb-2">
                            <input type="text" class="form-control" wire:model="valorcambio" placeholder="Q.">
                          </div>
                        </div>
                        <div class="col-md">
                          <div class="form-check form-check-inline">
                            <button type="button" class="btn btn-primary" wire:click="advalorcambio('{{$detalle_p->ID_DETALLE_PEDIDO}}','{{$detalle_p->ID_PEDIDIO}}')" title="Conf Orden">+</button>
                        </div>
                      </div>
                      </div>
                   
                      </td>
                      @endif
                      @if($pedido->ESTADO_EXTRA<=2)
                      <td>
                        <span class="badge bg-danger">Pendiente E.</span>
                      </td>
                      @else
                      <td></td>
                      @endif
                       @endif
                       @endforeach
                
                  @foreach(Session::get('bebidasc') as $bebida)
                  @if( $detalle_p->ID_PLATILLO == $bebida->ID_BEBIDA  && ($detalle_p->extra==2 or  $detalle_p->extra==1))
                  @php
                  $subtotalex=$subtotalex+$detalle_p->SUB_TOTAL;
                  @endphp
                  <?php$ca=$ca+1;?>
                  <td class="text-center">{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                  <td>  {{$bebida->TITUTLO_BEBIDA}} </td>
                  <td> {{$detalle_p->OBSERVACION}} </td>
                  <td>Q. {{$bebida->COSTO_BEBIDA}}</td>
                  <td>Q. {{$detalle_p->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA}} </td>
                  <td></td>
                  @if($pedido->ESTADO_EXTRA<=2)
                  <td>
                    <span class="badge bg-danger">Pendiente E.</span>
                  </td>
                  @else
                  <td></td>
                  @endif
                @endif
                  @endforeach

                  </tr>
                  @endforeach

                  
                  <tr>
                
                    <td></td>
                    <td></td>
                   
                    <td>Sub-Total</td>
                    @php
                    $sumacuenta=$subtotalp+$subtotalex;
                    @endphp
                    <td>Q. {{$subtotalp+$subtotalex}}.00</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                  @php
                  $avalorpro=0;
                  @endphp
                  
              <td></td>
                    <td></td>
                  
                    <td>Propina</td>
                        <td>Q. {{$avalorpro}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                      <td></td>
                    <td></td>
                    <td>A Domicilio Q.</td>
                    <td>
                      @if($cancelado==2)
                      <div class="col-md">
                        <div class="input-group input-group-outline mb-2">
                          <input type="text" class="form-control" value="{{$valoradomicilio1}}" disabled>
                        </div>
                      </div>
                      @else
                      <div class="col-md">
                        <div class="input-group input-group-outline mb-2">
                          <input type="text" class="form-control" wire:model="valoradomicilio">
                        </div>
                        @error('valoradomicilio') 
                        <div class="alert alert-danger" role="alert">
                        Ingrese el monto
                       </div>
                        @enderror
                      </div>
                      @endif
                    </td>
                    <td></td>
                    <td></td>
                    </tr>
                    @if($tpago!=null)
                    @if($tpago==2)
                    <tr>
                      <th></th>
                        <th></th>
                        
                        <th>Recargo Tarjeta:</th>
                        @if($valoradomicilio!=null)
                        <th>Q. {{ ($sumacuenta+$avalorpro+$valoradomicilio)*0.05}}</th>
                        @elseif($valoradomicilio1!=null)
                        <th>Q. {{($sumacuenta+$avalorpro+$valoradomicilio1)*0.05}}</th>
                        @endif
                   
                        <th></th>
                        <th></th>
                      </tr>
                    @else

                    @endif
                    @endif
                    <tr>
                      <th></th>
                        <th></th>
                        
                        <th>Total Cuenta:</th>
                        @if($valoradomicilio!=null)
                        @if($tpago==2)
                        <th>Q. {{($sumacuenta+$avalorpro+$valoradomicilio)+(($sumacuenta+$avalorpro+$valoradomicilio)*0.05)}}</th>
                        @else
                        <th>Q. {{($sumacuenta+$avalorpro+$valoradomicilio)}}.00</th>
                        @endif
                        
                        @elseif($valoradomicilio1!=null)
                        @if($tpago==2)
                        <th>Q. {{ ($sumacuenta+$avalorpro+$valoradomicilio1)+(($sumacuenta+$avalorpro+$valoradomicilio1)*0.05)}}</th>
                        @else
                        <th>Q. {{ ($sumacuenta+$avalorpro+$valoradomicilio1)}}.00</th>
                        @endif
                        @else
                        <th>Q. {{ $sumacuenta+$avalorpro}}.00</th>
                        @endif
                        <th></th>
                        <th></th>
                      </tr>
                         

                  </tbody>

                   
                </table>
                  </div>

 
                 @if($cancelado<3)
                  <h4 class="font-weight-bolder">
                      Metodo de Pago:
                  </h4>
                  <div class="input-group input-group-outline mb-3">
                  <div class="form-check">
                      <input class="form-check-input" wire:click="tipopago('1','{{$idpedido}}')" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                      <label class="form-check-label" for="flexRadioDefault1">
                       Efectivo
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" wire:click="calpagotc('2','{{$idpedido}}','{{$sumacuenta+$avalorpro}}')" type="radio" name="flexRadioDefault" id="flexRadioDefault2" >
                      <label class="form-check-label" for="flexRadioDefault2">
                       Tarjeta Debito/Credito
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" wire:click="pagomixto('1','{{$idpedido}}','{{$sumacuenta+$avalorpro}}')" type="radio" name="flexRadioDefault" id="flexRadioDefault20" >
                      <label class="form-check-label" for="flexRadioDefault20">
                       Mixto
                      </label>
                    </div>
                  </div>
                  @endif
  
                  @if($tpago!=null)
                  @if($tpago==1)
                  <div class="row g-2">
                    <div class="col-md">
                      <label class="form-label">Monto Efectivo: </label>
                      <div class="input-group input-group-outline mb-3">
                        <input type="text" class="form-control" wire:model='monto_efec' wire:keydown='calcambio("{{$sumacuenta+$avalorpro+$valoradomicilio}}")' vwire:click='calcambio("{{$sumacuenta+$avalorpro+$valoradomicilio}}")' placeholder="Q." required>
                      </div>
                  </div>
                  <div class="col-md">
                    <label class="form-label">Cambio Efectivo: </label>
                    <div class="input-group input-group-outline mb-3">
                      <input type="text" class="form-control" wire:model='cambio' placeholder="Q." disabled>
                    </div>
                  </div>
                  @if($monto_efec!=null && $monto_efec>0 && $cambio>=0)
                  @include('cuenta.modalvaltippago')
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmartippago"title="Confirmar Orden">
                      Confirmar Cuenta
                  </button>
                  @else
                  <button type="button" class="btn btn-danger" title="Conf Orden" disabled>
                    Confirmar Cuenta
                </button>
                  @endif
                  </div>
                  @elseif($tpago==2)
                  <div class="col-md">
                      <label class="form-label">Fact. Voucher </label>
                  <div class="input-group input-group-outline mb-3">
                      <input type="text" class="form-control" wire:model="notc" >
                    </div>
                    @error('notc') 
                    <div class="alert alert-danger" role="alert">
                     Ingrese # de voucher.
                   </div>
                    @enderror
                  </div>
                  @if($cuentamasrecargo!=null)
                  <div class="col-md">
                    <label class="form-label">Monto Final  + Recargo <b> 5%. </b> </label>
                <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" wire:model="cuentainput" required disabled>
                  </div>
                </div>
                @endif
                  @if($cuentamasrecargo!=null)
                  @include('cuenta.modalvaltippago')
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmartippago"title="Confirmar Orden">
                      Confirmar Cuenta
                  </button>
                  @endif
                  @endif

                  @endif

                @if($tpago!=null && $tpago==3)
                @if($pago_mixto!=null && $pago_mixto==3)
                <div class="row g-2">
                    <div class="col-md">
                      <label class="form-label">Monto Efectivo: </label>
                      <div class="input-group input-group-outline mb-3">
                        <input type="text" class="form-control" wire:model='monto_efec2' wire:keydown='pen_pag_tc("{{$sumacuenta+$avalorpro+$valoradomicilio}}")' vwire:click='calcambio("{{$sumacuenta+$avalorpro+$valoradomicilio}}")' placeholder="Q." required>
                      </div>
                  </div>
                  </div>
                  <div class="row g-2">
                    <div class="col-md">
                      <label class="form-label">Monto TC: </label>
                      <div class="input-group input-group-outline mb-3">
                        <input type="text" class="form-control" wire:model='monto_tc_par' wire:keydown='caltc("{{$sumacuenta+$avalorpro+$valoradomicilio}}")' vwire:click='calcambio("{{$sumacuenta+$avalorpro+$valoradomicilio}}")' placeholder="Q." required>
                      </div>
                  </div>
                 
                  <div class="col-md">
                    <label class="form-label">Monto TC + Recargo: </label>
                    <div class="input-group input-group-outline mb-3">
                      <input type="text" class="form-control" wire:model='cuentainput2' placeholder="Q." disabled>
                    </div>
                  </div>
                  </div>

                  <div class="row g-2">
                  <div class="col-md">
                      <label class="form-label">Fact. Voucher </label>
                  <div class="input-group input-group-outline mb-3">
                      <input type="text" class="form-control" wire:model="notc" >
                    </div>
                    @error('notc') 
                    <div class="alert alert-danger" role="alert">
                     Ingrese # de voucher.
                   </div>
                    @enderror
                  </div>

                  <div class="col-md">
                    <label class="form-label">Monto Total: </label>
                    <div class="input-group input-group-outline mb-3">
                     <b>
                     <input type="text" class="form-control" wire:model='sumaefetc' placeholder="Q." disabled>
                     </b>
                    </div>
                  </div>
                  </div> 
                  @if($sumaefetc!=null and $notc!=null)
                  @include('cuenta.modalvaltippago')
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmartippago"title="Confirmar Orden">
                      Confirmar Cuenta
                  </button>
                  @endif


                @endif
                @endif
                  </div> 
            
            </div>
          </div>
        </div>
        @endif
        @endif

        @if($op!==null && $op==3 && Session::get('platillosc')!=null)
        @if(Session::get('detallepedidos')!=null)
        <div class="accordion-item">
          @php 
          $subtotalp=0;
          $subtotalex=0;
          $sumacuenta=0;
          $valorpro=0;
          @endphp
          <h2 class="accordion-header" id="flush-collapseFOR12">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFOR12" aria-expanded="false" aria-controls="flush-collapseFOR12">
              <h4 class="font-weight-bolder">Ver Detalles:</h4>
            </button>
          </h2>
          <div id="flush-collapseFOR12" class="accordion-collapse" aria-labelledby="flush-collapseFOR12" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
                <div class="row">
                  <div class="table-responsive">
                  <table class="table table-hover">
                      <thead>
                          <th>
                            @if($cance==2)
                            <button class="btn btn-primary" wire:click="cargainfo()">Imprimir</button>
                          @endif
                          </th>
                          <th></th>
                          <th class="text-center"><p>
                             @if($op==2)
                             <p> Pedido a domicilio</p>
                             @elseif($op==3)
                             <p> <b> Pedido para llevar</b></p>
                             @elseif($op==4)
                             <p> Pedido empleado </p>
                             @endif
                            
                             <p>{{$fecha}}</p>
                             <p>Mesero: {{$nombreMesero}}</p>
                          </p>
                          </th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                      </thead>
                      @if($op==2 or $op==3)
                      <tbody>
                        <th>Cliente: {{$nom_cliente}}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tbody>
                      @endif
                      @if($op==4)
                      <tbody>
                        <th>Colaborador: {{$nom_cliente}}</th>
                      </tbody>
                      @endif

                      <thead>
                        <th >Cantidad</th>
                        <th >Titulo</th>
                        <th >Observacion</th>
                        <th >Costo</th>
                        <th >Totales</th>
                        <th >Accion</th>
                        <th>Estado</th>
                      </thead>
                      <tbody>
      
                  @foreach(Session::get('detallepedidos') as $detalle_p)

                  <tr>
                  @foreach(Session::get('platillosc') as $platillo)

                  @if($detalle_p->ID_PLATILLO==$platillo->ID_PLATILLO && $detalle_p->extra==0)
                  
                  @php
                  $subtotalp=($subtotalp+$detalle_p->SUB_TOTAL); @endphp

                  <td>{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                      <td> {{$platillo->TITULO_PLATILLO}}</td>
                      @if(strlen($detalle_p->OBSERVACION)>3)
                      <td><b><span class="badge bg-warning text-dark">{{$detalle_p->OBSERVACION}}</span></b></td>
                      @else
                      <td> {{$detalle_p->OBSERVACION}} </td>
                      @endif
                      <td>Q. {{$platillo->COSTO_PLATILLO}}</td>
                      <td>Q. {{($detalle_p->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+($detalle_p->costo_cambio-$detalle_p->costo_guarnicion)}} </td>
                      @if($detalle_p->OBSERVACION=="N/A")                      
                      <td></td>
                      @else
                      <td>
                        <div class="row g-2">
                          <div class="col-md">
                          <label class="form-label">Cambio: </label>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(1)" id="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}" value="option1">
                            <label class="form-check-label" for="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}">Si</label>
                          </div>
                       
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(2)" id="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}" value="option2">
                            <label class="form-check-label" for="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}">No</label>
                          </div>
                        </div>
                        <div class="col-md">
                          <div class="input-group input-group-outline mb-2">
                            <input type="text" class="form-control" wire:model="valorcambio" placeholder="Q.">
                          </div>
                        </div>
                        <div class="col-md">
                          <div class="form-check form-check-inline">
                            <button type="button" class="btn btn-primary" wire:click="advalorcambio('{{$detalle_p->ID_DETALLE_PEDIDO}}','{{$detalle_p->ID_PEDIDIO}}')" title="Conf Orden">+</button>
                        </div>
                      </div>
                      </div>
                   
                      </td>
                      @endif
                      @if($pedido->ESTADO_PEDIDO<=2)
                      <td>
                        <span class="badge bg-danger">Pendiente E.</span>
                      </td>
                      @else
                      <td></td>
                      @endif
                       @endif
                       @endforeach
                
                  @foreach(Session::get('bebidasc') as $bebida)
                  @if( $detalle_p->ID_PLATILLO == $bebida->ID_BEBIDA  && $detalle_p->extra==0)
                  @php
                 $subtotalp=$subtotalp+$detalle_p->SUB_TOTAL;  @endphp
                  <?php$ca=$ca+1;?>
                  <td>{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                  <td>  {{$bebida->TITUTLO_BEBIDA}} </td>
                  <td> {{$detalle_p->OBSERVACION}} </td>
                  <td>Q. {{$bebida->COSTO_BEBIDA}}</td>
                  <td>Q. {{$detalle_p->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA}} </td>
                  <td></td>
                  @if($pedido->ESTADO_PEDIDO<=2)
                  <td>
                    <span class="badge bg-danger">Pendiente E.</span>
                  </td>
                  @else
                  <td></td>
                  @endif
                @endif
                  @endforeach

                  </tr>
                  @endforeach

                  <tr>
                    
                      <th></th>
                      <th class="text-center">Extras</th>
                      <th></th>
                      <th></th>
                  </tr>


                  @foreach(Session::get('detallepedidos') as $detalle_p)
                  <tr>
                  @foreach(Session::get('platillosc') as $platillo)

                  @if($detalle_p->ID_PLATILLO==$platillo->ID_PLATILLO && ($detalle_p->extra==2 or  $detalle_p->extra==1))
                  @php
                  $subtotalex=($subtotalex+$detalle_p->SUB_TOTAL); 
                  @endphp
                      <td>{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                      <td> {{$platillo->TITULO_PLATILLO}}</td>
                      @if(strlen($detalle_p->OBSERVACION)>3)
                      <td><b><span class="badge bg-warning text-dark">{{$detalle_p->OBSERVACION}}</span></b></td>
                      @else
                      <td> {{$detalle_p->OBSERVACION}} </td>
                      @endif
                      <td>Q. {{$platillo->COSTO_PLATILLO}}</td>
                      <td>Q. {{($detalle_p->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+($detalle_p->costo_cambio-$detalle_p->costo_guarnicion)}} </td>
                      @if($detalle_p->OBSERVACION=="N/A")                      
                      <td></td>
                      @else
                      <td>
                        <div class="row g-2">
                          <div class="col-md">
                          <label class="form-label">Cambio: </label>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(1)" id="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}" value="option1">
                            <label class="form-check-label" for="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}">Si</label>
                          </div>
                       
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(2)" id="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}" value="option2">
                            <label class="form-check-label" for="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}">No</label>
                          </div>
                        </div>
                        <div class="col-md">
                          <div class="input-group input-group-outline mb-2">
                            <input type="text" class="form-control" wire:model="valorcambio" placeholder="Q.">
                          </div>
                        </div>
                        <div class="col-md">
                          <div class="form-check form-check-inline">
                            <button type="button" class="btn btn-primary" wire:click="advalorcambio('{{$detalle_p->ID_DETALLE_PEDIDO}}','{{$detalle_p->ID_PEDIDIO}}')" title="Conf Orden">+</button>
                        </div>
                      </div>
                      </div>
                   
                      </td>
                  

                       @endif
                       @if($pedido->ESTADO_EXTRA<=2)
                       <td><span class="badge bg-danger">Pendiente E.</span></td>
                       @else
                       <td></td>
                       @endif
                       @endif
                       @endforeach
                
                  @foreach(Session::get('bebidasc') as $bebida)
                  @if( $detalle_p->ID_PLATILLO == $bebida->ID_BEBIDA  && ($detalle_p->extra==2 or  $detalle_p->extra==1))
                  @php
                  $subtotalex=$subtotalex+$detalle_p->SUB_TOTAL;
                  @endphp
                  <?php$ca=$ca+1;?>
                  <td>{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                  <td>  {{$bebida->TITUTLO_BEBIDA}} </td>
                  <td> {{$detalle_p->OBSERVACION}} </td>
                  <td>Q. {{$bebida->COSTO_BEBIDA}}</td>
                  <td></td>
                  <td>Q. {{$detalle_p->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA}} </td>
                  @if($pedido->ESTADO_EXTRA<=2)
                  <td><span class="badge bg-danger">Pendiente E.</span></td>
                  @else
                  <td></td>
                  @endif
                @endif
                  @endforeach

                  </tr>
                  @endforeach

                  
                  <tr>
                    <td></td>
                    <td></td>
                    
                    <td>Sub-Total</td>
                    @php
                    $sumacuenta=$subtotalp+$subtotalex;
                    @endphp
                    <td>Q. {{$subtotalp+$subtotalex}}.00</td>
                    <td></td>
                    <td></td>
                </tr>
                @php
                $avalorpro=0;
                @endphp
                <tr>
                  
                  <td></td>
                    <td></td>
                    
                    <td>Propina</td>
                        <td>Q. {{$avalorpro}}</td>
                        <td></td>
                    <td></td>
                    </tr>
                    @if($tpago!=null)
                    @if($tpago==2)
                    <tr>
                      <th></th>
                        <th></th>
                        
                        <th>Recargo Tarjeta:</th>
                        <th>Q. {{ ($sumacuenta+$avalorpro+$valoradomicilio)*0.05}}</th>
                 
                        <th></th>
                        <th></th>
                      </tr>
                    @else

                    @endif
                    @endif
                    <tr>
                      <th></th>
                        <th></th>
                     
                        <th>Total Cuenta:</th>
                        @if($tpago==2)
                        <th>Q.  {{ ($sumacuenta+$avalorpro)+(($sumacuenta+$avalorpro+$valoradomicilio)*0.05)}}</th>
                        @elseif($tpago==1)
                        <th>Q. {{ $sumacuenta+$avalorpro}}.00</th>
                        @else
                        <th>Q. {{ $sumacuenta+$avalorpro}}.00</th>
                        @endif
                       
                        <th></th>
                        <th></th>
                      </tr>

                  </tbody>

                      
                </table>
                  </div>
                @if($cancelado<3)
                  <h4 class="font-weight-bolder">
                      Metodo de Pago:
                  </h4>
                  <div class="input-group input-group-outline mb-3">
                  <div class="form-check">
                      <input class="form-check-input" wire:click="tipopago('1','{{$idpedido}}')" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                      <label class="form-check-label" for="flexRadioDefault1">
                       Efectivo
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" wire:click="calpagotc('2','{{$idpedido}}','{{$sumacuenta+$avalorpro}}')" type="radio" name="flexRadioDefault" id="flexRadioDefault2" >
                      <label class="form-check-label" for="flexRadioDefault2">
                       Tarjeta Debito/Credito
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" wire:click="pagomixto('1','{{$idpedido}}','{{$sumacuenta+$avalorpro}}')" type="radio" name="flexRadioDefault" id="flexRadioDefault20" >
                      <label class="form-check-label" for="flexRadioDefault20">
                       Mixto
                      </label>
                    </div>
                  </div>
                  @endif
  
                  @if($tpago!=null)
                  @if($tpago==1)
                  <div class="row g-2">
                    <div class="col-md">
                      <label class="form-label">Monto Efectivo: </label>
                      <div class="input-group input-group-outline mb-3">
                        <input type="text" class="form-control" wire:model='monto_efec' wire:keydown='calcambio("{{$sumacuenta+$avalorpro}}")' vwire:click='calcambio("{{$sumacuenta+$avalorpro}}")' placeholder="Q." required>
                      </div>
                  </div>
                  <div class="col-md">
                    <label class="form-label">Cambio Efectivo: </label>
                    <div class="input-group input-group-outline mb-3">
                      <input type="text" class="form-control" wire:model='cambio' placeholder="Q." disabled>
                    </div>
                  </div>
                  @if($monto_efec!=null && $monto_efec>0 && $cambio>=0)
                  @include('cuenta.modalvaltippago')
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmartippago"title="Confirmar Orden">
                      Confirmar Cuenta
                  </button>
                  @else
                  <button type="button" class="btn btn-danger" title="Conf Orden" disabled>
                    Confirmar Cuenta
                </button>
                  @endif
                  </div>
                  @elseif($tpago==2)
                  <div class="col-md">
                      <label class="form-label">Fact. Voucher </label>
                  <div class="input-group input-group-outline mb-3">
                      <input type="text" class="form-control" wire:model="notc">
                    </div>
                  </div>
                  @if($cuentamasrecargo!=null)
                  <div class="col-md">
                    <label class="form-label">Monto Final  + Recargo <b> 5%. </b> </label>
                <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" wire:model="cuentainput" required disabled>
                  </div>
                </div>
                @error('notc') 
                <div class="alert alert-danger" role="alert">
                 Ingrese # de Voucher.
               </div>
                @enderror
                @endif
                  @if($cuentamasrecargo!=null)
                  @include('cuenta.modalvaltippago')
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmartippago"title="Confirmar Orden">
                      Confirmar Cuenta
                  </button>
                  @endif
                  @endif


                  @endif
                  @if($tpago!=null && $tpago==3)
                @if($pago_mixto!=null && $pago_mixto==3)
                <div class="row g-2">
                    <div class="col-md">
                      <label class="form-label">Monto Efectivo: </label>
                      <div class="input-group input-group-outline mb-3">
                        <input type="text" class="form-control" wire:model='monto_efec2' wire:keydown='pen_pag_tc("{{$sumacuenta+$avalorpro+$valoradomicilio}}")' vwire:click='calcambio("{{$sumacuenta+$avalorpro+$valoradomicilio}}")' placeholder="Q." required>
                      </div>
                  </div>
                  </div>
                  <div class="row g-2">
                    <div class="col-md">
                      <label class="form-label">Monto TC: </label>
                      <div class="input-group input-group-outline mb-3">
                        <input type="text" class="form-control" wire:model='monto_tc_par' wire:keydown='caltc("{{$sumacuenta+$avalorpro+$valoradomicilio}}")' vwire:click='calcambio("{{$sumacuenta+$avalorpro+$valoradomicilio}}")' placeholder="Q." required>
                      </div>
                  </div>
                 
                  <div class="col-md">
                    <label class="form-label">Monto TC + Recargo: </label>
                    <div class="input-group input-group-outline mb-3">
                      <input type="text" class="form-control" wire:model='cuentainput2' placeholder="Q." disabled>
                    </div>
                  </div>
                  </div>

                  <div class="row g-2">
                  <div class="col-md">
                      <label class="form-label">Fact. Voucher </label>
                  <div class="input-group input-group-outline mb-3">
                      <input type="text" class="form-control" wire:model="notc" >
                    </div>
                    @error('notc') 
                    <div class="alert alert-danger" role="alert">
                     Ingrese # de voucher.
                   </div>
                    @enderror
                  </div>

                  <div class="col-md">
                    <label class="form-label">Monto Total: </label>
                    <div class="input-group input-group-outline mb-3">
                     <b>
                     <input type="text" class="form-control" wire:model='sumaefetc' placeholder="Q." disabled>
                     </b>
                    </div>
                  </div>
                  </div> 
                  @if($sumaefetc!=null and $notc!=null)
                  @include('cuenta.modalvaltippago')
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmartippago"title="Confirmar Orden">
                      Confirmar Cuenta
                  </button>
                  @endif


                @endif
                @endif



                  </div> 
            
            </div>
          </div>
        </div>
        @endif
        @endif

        @if($op!==null && $op==4 && Session::get('platillosc')!=null)
        @if(Session::get('detallepedidos')!=null)
        <div class="accordion-item">
          @php 
          $subtotalp=0;
          $subtotalex=0;
          $sumacuenta=0;
          $valorpro=0;
          @endphp
          <h2 class="accordion-header" id="flush-collapseFOR13">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFOR13" aria-expanded="false" aria-controls="flush-collapseFOR13">
              <h4 class="font-weight-bolder">Ver Detalles</h4>
            </button>
          </h2>
          <div id="flush-collapseFOR13" class="accordion-collapse" aria-labelledby="flush-collapseFOR13" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
                <div class="row">
                  <div class="table-responsive">
                  <table class="table table-hover">
                      <thead>
                         
                          <th>
                            @if($cance==2)
                            <button class="btn btn-primary" wire:click="cargainfo()">Imprimir</button>
                          @endif
                          </th>
                          <th class="text-center"><p>
                             <p> Pedido Interno </p>
                             <p>{{$fecha}}</p>
                             <p>Mesero: {{$nombreMesero}}</p>
                          </p>
                          </th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                      </thead>
                      @if($op==4)
                      <thead>
                        <th></th>
                        <th >Colaborador: {{$nom_cliente}}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </thead>
                      @endif

               
                      <thead>
                        <th >Cantidad</th>
                        <th >Platillo</th>
                        <th >Observacion</th>
                        <th >Costo</th>
                        <th >Totales</th>
                        <th>Accion</th>
                        <th>Estado</th>
                      </thead>
                      <tbody>
              
                  @foreach(Session::get('detallepedidos') as $detalle_p)

                  <tr>
                  @foreach(Session::get('platillosc') as $platillo)

                  @if($detalle_p->ID_PLATILLO==$platillo->ID_PLATILLO && $detalle_p->extra==0)
                  
                  @php
                  $subtotalp=($subtotalp+$detalle_p->SUB_TOTAL); @endphp

                  <td>{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                      <td> {{$platillo->TITULO_PLATILLO}}</td>
                      @if(strlen($detalle_p->OBSERVACION)>3)
                      <td><b><span class="badge bg-warning text-dark">{{$detalle_p->OBSERVACION}}</span></b></td>
                      @else
                      <td> {{$detalle_p->OBSERVACION}} </td>
                      @endif
                      <td>Q. {{$platillo->COSTO_PLATILLO}}</td>
                      <td>Q. {{($detalle_p->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO+$detalle_p->costo_cambio)-$detalle_p->costo_guarnicion}} </td>
                      @if($detalle_p->OBSERVACION=="N/A")                      
                      <td></td>
                      @else
                      <td>
                        <div class="row g-2">
                          <div class="col-md">
                          <label class="form-label">Cambio: </label>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(1)" id="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}" value="option1">
                            <label class="form-check-label" for="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}">Si</label>
                          </div>
                       
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(2)" id="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}" value="option2">
                            <label class="form-check-label" for="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}">No</label>
                          </div>
                        </div>
                        <div class="col-md">
                          <div class="input-group input-group-outline mb-2">
                            <input type="text" class="form-control" wire:model="valorcambio" placeholder="Q.">
                          </div>
                        </div>
                        <div class="col-md">
                          <div class="form-check form-check-inline">
                            <button type="button" class="btn btn-primary" wire:click="advalorcambio('{{$detalle_p->ID_DETALLE_PEDIDO}}','{{$detalle_p->ID_PEDIDIO}}')" title="Conf Orden">+</button>
                        </div>
                      </div>
                      </div>
                   
                      </td>
                     
                      @endif
                      @if($pedido->ESTADO_PEDIDO<=2)
                      <td><span class="badge bg-danger">Pendiente E.</span></td>
                      @else
                      <td></td>
                      @endif
                       @endif
                       @endforeach
                
                  @foreach(Session::get('bebidasc') as $bebida)
                  @if( $detalle_p->ID_PLATILLO == $bebida->ID_BEBIDA  && $detalle_p->extra==0)
                  @php
                 $subtotalp=$subtotalp+$detalle_p->SUB_TOTAL;  @endphp
                  <?php$ca=$ca+1;?>
                  <td>{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                  <td>  {{$bebida->TITUTLO_BEBIDA}} </td>
                  <td> {{$detalle_p->OBSERVACION}} </td>
                  <td>Q. {{$bebida->COSTO_BEBIDA}}</td>
                  <td>Q. {{$detalle_p->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA}} </td>
                  <td></td>
                  @if($pedido->ESTADO_PEDIDO<=2)
                  <td><span class="badge bg-danger">Pendiente E.</span></td>
                  @else
                  <td></td>
                  @endif
                @endif
                  @endforeach

                  </tr>
                  @endforeach

                  <tr>
                    <th></th>
                      <th></th>
                      <th class="text-center">Extras</th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                  </tr>


                  @foreach(Session::get('detallepedidos') as $detalle_p)
                  <tr>
                  @foreach(Session::get('platillosc') as $platillo)

                  @if($detalle_p->ID_PLATILLO==$platillo->ID_PLATILLO && ($detalle_p->extra==2 or  $detalle_p->extra==1))
                  @php
                  $subtotalex=($subtotalex+$detalle_p->SUB_TOTAL); 
                  @endphp
                      <td>{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                      <td> {{$platillo->TITULO_PLATILLO}}</td>
                      @if(strlen($detalle_p->OBSERVACION)>3)
                      <td><b><span class="badge bg-warning text-dark">{{$detalle_p->OBSERVACION}}</span></b></td>
                      @else
                      <td> {{$detalle_p->OBSERVACION}} </td>
                      @endif
                      <td>Q. {{$platillo->COSTO_PLATILLO}}</td>
                      <td>Q. {{(($detalle_p->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detalle_p->costo_cambio)-$detalle_p->costo_guarnicion}} </td>
                      @if($detalle_p->OBSERVACION=="N/A")                      
                      <td></td>
                      @else
                      <td>
                        <div class="row g-2">
                          <div class="col-md">
                          <label class="form-label">Cambio: </label>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(1)" id="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}" value="option1">
                            <label class="form-check-label" for="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}">Si</label>
                          </div>
                       
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" wire:click="op(2)" id="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}" value="option2">
                            <label class="form-check-label" for="inlineRadio{{$detalle_p->ID_DETALLE_PEDIDO}}">No</label>
                          </div>
                        </div>
                        <div class="col-md">
                          <div class="input-group input-group-outline mb-2">
                            <input type="text" class="form-control" wire:model="valorcambio" placeholder="Q.">
                          </div>
                        </div>
                        <div class="col-md">
                          <div class="form-check form-check-inline">
                            <button type="button" class="btn btn-primary" wire:click="advalorcambio('{{$detalle_p->ID_DETALLE_PEDIDO}}','{{$detalle_p->ID_PEDIDIO}}')" title="Conf Orden">+</button>
                        </div>
                      </div>
                      </div>
                   
                      </td>
                      @if($pedido->ESTADO_EXTRA<=2)
                      <td><span class="badge bg-danger">Pendiente E.</span></td>
                      @else
                      <td></td>
                      @endif
                      @endif
                       @endif
                       @endforeach
                
                  @foreach(Session::get('bebidasc') as $bebida)
                  @if( $detalle_p->ID_PLATILLO == $bebida->ID_BEBIDA  && ($detalle_p->extra==2 or  $detalle_p->extra==1))
                  @php
                  $subtotalex=$subtotalex+$detalle_p->SUB_TOTAL;
                  @endphp
                  <?php$ca=$ca+1;?>
                  <td>{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                  <td>  {{$bebida->TITUTLO_BEBIDA}} </td>
                  <td> {{$detalle_p->OBSERVACION}} </td>
                  <td>Q. {{$bebida->COSTO_BEBIDA}}</td>
                  <td>Q. {{$detalle_p->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA}} </td>
                  <td></td>
                @endif
                  @endforeach
                  @if($pedido->ESTADO_EXTRA<=2)
                  <td><span class="badge bg-danger">Pendiente E.</span></td>
                  @else
                  <td></td>
                  @endif
                  </tr>
                  
                  @endforeach

                  
                  <tr>
                    <td></td>
                    <td></td>
                   
                    <td>Sub-Total</td>
                    @php
                    $sumacuenta=$subtotalp+$subtotalex;
                    @endphp
                    <td>Q. {{$subtotalp+$subtotalex}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @if($tpago!=null)
                @if($tpago==2)
                <tr>
                  <th></th>
                    <th></th>
                    
                    <th>Recargo Tarjeta:</th>
                    <th>Q. {{ ($sumacuenta)*0.05}}</th>
             
                    <th></th>
                    <th></th>
                  </tr>
                @else

                @endif
                @endif
                    <tr>
                      
                        <th></th>
                        <th></th>
                        <th>Total Cuenta:</th>
                        @if($tpago==2)
                        <th>Q. {{ ($sumacuenta)+(($sumacuenta)*0.05)}}</th>
                        @else
                        <th>Q. {{ $sumacuenta}}</th>
                        @endif
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                         

                  </tbody>

                      
                </table>
                  </div>
               @if($cancelado<3)
                  <h4 class="font-weight-bolder">
                      Metodo de Pago:
                  </h4>
                  <div class="input-group input-group-outline mb-3">
                  <div class="form-check">
                      <input class="form-check-input" wire:click="tipopago('1','{{$idpedido}}')" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                      <label class="form-check-label" for="flexRadioDefault1">
                       Efectivo
                      </label>
                    </div>
                    <!--
                    <div class="form-check">
                      <input class="form-check-input" wire:click="calpagotc('2','{{$idpedido}}','{{$sumacuenta}}')" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                      <label class="form-check-label" for="flexRadioDefault2">
                       Tarjeta Debito/Credito
                      </label>
                    </div>
                  -->
                  </div>
                  @endif
  
                  @if($tpago!=null)
                  @if($tpago==1)
                  <div class="row g-2">
                    <div class="col-md">
                      <label class="form-label">Monto Efectivo: </label>
                      <div class="input-group input-group-outline mb-3">
                        <input type="text" class="form-control" wire:model='monto_efec' wire:keydown='calcambio("{{$sumacuenta}}")' vwire:click='calcambio("{{$sumacuenta}}")' placeholder="Q." required>
                      </div>
                  </div>
                  <div class="col-md">
                    <label class="form-label">Cambio Efectivo: </label>
                    <div class="input-group input-group-outline mb-3">
                      <input type="text" class="form-control" wire:model='cambio' placeholder="Q." disabled>
                    </div>
                  </div>
                  @if($monto_efec!=null && $monto_efec>0 && $cambio>=0)
                  @include('cuenta.modalvaltippago')
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmartippago"title="Confirmar Orden">
                      Confirmar Cuenta
                  </button>
                  @else
                  <button type="button" class="btn btn-danger" title="Conf Orden" disabled>
                    Confirmar Cuenta
                </button>
                  @endif
                  </div>
                  @elseif($tpago==2)
                  <div class="col-md">
                      <label class="form-label">Fact. Voucher </label>
                  <div class="input-group input-group-outline mb-3">
                      <input type="text" class="form-control" wire:model="notc">
                    </div>
                  </div>
                  @if($cuentamasrecargo!=null)
                  <div class="col-md">
                    <label class="form-label">Monto Final  + Recargo <b> 5%. </b> </label>
                <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" wire:model="cuentainput" required disabled>
                  </div>
                </div>
                @error('notc') 
                <div class="alert alert-danger" role="alert">
                 Ingrese # de Voucher.
               </div>
                @enderror
                @endif
                  @if($cuentamasrecargo!=null)
                  @include('cuenta.modalvaltippago')
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmartippago"title="Confirmar Orden">
                      Confirmar Cuenta
                  </button>
                  @endif
                  @endif

                  
                  @endif 
                  </div> 
            
            </div>
          </div>
        </div>
        @endif
        @endif
    </div>
</div>
