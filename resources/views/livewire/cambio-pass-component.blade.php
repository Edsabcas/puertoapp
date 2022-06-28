<div class="container">
    <section>
      <div class="card-header">
        <h4 class="font-weight-bolder">cambio Contraseña requerido</h4>

        
      </div>
      <div class="card-body">
        <form role="form">
          <div class="row g-2">
            <div class="col-md">
             
          <label class="form-label">Contraseña Actual:</label>
          <div class="input-group input-group-outline mb-3">
            <input type="password" class="form-control" wire:model="passactual">
          </div>
      
        @error('passactual') 
        <div class="alert alert-danger d-flex align-items-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <span>Pendiente de ingreso</span>
           </div> @enderror
      </div>
    
             <div class="col-md">
             <label class="form-label">Contraseña nueva:</label>
          <div class="input-group input-group-outline mb-3">
              <input type="password" class="form-control" wire:model="nueva1" >
            </div>
         
          @error('nueva1') 
            <div class="alert alert-danger d-flex align-items-center" role="alert">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
              
                <span>Pendiente de ingreso</span>
               </div> @enderror
        </div>
        <div class="col-md">
            <label class="form-label">Confirmar contraseña:</label>
         <div class="input-group input-group-outline mb-3">
             <input type="password" class="form-control" wire:model="nueva2" >
           </div>
        
         @error('nueva2') 
           <div class="alert alert-danger d-flex align-items-center" role="alert">
             <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
             
               <span>Pendiente de ingreso</span>
              </div> @enderror
       </div>
        <div class="col-md">
            <div class="text-center">
              <button type="button" wire:click="cambiopass({{auth()->user()->id}})" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Actualizar</button>
            </div>
          </div>
              </div>
            </div>
            <div class="inner">
                @if(Session::get('passnocoinciden')!=null)
                {{session()->forget('passnocoinciden');}}
                <div class="alert alert-warning" role="alert">
                No coinciden las contraseñas, y/o no puede ser la misma contraseña actual; favor validar.
                </div>
                @endif
                @if(Session::get('passnocoinciden1')!=null)

                <div class="alert alert-light" role="alert">
                No coinciden la contraseña actual.
                </div>
                {{session()->forget('passnocoinciden1');}}
                @endif
            </div>  
        </div>