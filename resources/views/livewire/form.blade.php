<div class="col-12 col-lg-10">
    <div class="app-card app-card-stats-table h-100 shadow-sm">
<form class="settings-form">
    <div class="row g-12">
    <div class="col-auto">
    <label class="form-check-label">No. de Empleado</label>
    <input type="text" class="form-control" wire:model='NoEmpleado'>
    @error('NoEmpleado') 
           <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>Pendiente de ingreso</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @enderror
      @if(Session::get('var1')!=null)
      {{session()->forget('var1');}}
        <div class="alert alert-success d-flex align-items-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
          <div>
         Ya existe un empleado con el mismo Numero.
          </div>
        </div>
        @endif
</div>
<div class="col-auto">
    <label class="form-check-label">DPI</label>
    <input type="number" class="form-control" wire:model='DPI'>
    @error('DPI')    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>Pendiente de ingreso</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div> @enderror
      @if(Session::get('var2')!=null)
      {{session()->forget('var2');}}
        <div class="alert alert-success d-flex align-items-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
          <div>
         Ya existe un empleado con el No. de DPI.
          </div>
        </div>
        @endif
</div>

<div class="col-auto">
    <label class="form-check-label">Primer Nombre</label>
    <input type="text" class="form-control" wire:model='Primer_Nombre'>
    @error('Primer_Nombre')    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>Pendiente de ingreso</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div> @enderror
</div>

<div class="col-auto">
    <label class="form-check-label">Segundo Nombre</label>
    <input type="text" class="form-control" wire:model='Segundo_Nombre'>
    @error('Segundo_Nombre')   <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>Pendiente de ingreso</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div> @enderror
</div>
</div>
<div class="row g-8">
<div class="col-auto">
    <label class="form-check-label">Primer Apellido</label>
    <input type="text" class="form-control" wire:model='Primer_Apellido'>
    @error('Primer_Apellido')    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>Pendiente de ingreso</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div> @enderror
</div>
<div class="col-auto">
    <label class="form-check-label">Segundo Apellido</label>
    <input type="text" class="form-control" wire:model='Segundo_Apellido'>
    @error('Segundo_Apellido')    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>Pendiente de ingreso</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div> @enderror
</div>

<div class="col-auto">
    <label class="form-check-label">Puesto</label>
    <select class="form-select w-auto" wire:model='Puesto'>
        <option selected value=""></option>
        <option value="Administrador">Administrador</option>
        <option value="Profesor/a">Profesor/a</option>
        <option value="Mantenimiento">Mantenimiento</option>
  </select>
    @error('Puesto')    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>Pendiente de ingreso</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div> @enderror
</div>
<div class="col-auto">
    <label class="form-check-label">Estado</label>
    <select class="form-select w-auto" wire:model='Estado'>
        <option selected value=""></option>
        <option value="0">Inactivo</option>
        <option value="1">Activo</option>
  </select>
    @error('Estado')    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>Pendiente de ingreso</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div> @enderror
</div>

</div>
<div class="row g-8">
    <div class="col-auto">
    <label class="form-check-label">Fecha_ingreso</label>
    <input  type="date"  class="form-control" wire:model='Fecha_ingreso'>
    @error('Fecha_ingreso')    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>Pendiente de ingreso</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div> @enderror
</div>
<div class="col-auto">
    <label class="form-check-label">Correo</label>
    <input type="email" class="form-control" wire:model='Correo'>
    @error('Correo')    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>Pendiente de ingreso</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div> @enderror
      @if(Session::get('var3')!=null)
      {{session()->forget('var3');}}
        <div class="alert alert-success d-flex align-items-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
          <div>
         Correo invalido.
          </div>
        </div>
        @endif
</div>
</div>
</form>

</div>
</div>
