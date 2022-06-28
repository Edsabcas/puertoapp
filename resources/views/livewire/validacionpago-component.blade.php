
			    <div class="row g-4 mb-4">
					<div class="app-card-header p-2">
						<div class="text-center">
							<div class="col-auto">
								@if(Session::get('nomb')!=null)
								<input class="form-control" wire:model='id_empleadop' hidden>
								 <h4 >Editar a:  {{Session::get('nomb');}}</h4>
								@endif
							</div><!--//col-->
							</div><!--//col-->
						</div><!--//row-->
			        <div class="col-12 col-lg-5">
				        <div class="app-card app-card-chart h-100 shadow-sm">
					        <div class="app-card-header p-3">
						        <div class="row justify-content-between align-items-center">
							        <div class="col-auto">
										@if($a!=null)
						                <h4 class="app-card-title">Editar Rango de Fecha</h4>
										@else
										<h4 class="app-card-title">Periodo Laborado</h4>
										@endif
							        </div><!--//col-->
							        <div class="col-auto">
								        <div class="card-header-action">
									        
								        </div><!--//card-header-actions-->
							        </div><!--//col-->
						        </div><!--//row-->
					        </div><!--//app-card-header-->
					        <div class="app-card-body p-6 p-lg-4">
                                
                                    @include('livewire.'.$viewrangofecha)
									
					        </div><!--//app-card-body-->
				        </div><!--//app-card-->

						
			        </div><!--//col-->
			@if($mostrar1!=null)
			<div class="col-12 col-lg-8">
				<div class="app-card app-card-chart h-100 shadow-sm">
					<div class="app-card-header p-3">
						<div class="col-auto">
							<h4 class="app-card-title">Seleccionar Empleado</h4>
						</div><!--//row-->
					</div><!--//app-card-header-->
					<div class="app-card-body p-6 p-lg-4">
                        <select class="form-select w-auto" wire:model='id_empleado' wire:click='mostrarboton2()'>
                          @if($empleados!=null)
                          <option selected>Seleccione:</option>
                          @foreach($empleados as $empleado)
                          @if($empleado->Estado=='1')
                          <option  value="{{$empleado->id}}">{{$empleado->Primer_Nombre}} {{$empleado->Primer_Apellido}}</option>
                          @endif
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
			</div><!--//row-->
	@endif
    @if($id_per!=null)
    @include('livewire.boleta')
    <div class="col-12 col-lg-5">
      <div class="app-card app-card-chart h-100 shadow-sm">
        <div class="app-card-header p-3">
          <div class="row justify-content-between align-items-center">
            <div class="col-auto">
            </div><!--//col-->
            <div class="col-auto">
              <div class="card-header-action">
                
              </div><!--//card-header-actions-->
            </div><!--//col-->
          </div><!--//row-->
        </div><!--//app-card-header-->
        <div class="app-card-body p-6 p-lg-4">
         
            
              @if($ruta_cheque!=null)
           
              <form wire:submit.prevent="editartb_validacion_boleta()" class="form-floating">
                <div class="mb-3 row">
                  <label for="inputGroupFile01">Editar Captura Cheque/Transferencia</label>
              <input type="file" class="form-control"  wire:model="photo" accept="image/*" >
            </div>
              @error('photo') 
              <div class="alert alert-danger" role="alert">
              Pendiente de cargar captura
              </div>
              @enderror
              <hr>
              <button class="btn app-btn-primary" type="submit">Editar Boleta</button>
            </form>
              @else
              <form wire:submit.prevent="creartb_validacion_boleta()" class="form-floating">
                <div class="mb-3 row">
                <label for="inputGroupFile01">Cargar Captura Cheque/Transferencia</label>
                <input type="file" class="form-control"  wire:model="photo" accept="image/*" >
              </div>
                @error('photo') 
                <div class="alert alert-danger" role="alert">
                Pendiente de cargar captura
                </div>
                @enderror
                  <hr>
                <button class="btn app-btn-primary" type="submit">Guardar Boleta</button>
              </form>
           
              @endif          
        
       
 
     
        </div><!--//app-card-body-->
      </div><!--//app-card-->

  
    </div><!--//col-->

        @endif
        
    <div class="text-center">
    @if($a!=null)
    <button class="btn app-btn-primary" wire:click="updatepd()">Editar Acciones</button>
    
                                            @else
                                            @if($a0!=null)
                        <button class="btn app-btn-primary" wire:click="cargaEmpleados()">Seleccionar Rango</button>
                                            @endif
                                            @endif
   

    @if(Session::get('mostrar2')!=null)
    <button class="btn app-btn-primary" wire:click="cargardeper()">Seleccionar empleado</button>

    @endif
</div>
        <div class="inner">
       @if(Session::get('var')!=null)
     {{session()->forget('var');}}
       <div class="alert alert-success d-flex align-items-center" role="alert">
         <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
         <div>
          Validacion ingresada Correctamente.
         </div>
       </div>
       @endif
       @if(Session::get('edit')!=null)
       {{session()->forget('edit');}}
         <div class="alert alert-success d-flex align-items-center" role="alert">
           <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
           <div>
             Editado Correctamente.
           </div>
         </div>
         @endif
         @if(Session::get('error')!=null)
         {{session()->forget('error');}}
           <div class="alert alert-warning d-flex align-items-center" role="alert">
             <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
             <div>
               No fue posible editar.
             </div>
           </div>
           @endif
           @if(Session::get('error0')!=null)
           {{session()->forget('error');}}
             <div class="alert alert-warning d-flex align-items-center" role="alert">
               <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
               <div>
              Ya existe un registro con estos datos
               </div>
             </div>
             @endif
       </div>
           
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
		
 
</div>
