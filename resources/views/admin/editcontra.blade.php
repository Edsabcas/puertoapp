<div wire:ignore.self class="modal fade" id="update4User{{ $user->id }}" tabindex="-1" role="dialog"  aria-labelledby="update4User{{ $user->id }}" aria-hidden="true" >
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="update4User{{ $user->id }}">Editar Pass: {{$user->name}}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <div class="modal-body">

            <form >
               <div class="col-md">
              <label class="form-label">Contraseña Temporal:</label>
              <div class="input-group input-group-outline mb-3">                    
                <input type="password" class="form-control" wire:model="pasup">
              </div>
              @error('pasup') 
              <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                
                  <span>Pendiente de ingreso</span>
                 </div> @enderror
               </div>
               <label class="form-label">Solicitar cambio de contraseña:</label>
               <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" wire:model="rsi">
                <label class="form-check-label" for="flexSwitchCheckDefault">Si</label>
              </div>
              </form>
</div>

<div class="modal-footer">
    <input class="btn btn-primary"  value="editar" data-bs-dismiss="modal" wire:click="upcontra({{$user->id}})"/>
    
    <button class="form-control"type="button" data-bs-dismiss="modal" wire:click.prevent='cancelar()'>Salir</button>
</div>
</div>

</div>
</div>
