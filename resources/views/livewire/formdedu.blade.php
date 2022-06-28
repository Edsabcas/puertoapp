
<form class="settings-form">
  @if(Session::get('nomb')!=null)
  <input class="form-control" wire:model='id_empleadod' hidden>
  @endif
<div class="col-auto">

    <label class="form-check-label">Iggs laboral</label>
    <input type="number" class="form-control" wire:model='iggs_laboral'>
    @error('iggs_laboral') 
    <div class="alert alert-danger d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
      
        <span>Pendiente de ingreso</span>
       </div> @enderror
</div>

<div class="col-auto">
    <label class="form-check-label">ISR</label>
    <input type="number" class="form-control" wire:model='isr'>
    @error('isr')    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>Pendiente de ingreso</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div> @enderror
</div>
<div class="col-auto">
  <label class="form-check-label">Descuentos Judiciales</label>
  <input type="number" class="form-control" wire:model='descuentos_judiciales'>
  @error('descuentos_judiciales')    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <span>Pendiente de ingreso</span>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> @enderror
</div>
</form>