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
              <select class="form-control" wire:model="ID_MESA" disabled>
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
                  <select class="form-control" wire:model="ESTADO_PEDIDO" disabled>
                    <option select></option>
                    <option value="1">Prep. cocina</option>
                    <option value="2">Pend. Entrega mesa.</option>
                    <option value="0">Prep. Cocina/serv.</option>
                    <option value="2">Pend. Entrega mesa.</option>
                    <option value="3">Entregado.</option>
                  </select>
                </div>
              </div>
              <div class="col-md">
                <label class="form-label">Cobro:</label>
                <div class="input-group input-group-outline mb-3">
                  <select class="form-control" wire:model="cancelado" disabled>
                    <option select></option>
                    <option value="0">Pendiente</option>
                    <option value="1">Pendiente Impresion</option>
                    <option value="2">Pendiente pago</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row g-1">
              @if(Session::get('rol')!=null and (Session::get('rol')=='1' or Session::get('rol')=='7'))
              <div class="col-md">
                <label class="form-label">Monto Cuenta:</label>
                <div class="input-group input-group-outline mb-3">
                  <input type="text" class="form-control" wire:model="MONTO_CUENTA" disabled>
                </div>
              </div>
              @endif
   
   
              <div class="col-md">
                <label class="form-label">Estado Extra:</label>
                <div class="input-group input-group-outline mb-3">
                  <select class="form-control" wire:model="extra" disabled >
                    <option select></option>
                    <option value="1">Cocina</option>
                    <option value="2">Pendiente entrega</option>
                    <option value="3">Entregado</option>
                    <option value="0">Sin Extra</option>
                  </select>
                </div>
              </div>
            </div>
              </form>

@if($valcarga!=null)
                <div class="table-responsive">
                 <h4 class="modal-title" >Detalle Pedido</h4>
                  <table class="table table-hover">
                    <thead>
                      <th></th>
                      <th></th>
                    
                      <th class="text-center">Pedido Original</th>
                      <th></th>
                   
                  </thead>
                    <thead>
                      <th >Descripción</th>
                      
                      <th >Cantidad</th>
                      <th >Costo</th>
                      <th >Totales</th>
                   
                    </thead>
                    <tbody>
                  

                @foreach(Session::get('detallepedidos') as $detalle_p)

                @foreach(Session::get('platillosc') as $platillo)
                
                @if($detalle_p->ID_PLATILLO==$platillo->ID_PLATILLO && $detalle_p->extra==0)
                @php
                $subtotalp=$subtotalp+$detalle_p->SUB_TOTAL; @endphp
                    <td> {{$platillo->TITULO_PLATILLO}}</td>
                    <td>{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                    <td>Q. {{$platillo->COSTO_PLATILLO}}</td>
                    <td>Q. {{$detalle_p->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO}} </td>
                    @endif
                   
                     @endforeach
              
                @foreach(Session::get('bebidasc') as $bebida)
                @if( $detalle_p->ID_PLATILLO == $bebida->ID_BEBIDA  && $detalle_p->extra==0)

                @php
               $subtotalp=$subtotalp+$detalle_p->SUB_TOTAL;  @endphp
                <?php$ca=$ca+1;?>
                <td>  {{$bebida->TITUTLO_BEBIDA}} </td>
                <td>{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
               <td>Q. {{$bebida->COSTO_BEBIDA}}</td>             
                <td>Q. {{$detalle_p->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA}} </td>
               
              @endif
                @endforeach

                </tr>
                @endforeach


                <thead>
                    <th></th>
                    <th></th>
                  
                    <th class="text-center">Extras</th>
                    <th></th>
                   
                </thead>

                <tr>
                  <th></th>
                  <th></th>
                   
                  <th class="text-center"></th>
                  <th></th>
                      
              </tr>
                @foreach(Session::get('detallepedidos') as $detalle_p)

                @foreach(Session::get('platillosc') as $platillo)

                @if($detalle_p->ID_PLATILLO==$platillo->ID_PLATILLO && $detalle_p->extra>=1)
                @php
                $subtotalex=$subtotalex+$detalle_p->SUB_TOTAL; 
                @endphp
                    <td> {{$platillo->TITULO_PLATILLO}}</td>
                    <td>{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
                   <td>Q. {{$platillo->COSTO_PLATILLO}}</td>
                   
                    <td>Q. {{$detalle_p->CANTIDAD_SOLICITADA * $platillo->COSTO_PLATILLO}} </td>
                   
                     @endif
                     @endforeach
              
                @foreach(Session::get('bebidasc') as $bebida)
                @if($detalle_p->ID_PLATILLO==$bebida->ID_BEBIDA  && $detalle_p->extra>=1)
                @php
                $subtotalex=$subtotalex+$detalle_p->SUB_TOTAL;
                @endphp
                <?php$ca=$ca+1;?>
                <td>  {{$bebida->TITUTLO_BEBIDA}} </td>
                <td>{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
              
                <td>Q. {{$bebida->COSTO_BEBIDA}}</td>

                <td>Q. {{$detalle_p->CANTIDAD_SOLICITADA * $bebida->COSTO_BEBIDA}} </td>
            
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