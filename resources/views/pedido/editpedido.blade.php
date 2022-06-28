<div wire:ignore.self class="modal fade" id="editorden" tabindex="-1" role="dialog"  aria-labelledby="editorden" aria-hidden="true" >
    <div class="modal-dialog">
      @php
      $montotemp=0;
      @endphp
        <div class="modal-content">
          <div class="modal-header">
            @if($noMesa !=null)
            <h4 class="modal-title" id="editorden">Detalle Pedido Mesa No. {{$noMesa}}</h4>
            @endif
  
            @if($cat2!=null)
            <h4 class="modal-title" id="editorden">Detalle Pedido a Domicilio</h4>
            @endif
            @if($cat3!=null)
            <h4 class="modal-title" id="editorden">Detalle Pedido para llevar</h4>
            @endif




            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
         
            <div class="modal-body">
              @if($cat2!=null)
              <form wire:submit.prevent="updatos2()" class="form-floating">
                <div class="row g-2">
                  <div class="col-md">
                <label class="form-label">Nombre:</label>
                <div class="input-group input-group-outline mb-3">
                  <input type="text" class="form-control" wire:model="nombre_orden2" >
                </div>
            </div>
            @error('nombre_orden2') 
            <div class="alert alert-danger" role="alert">
             Seleccione la cantidad.
           </div>
            @enderror
                   <div class="col-md">
                   <label class="form-label">No. Telefono:</label>
                <div class="input-group input-group-outline mb-3">
                    <input type="number" class="form-control" wire:model="telefono" >
                  </div>
            
              </div>
              @error('telefono') 
              <div class="alert alert-danger" role="alert">
               Seleccione la cantidad.
             </div>
              @enderror
              <div class="col-md">
                <label class="form-label">Direccion:</label>
                <div class="input-group input-group-outline mb-3">
                <input type="text" class="form-control" wire:model="direccion">
                    </div>
                </div>
                @error('direccion') 
                <div class="alert alert-danger" role="alert">
                 Seleccione la cantidad.
               </div>
                @enderror
             
              <div class="col-md">
                  <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Actualizar</button>
                </div>
              </div>
               </form>  

              @endif
              @if($cat3!=null)
              <form wire:submit.prevent="updatos3()" class="form-floating">
                <div class="row g-2">
                  <div class="col-md">
                <label class="form-label">Nombre para Orden</label>
                <div class="input-group input-group-outline mb-3">
                  <input type="text" class="form-control" wire:model="nombre_orden3" required>
                </div>
                @error('nombre_orden3') 
                <div class="alert alert-danger" role="alert">
                 Seleccione la cantidad.
               </div>
                @enderror
               </div>
                <div class="col-md">
                <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Actualizar</button>
                
            </div>
                </div>
              </form>
              @endif
  
              @if($ed_pla!==null)
              <form wire:submit.prevent="" class="form-floating">
    
                <div class="row g-1">
                  <div class="col-md">
                    <label class="form-label">Platillo:</label>
                  <div class="input-group input-group-outline mb-3">
                  <input type="text" class="form-control" wire:model="tipla" disabled>
                </div>
              </div>
                  <div class="col-md">
                    <label class="form-label">Cantidad:</label>
                  <div class="input-group input-group-outline mb-3">
                  <input type="text" class="form-control" wire:model="cantidad1">
                </div>
                @error('cantidad1') 
                <div class="alert alert-light" role="alert">
                Pendiente de ingreso
                </div>
                 @enderror
              </div>
              <div class="col-md">
                <label class="form-label">Observaciones:</label>
                <div class="input-group input-group-outline mb-3">
                  <input type="text" class="form-control" wire:model="observaciones1">
                </div>
                @error('observaciones1') 
                <div class="alert alert-light" role="alert">
                  Pendiente de ingreso
                  </div> @enderror
              </div>
              <div class="col-md">
                <div class="text-center">
                  <button wire:click='edititem()'class="btn btn-link text-dark px-3 mb-0">
                    <i class="material-icons text-sm me-2">edit</i>Editar</button>
                </div>
              </div>
            </div>
              </form>
              @endif



              @if(Session::get('edit')!=null)
              
              <div class="alert alert-success" role="alert">
                  Agregado Correctamente.
                </div>
                {{session()->forget('edit');}}
              @endif
              @if(Session::get('delete1')!=null)
              
              <div class="alert alert-danger" role="alert">
                Se eliminado Correctamente.
                </div>
                {{session()->forget('delete1');}}
              @endif

                <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr class="form-label">
                      <td>Cantidad</td>
                      <td>Descripcion</td>
                      <td>SubTotal</td>
                      <td>Comentario</td>
                      <td>Accion</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $var=0;?>
                  
                    @if(Session::get('orden')!=null)
                    @foreach(Session::get('orden') as $orden)
                    <tr class="form-label">
                      <td class="text-center">{{$orden->cantidad}}</td>
                      <td >{{$orden->titulo_pla}}</td>
                       @php
                       $montotemp=$montotemp+$orden->subtotal;
                       @endphp
                      <td>Q. {{$orden->subtotal}}</td>
                      <td>  {{$orden->observacion}}</td>
                      <td>
                              <button wire:click='cargaedititem("{{$orden->id_temp}}","{{$orden->costo}}","{{$orden->cantidad}}","{{$orden->observacion}}","{{$orden->titulo_pla}}","{{$orden->costo_cambio}}")'class="btn btn-link text-dark px-3 mb-0">
                                <i class="material-icons text-sm me-2">edit</i></button>
                                
                              <button wire:click="mostrarbtneliminar({{$orden->id_temp}})" class="btn btn-link text-dark px-3 mb-0" >
                                <i class="material-icons text-sm me-2">delete</i></button>

                      </td>
                    </tr>
                    @endforeach
                   
                    @endif
                  </tbody>
                </table>
     
              </div>
              <div class="col-md">
                <label class="form-label">Monto al momento: <b> Q. {{$montotemp}}.00 </b></label>
          </div>
              @if($eliminaritem!=null)
              <label class="form-label"><b>¿Confirme Eliminar platillo/bebida?:</b></label>
              <button class="form-control btn btn-danger"type="button" wire:click.prevent='eliminarItem()'>Si</button>
             <button class="form-control"type="button"  wire:click.prevent='cancelarelim()'>No</button>
             @endif
</div>

<div class="modal-footer">
    <input class="form-control btn btn-success" type="button" wire:click="crearpedido()" data-bs-dismiss="modal" value="Enviar pedido" />
    <button class="form-control btn btn-danger" type="button" data-bs-dismiss="modal" >Seguir Agregando</button>
</div>


</div>

</div>
</div>
