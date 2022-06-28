<div wire:ignore.self class="modal fade" id="editorden" tabindex="-1" role="dialog"  aria-labelledby="editorden" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="editorden">Detalle Pedido</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
         
            <div class="modal-body">
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

              @if($eliminaritem!=null)
               <label class="form-label">¿Seguro que desea eliminar el item del pedido?:</label>
               <button class="form-control btn btn-primary"type="button" wire:click.prevent='eliminarItem()'>Si</button>
              <button class="form-control"type="button"  wire:click.prevent='cancelar()'>No</button>
              @endif

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

                <label class="form-label">Pedido Mesa:{{$noMesa}}</label>
                <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr class="form-label">
                      <td>No. correlativo.</td>
                      <td>Descripcion</td>
                      <td>Cantidad</td>
                      <td>SubTotal</td>
                      <td>Comentario</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $var=0;?>
                  
                    @if(Session::get('orden')!=null)
                    @foreach(Session::get('orden') as $orden)
                    <tr class="form-label">
                    
                      <td>{{$var=$var+1}}</td>
                      <td>{{$orden->titulo_pla}}</td>
                       <td> {{$orden->cantidad}}</td>
                    
                      <td>Q. {{$orden->subtotal}}</td>
                      <td>
                        <p class="form-label">
                          {{$orden->observacion}}
                              <button wire:click='cargaedititem("{{$orden->id_temp}}","{{$orden->costo}}","{{$orden->cantidad}}","{{$orden->observacion}}","{{$orden->titulo_pla}}")'class="btn btn-link text-dark px-3 mb-0">
                                <i class="material-icons text-sm me-2">edit</i></button>
                                
                              <button wire:click="mostrarbtneliminar({{$orden->id_temp}})" class="btn btn-link text-dark px-3 mb-0" >
                                <i class="material-icons text-sm me-2">delete</i></button>
                        </p>

                      </td>
                    </tr>
                    @endforeach
                   
                    @endif
                  </tbody>
                </table>
              </div>
</div>

<div class="modal-footer">
    <input class="form-control btn btn-primary" type="button"  value="Generar Pedido"wire:click="valcrearpedidos()"/>
    <button class="form-control"type="button" data-bs-dismiss="modal">Seguir Agregando</button>
</div>
@if($valpedido!=null)
<label class="form-label">¿Ya confirmo el pedido?:</label>
<button class="form-control btn btn-primary"type="button" data-bs-dismiss="modal" wire:click.prevent='crearpedido()'>Si</button>
<button class="form-control"type="button"  wire:click.prevent='continuarp()'>No</button>
@endif



</div>

</div>
</div>
