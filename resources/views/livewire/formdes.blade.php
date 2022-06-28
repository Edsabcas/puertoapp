
<form class="settings-form">
    <div class="col-auto">
    <label class="form-check-label">No. de Empleado</label>
    @if(Session::get('nomb')!=null)
    <input class="form-control" wire:model='id_empleado' hidden>
    <input type="text"class="form-control" value="{{Session::get('nomb')}}" disabled>
    @else
    <select class="form-select w-auto" wire:model='id_empleado'>     
     @if($empleados!=null)
     <option selected>Seleccione:</option>
     @foreach($empleados as $empleado)
     <option value="{{$empleado->id}}">{{$empleado->Primer_Nombre}} {{$empleado->Primer_Apellido}}</option>
     @endforeach
     @endif
      @endif

  </select>
    @error('id_empleado') 
           <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>Pendiente de ingreso</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @enderror
</div>
<div class="col-auto">
    <label class="form-check-label">Descripcion descuento:</label>
    <textarea class="form-control" name="textarea" rows="5" cols="25" wire:model='descripcion'>Descripcion:</textarea>
    @error('descripcion') 
       <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>Pendiente de ingreso</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div> @enderror
</div>

<div class="col-auto">
    <label class="form-check-label">Monto: </label>
    <input type="number" class="form-control" wire:model='monto'>
    @error('monto')    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span>Pendiente de ingreso</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div> @enderror
</div>
<div class="col-auto">
    <label class="form-check-label">Mes de Descuento: </label>
    <select class="form-select w-auto" wire:model='id_mes_descuento'>
        @if(Session::get('mesdes')!=null)
        <option selected wire:model='id_mes_descuento'>{{Session::get('mesdes')}}</option>
        @else
        @if($meses!=null)
        <option selected >Seleccione:</option>
        @foreach($meses as $mes)
        @if($mes->id>=$mesactual)
        <option value="{{$mes->id}}">{{$mes->descripcion}}</option>
        @endif
        @endforeach
        @endif
        @endif
    </select>
    @error('id_mes_descuento') 
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
 <span>Pendiente de ingreso</span>
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@enderror
</div>
<div class="col-auto">
</div>
</form>