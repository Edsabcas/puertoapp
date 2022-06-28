<div class="row g-4 mb-4">
<div class="col-12 col-lg-8">
    <div class="app-card app-card-chart h-100 shadow-sm">
        <div class="app-card-header p-3">
            <div class="col-auto">        
                <h4 class="app-card-title"> Que desea realizar: </h4>
          
            </div><!--//row-->
        </div><!--//app-card-header-->
        <div class="app-card-body p-6 p-lg-4">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" wire:click='mostrar1()' name="inlineRadioOptions0" id="inlineRadio1" value="option1">
                    <label class="form-check-label" for="inlineRadio1">Boleta Mensual</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio"  wire:click='mostrar2()'name="inlineRadioOptions0" id="inlineRadio2" value="option2">
                    <label class="form-check-label" for="inlineRadio2">Reporte Anual</label>
                  </div>
        
</div><!--//col-->
</div><!--//row-->

</div>
@if($m1!=null)
<div class="app-card-header p-3">
    <div class="col-auto">        
        <h4 class="app-card-title"> De que forma: </h4>
  
    </div><!--//row-->
</div><!--//row-->
<div class="app-card-body p-6 p-lg-4">
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" wire:click='mostrar0()' name="inlineRadioOptions1" id="v1" value="option1">
      <label class="form-check-label" for="v1">Seleccionar un empleado</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio"  wire:click='mostrar4()'name="inlineRadioOptions1" id="v2" value="option2">
      <label class="form-check-label" for="v2">Todos los empleados</label>
    </div>

</div><!--//col-->
@endif


@if($m2!=null)
<div class="app-card-header p-3">
    <div class="col-auto">        
        <h4 class="app-card-title"> De que forma: </h4>
  
    </div><!--//row-->
</div><!--//row-->
<div class="app-card-body p-6 p-lg-4">
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" wire:click='activediasfal()' name="inlineRadioOptions2" id="b2" value="option1">
      <label class="form-check-label" for="b2">Seleccionar un empleado</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio"  wire:click='desactdiasfal()'name="inlineRadioOptions2" id="b3" value="option2">
      <label class="form-check-label" for="b3">Todos los empleados</label>
    </div>

</div><!--//col-->
@endif

@if($mm0!=null)
<div class="app-card-header p-3">
    <div class="col-auto">        
        <h4 class="app-card-title"> Seleccione un empleado </h4>
    </div><!--//row-->
</div><!--//row-->
<div class="app-card-body p-6 p-lg-4">
  <div class="col-auto input-group mb-3">
        <select class="form-select w-auto" wire:click='mostrar3()' wire:model='id_empleado'>
          @if($empleados!=null)
          <option selected></option>
          @foreach($empleados as $empleado)
          <option value="{{$empleado->id}}">{{$empleado->Primer_Nombre}}  {{$empleado->Primer_Apellido}}</option>
         @endforeach
          @endif
      </select>
        @error('id_empleado') 
               <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span>Pendiente de ingreso</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @enderror
  
    </div>

</div><!--//col-->
@endif

@if($mm1!=null)
<div class="app-card-header p-3">
    <div class="col-auto">        
        <h4 class="app-card-title"> Seleccione Mes y Año </h4>
    </div><!--//row-->
</div><!--//row-->
<div class="app-card-body p-6 p-lg-4">
  <div class="input-group mb-3">

        <span  class="form-check-label">Mes</span >
        <select class="form-select w-auto" wire:model='mselecion'>
          @if($meses!=null)
          <option selected>Seleccione:</option>
          @foreach($meses as $mes)
          <option value="{{$mes->id}}">{{$mes->descripcion}} </option>
         @endforeach
          @endif
      </select>
        @error('mselecion') 
               <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span>Pendiente de ingreso</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @enderror
  

        <span  class="form-check-label">Año: </span >
        <select class="form-select w-auto" wire:model='anioseleccion'>
          <option selected>Seleccione:</option>
          <option value="2021">2021</option>
          <option value="2022">2022</option>
          <option value="2023">2023</option>
          <option value="2024">2024</option>
          <option value="2025">2025</option>
      </select>
        @error('anioseleccion') 
               <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span>Pendiente de ingreso</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @enderror

          <button class="btn app-btn-primary" wire:click="imprimir()">Realizar Consulta</button>
          <a href="{{ route('imprimir') }}">Imprime el archivo</a>
    </div>


</div><!--//col-->
@endif

@if($Norecibo!=null)
@include('livewire.boleta')
@endif
@if($mosboletas!=null)

<div class="col-12 col-lg-10">
	<div class="app-card app-card-chart h-100 shadow-sm">
	<div class="app-card-header p-3">
	<div class="row justify-content-between align-items-center">
	<div class="col-auto">
		<h4 class="app-card-title text-center">Boletas Creadas del Mes en curso</h4>
	</div><!--//col-->
  <div class="table-responsive">
  <table class="table table-bordered border-primary">
    <thead>
      <tr>
        <td class="cell">NoEmpleado</td>
        <td class="cell">Nombre</td>
        <td class="cell">Total A Recibir</td>
        <td class="cell">Enviado</td>
      </tr>
    </thead>
    <tbody>
 
        @foreach ($tb_boleta_creada_mes as $tb_boleta_creada_me)
        @foreach ($empleados as $empleado)
        <tr>
        @if($tb_boleta_creada_me->id_empleado == $empleado->id)
        
        <td class="cell">{{$empleado->NoEmpleado}}</td>
        <td class="cell">{{$empleado->Primer_Nombre}} {{$empleado->Primer_Apellido}}</td>
        <td class="cell">Q. {{$tb_boleta_creada_me->total_a_recibir}}</td>
        @if($tb_boleta_creada_me->estado_impresion ==0)
        <td class="cell">Pendiente de Impresion</td>
        @else
        <td class="cell">Ya enviado e impreso</td>
        @endif
        @endif
      </tr>
        @endforeach

        @endforeach
    
    </tbody>
  </table>
</div><!--//row-->
	</div><!--//row-->
	</div><!--//app-card-header-->
	<div class="app-card-body p-3 p-lg-9">
	<div class="chart-container">
	<div class="app-card app-card-orders-table shadow-sm mb-5">
	 
	</div><!--//app-card-body-->
	</div><!--//app-card-->
	</div><!--//col-->
	
	</div><!--//row-->
	
	</div>


@if($tb_boleta_creada_mes==null)
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <span>No hay registro para la fecha seleccioanda.</span>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@else

@endif
@endif

@if($mm2!=null)
<div class="app-card-header p-3">
    <div class="col-auto">        
        <h4 class="app-card-title"> Seleccione el año: </h4>
  
    </div><!--//row-->
</div><!--//row-->
<div class="app-card-body p-6 p-lg-4">
    <div class="col-auto">
        <label class="form-check-label">Año: </label>
        <select class="form-select w-auto" wire:model='anio_seleccion'>
          <option selected>Seleccione:</option>
          <option value="2021">2021</option>
          <option value="2021">2022</option>
          <option value="2021">2023</option>
          <option value="2021">2024</option>
          <option value="2021">2025</option>
      </select>
        @error('anio_seleccion') 
               <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span>Pendiente de ingreso</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @enderror
    </div>

</div><!--//col-->
@endif
</div>