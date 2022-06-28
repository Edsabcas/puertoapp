<div wire:ignore.self class="modal fade"  id="editorden" tabindex="-1" role="dialog"  aria-labelledby="editorden" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" >Pedido Mesa No.</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
         
            <div class="modal-body">

              <form wire:submit.prevent="" class="form-floating">

                <div class="row g-1">
                  <div class="col-md">
                    <label class="form-label">No Pedido:</label>
                  <div class="input-group input-group-outline mb-3">
                  <input type="text" class="form-control" wire:model="NO_PEDIDO" disabled>
                </div>
              </div>
              <div class="col-md">
                <label class="form-label">Fecha Pedido:</label>
                <div class="input-group input-group-outline mb-3">
                  <input type="text" class="form-control" wire:model="FECHA_CREACION_PEDIDO" disabled>
                </div>
              </div>
              <div class="col-md">
                <label class="form-label">No Mesa:</label>
              <div class="input-group input-group-outline mb-3">
              <select class="form-control" wire:model="ID_MESA">
                @if($nmesa!=null)
                <option select value="{{$ID_MESA}}">{{$this->nmesa}}</option>
                @else
                <option select></option>
                @endif
              @foreach($mesas as $mesa)
              <option value="{{$mesa->ID_MESA}}"> {{$mesa->NO_MESA}}</option>
              @endforeach
          </select>
            </div>
            @error('ID_MESA') 
            <div class="alert alert-light" role="alert">
            Pendiente de ingreso
            </div>
             @enderror
          </div>
            </div>

            <div class="row g-1">

              <div class="col-md">
                <label class="form-label">Empleado:</label>
                <div class="input-group input-group-outline mb-3">
                  @foreach($users as $user)
                  @if($user->id == $ID_EMPLEADO)
             <input type="text" class="form-control" value="{{$user->name}}" disabled>
                @endif
              @endforeach
                </div>
              </div>
              <div class="col-md">
                <label class="form-label">ESTADO PEDIDO:</label>
                <div class="input-group input-group-outline mb-3">
                  <select class="form-control" wire:model="ESTADO_PEDIDO">
                    <option select></option>
                    <option value="1">Prep. cocina</option>
                    <option value="2">Pend. Entrega mesa.</option>
                    <option value="0">Prep. Cocina/serv.</option>
                    <option value="2">Pend. Entrega mesa.</option>
                    <option value="3">Entregado.</option>
                  </select>
                </div>
                @error('ESTADO_PEDIDO') 
                <div class="alert alert-light" role="alert">
                  Pendiente de ingreso
                  </div> 
                  @enderror
              </div>
              <div class="col-md">
                <label class="form-label">Cobro:</label>
                <div class="input-group input-group-outline mb-3">
                  <select class="form-control" wire:model="cancelado" >
                    <option select></option>
                    <option value="0">Pendiente</option>
                    <option value="1">Pendiente Impresion</option>
                    <option value="2">Pendiente pago</option>
                  </select>
                </div>
                @error('cancelado') 
                <div class="alert alert-light" role="alert">
                  Pendiente de ingreso
                  </div> 
                  @enderror
              </div>
            </div>

            <div class="row g-1">
              <div class="col-md">
                <label class="form-label">Monto Cuenta:</label>
                <div class="input-group input-group-outline mb-3">
                  <input type="text" class="form-control" wire:model="MONTO_CUENTA" disabled>
                </div>
                @error('MONTO_CUENTA') 
                <div class="alert alert-light" role="alert">
                  Pendiente de ingreso
                  </div> 
                  @enderror
              </div>

   
   
              <div class="col-md">
                <label class="form-label">Estado Extra:</label>
                <div class="input-group input-group-outline mb-3">
                  <select class="form-control" wire:model="extra" >
                    <option select></option>
                    <option value="1">Pendiente</option>
                    <option value="2">Pendiente Impresion</option>
                    <option value="3">Pendiente pago</option>
                    <option value="0">Sin Extra</option>
                  </select>
                </div>
                @error('extra') 
                <div class="alert alert-light" role="alert">
                  Pendiente de ingreso
                  </div> 
                  @enderror
              </div>
              <div class="col-md">
                <div class="input-group input-group-outline mb-3">

                  <button wire:click='updatepedido()'class="btn btn-link text-dark px-3 mb-0">
                    <i class="material-icons text-sm me-2">edit</i>Editar</button>
                </div>
              </div>
            </div>
              </form>

              @if(Session::get('edit')!=null)
              
              <div class="alert alert-success" role="alert">
                  Agregado Correctamente.
                </div>
                {{session()->forget('edit');}}
              @endif
              @if(Session::get('delete1')!=null)
              
              <div class="alert alert-success" role="alert">
                Se eliminado Correctamente.
                </div>
                {{session()->forget('delete1');}}
              @endif

<div>
  @if($ed_pla!==null)
  <form wire:submit.prevent="" class="form-floating">
<h6>Editar Platillo: </h6>
    <div class="row g-1">
      <div class="col-md">
        <label class="form-label">Platillo:</label>
      <div class="input-group input-group-outline mb-3">
      <input type="text" class="form-control" wire:model="nompla" disabled>
    </div>
  </div>
      <div class="col-md">
        <label class="form-label">Cantidad:</label>
      <div class="input-group input-group-outline mb-3">
      <input type="text" class="form-control" wire:model="cansolicitada">
    </div>
    @error('cansolicitada') 
    <div class="alert alert-light" role="alert">
    Pendiente de ingreso
    </div>
     @enderror
  </div>
  <div class="col-md">
    <label class="form-label">Monto:</label>
  <div class="input-group input-group-outline mb-3">
  <input type="text" class="form-control" wire:model="subt" disabled>
</div>
</div>
  <div class="col-md">
    <label class="form-label">Observaciones:</label>
    <div class="input-group input-group-outline mb-3">
      <input type="text" class="form-control" wire:model="observacion1">
    </div>
    @error('observacion1') 
    <div class="alert alert-light" role="alert">
      Pendiente de ingreso
      </div> @enderror
  </div>
  <div class="col-md">
    <div class="text-center">
      <button wire:click='updateitem()'class="btn btn-link text-dark px-3 mb-0">
        <i class="material-icons text-sm me-2">edit</i>Editar</button>
    </div>
  </div>
</div>
  </form>
  @endif
</div>
@if(Session::get('edit1')!=null)
              
<div class="alert alert-warning" role="alert">
    Actualizado Correctamente.
  </div>
  {{session()->forget('edit1');}}
@endif

@if(Session::get('erroredit')!=null)
              
<div class="alert alert-danger" role="alert">
  <span class="text-white text-capitalize ps-3">
    No fue posible editar.
  </span>
    
  </div>
  {{session()->forget('erroredit');}}
@endif


@if(Session::get('delete11')!=null)
              
<div class="alert alert-warning" role="alert">
    Eliminado Correctamente.
  </div>
  {{session()->forget('delete11');}}
@endif

@if(Session::get('error2')!=null)
              
<div class="alert alert-warning" role="alert">
    Validar a ocurrido un error 
  </div>
  {{session()->forget('error2');}}
@endif

@if($valcarga!=null)
                <div class="table-responsive">
                 <h4 class="modal-title" >Detalle Pedido</h4>
                  <table class="table table-hover">
                    <thead>
                      <th></th>
                      <th></th>
                      <th class="text-center">Pedido Original</th>
                      <th></th>
                      <th></th>
                  </thead>
                    <thead>
                      <th >Cantidad</th>
                      <th >Descripción</th>
                      <th >Observacion</th>
                      <th >Costo</th>
                      <th >Totales</th>
                      <th>Accion</th>
                    </thead>
                    <tbody>
                  

                @foreach(Session::get('detallepedidos') as $detalle_p)

                @foreach(Session::get('platillosc') as $platillo)
                
                @if($detalle_p->ID_PLATILLO==$platillo->ID_PLATILLO && $detalle_p->extra==0)
                @php
                $subtotalp=$subtotalp+$detalle_p->SUB_TOTAL; @endphp
                     <td>{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                    <td> {{$platillo->TITULO_PLATILLO}}</td>
                    <td>{{$detalle_p->OBSERVACION}}</td>
                    <td>Q. {{$platillo->COSTO_PLATILLO}}</td>
                    <td>Q. {{(($detalle_p->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO)+$detalle_p->costo_cambio)-$detalle_p->costo_guarnicion}} </td>
                    <td >
                    
                      <a  class="material-icons text-sm me-2">
                        <button type="button" id="Eliminar"  data-bs-dismiss="modal"  wire:click='tvalor("{{$detalle_p->ID_DETALLE_PEDIDO}}","{{$detalle_p->SUB_TOTAL}}","{{$detalle_p->extra}}","{{$detalle_p->ID_PEDIDIO}}")' class="btn btn-link text-dark px-3 mb-0" title="delete">
                        <i class="material-icons text-sm me-2">
                        delete</i>
                      </button>
                    </a>
                    <a  class="material-icons text-sm me-2" wire:click="editplatillo('{{$detalle_p->SUB_TOTAL}}','{{$platillo->TITULO_PLATILLO}}','{{$detalle_p->ID_DETALLE_PEDIDO}}','{{$platillo->ID_PLATILLO}}','{{$detalle_p->ID_PEDIDIO}}','{{$detalle_p->CANTIDAD_SOLICITADA}}','{{$detalle_p->OBSERVACION}}','{{$platillo->COSTO_PLATILLO}}')">
                      <button button type="button" class="btn btn-link text-dark px-3 mb-0">
                        <i class="material-icons text-sm me-2">edit</i>
                        </button>  
                  </a>
                
                    </td>
                     @endif
                     @endforeach
              
                @foreach(Session::get('bebidasc') as $bebida)
                @if( $detalle_p->ID_PLATILLO == $bebida->ID_BEBIDA  && $detalle_p->extra==0)

                @php
               $subtotalp=$subtotalp+$detalle_p->SUB_TOTAL;  @endphp
                <?php$ca=$ca+1;?>
                <td>{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                <td>  {{$bebida->TITUTLO_BEBIDA}} </td>
                <td>{{$detalle_p->OBSERVACION}}</td>
                <td>Q. {{$bebida->COSTO_BEBIDA}}</td>
                <td>Q. {{$detalle_p->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA}} </td>
                <td >

                  <a  class="material-icons text-sm me-2">
                    <button type="button" id="Eliminar"  data-bs-dismiss="modal"  wire:click='tvalor("{{$detalle_p->ID_DETALLE_PEDIDO}}","{{$detalle_p->SUB_TOTAL}}","{{$detalle_p->extra}}","{{$detalle_p->ID_PEDIDIO}}")' class="btn btn-link text-dark px-3 mb-0" title="delete">
                    <i class="material-icons text-sm me-2">
                    delete</i>
                  </button>
                </a>
                    <a  class="material-icons text-sm me-2" wire:click="editplatillo('{{$detalle_p->SUB_TOTAL}}','{{$bebida->TITUTLO_BEBIDA}}','{{$detalle_p->ID_DETALLE_PEDIDO}}','{{$platillo->ID_PLATILLO}}','{{$detalle_p->ID_PEDIDIO}}','{{$detalle_p->CANTIDAD_SOLICITADA}}','{{$detalle_p->OBSERVACION}}','{{$platillo->COSTO_PLATILLO}}')">
                  <button button type="button" class="btn btn-link text-dark px-3 mb-0">
                    <i class="material-icons text-sm me-2">edit</i>
                    </button>  
                  
              </a>
                </td>
              @endif
                @endforeach

                </tr>
                @endforeach


                <thead>
                    <th></th>
                    <th></th>
                    <th class="text-center">Extras</th>
                    <th></th>
                    <th></th>
                </thead>

                <tr>
                  <th></th>
                  <th></th>
                  <th class="text-center"></th>
                  <th></th>
                  <th></th>
              </tr>
                @foreach(Session::get('detallepedidos') as $detalle_p)

                @foreach(Session::get('platillosc') as $platillo)

                @if($detalle_p->ID_PLATILLO==$platillo->ID_PLATILLO && $detalle_p->extra>=1)
                @php
                $subtotalex=$subtotalex+$detalle_p->SUB_TOTAL; 
                @endphp
                <td>{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                    <td> {{$platillo->TITULO_PLATILLO}}</td>
                    <td>{{$detalle_p->OBSERVACION}}</td>
                    <td>Q. {{$platillo->COSTO_PLATILLO}}</td>
                    <td>Q. {{$detalle_p->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO}} </td>
                    <td >
                  
                      <a  class="material-icons text-sm me-2">
                        <button type="button"  id="Eliminar"  data-bs-dismiss="modal" wire:click='tvalor("{{$detalle_p->ID_DETALLE_PEDIDO}}","{{$detalle_p->SUB_TOTAL}}","{{$detalle_p->extra}}","{{$detalle_p->ID_PEDIDIO}}")' class="btn btn-link text-dark px-3 mb-0" title="delete">
                        <i class="material-icons text-sm me-2">
                        delete</i>
                      </button>
                    </a>
                    <a  class="material-icons text-sm me-2" wire:click="editplatillo('{{$detalle_p->SUB_TOTAL}}','{{$platillo->TITULO_PLATILLO}}','{{$detalle_p->ID_DETALLE_PEDIDO}}','{{$platillo->ID_PLATILLO}}','{{$detalle_p->ID_PEDIDIO}}','{{$detalle_p->CANTIDAD_SOLICITADA}}','{{$detalle_p->OBSERVACION}}','{{$platillo->COSTO_PLATILLO}}')">
                      <button button type="button" class="btn btn-link text-dark px-3 mb-0">
                        <i class="material-icons text-sm me-2">edit</i>
                        </button>
                  </a>
                    </td>
                     @endif
                     @endforeach
              
                @foreach(Session::get('bebidasc') as $bebida)
                @if( $detalle_p->ID_PLATILLO == $bebida->ID_BEBIDA  && $detalle_p->extra==1)
                @php
                $subtotalex=$subtotalex+$detalle_p->SUB_TOTAL;
                @endphp
                <?php$ca=$ca+1;?>
                <td>{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                <td>  {{$bebida->TITUTLO_BEBIDA}} </td>
                <td>{{$detalle_p->OBSERVACION}}</td>
                <td>Q. {{$bebida->COSTO_BEBIDA}}</td>
                <td>Q. {{$detalle_p->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA}} </td>
                <td >
                
                  <a  class="material-icons text-sm me-2">
                    <button type="button" id="Eliminar"  data-bs-dismiss="modal"  wire:click='tvalor("{{$detalle_p->ID_DETALLE_PEDIDO}}","{{$detalle_p->SUB_TOTAL}}","{{$detalle_p->extra}}","{{$detalle_p->ID_PEDIDIO}}")' class="btn btn-link text-dark px-3 mb-0" title="delete">
                    <i class="material-icons text-sm me-2">
                    delete</i>
                  </button>
                </a>
                <a  class="material-icons text-sm me-2" wire:click="editplatillo('{{$detalle_p->SUB_TOTAL}}','{{$bebida->TITUTLO_BEBIDA}}','{{$detalle_p->ID_DETALLE_PEDIDO}}','{{$detalle_p->ID_PLATILLO}}','{{$detalle_p->ID_PEDIDIO}}','{{$detalle_p->CANTIDAD_SOLICITADA}}','{{$detalle_p->OBSERVACION}}','{{$bebida->COSTO_BEBIDA}}')">
                  <button button type="button" class="btn btn-link text-dark px-3 mb-0">
                    <i class="material-icons text-sm me-2">edit</i>
                    </button>  
                  
              </a>
                </td>
              @endif
                @endforeach

                </tr>
                @endforeach


                </tbody>

                    
              </table>
              </div>
              @endif
</div>

<div class="modal-footer">
   <button class="form-control"type="button" wire:click="cancelaredit()" data-bs-dismiss="modal" >Cancelar</button>
</div>


</div>

</div>
</div>
