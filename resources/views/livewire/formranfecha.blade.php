<form class="settings-form">
    <div class="col-auto">
        <label class="form-check-label">Del</label>
        <input type="date" class="form-control" wire:model='p_laborado_inicio'>
        @error('p_laborado_inicio') 
        <div class="alert alert-danger d-flex align-items-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <span>Pendiente de ingreso</span>
           </div> @enderror
    </div>
    <div class="col-auto">
        <label class="form-check-label">Al</label>
        <input type="date" class="form-control" wire:model='p_laborado_fin'>
        @error('p_laborado_fin') 
        <div class="alert alert-danger d-flex align-items-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <span>Pendiente de ingreso</span>
           </div> @enderror
    </div>
</form>