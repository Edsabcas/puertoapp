<form class="settings-form">
    <div class="col-auto">
  
    @if(Session::get('nomb')!=null)
    <input class="form-control" wire:model='id_empleadop' hidden>
    @else
    <label class="form-check-label">No. de Empleado</label>
    <select class="form-select w-auto" wire:model='id_empleadop'>
      @if($percepciones!=null)
      <option selected>Seleccione:</option>
      @foreach($percepciones as $percepcion)
      @if($percepcion->Estado=='1')
      <option value="{{$percepcion->id}}">{{$percepcion->Primer_Nombre}} {{$percepcion->Primer_Apellido}}</option>
      @endif
     @endforeach
      @endif
      @endif
  </select>
    @error('id_empleadop') 
           <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>Pendiente de ingreso</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @enderror
</div>
<div class="col-auto">
    <label class="form-check-label">Salario Ordinario</label>
    <input type="number" class="form-control" wire:model='salario_ordinario' wire:keydown='igss()'wire:click='igss()'>
    @error('salario_ordinario') 
       <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>Pendiente de ingreso</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div> @enderror
</div>

<div class="col-auto">
    <label class="form-check-label">Bonificacion Incentivo dto. 78-98 y reformas</label>
    <input type="number" class="form-control" wire:model='bonificacion_mensual'  wire:click='igss()'>
    @error('bonificacion_mensual')    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>Pendiente de ingreso</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div> @enderror
</div>

<div class="col-auto">
    <label class="form-check-label">Bonificacion Productividad</label>
    <input type="number" class="form-control" wire:model='bonificacion_productividad'>
    @error('bonificacion_productividad')   <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>Pendiente de ingreso</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div> @enderror
</div>

</form>
