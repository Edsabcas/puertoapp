
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
						                <h4 class="app-card-title">Editar Percepciones</h4>
										@else
										<h4 class="app-card-title">Agregar Percepciones</h4>
										@endif
							        </div><!--//col-->
							        <div class="col-auto">
								        <div class="card-header-action">
									        
								        </div><!--//card-header-actions-->
							        </div><!--//col-->
						        </div><!--//row-->
					        </div><!--//app-card-header-->
					        <div class="app-card-body p-6 p-lg-4">
                                
                                    @include('livewire.'.$viewper)
									
					        </div><!--//app-card-body-->
				        </div><!--//app-card-->

						
			        </div><!--//col-->
			        <div class="col-12 col-lg-5">
				        <div class="app-card app-card-chart h-100 shadow-sm">
					        <div class="app-card-header p-3">
						        <div class="row justify-content-between align-items-center">
							        <div class="col-auto">
										@if($a2!=null)
						                <h4 class="app-card-title">Editar Deducciones</h4>
										@else
										<h4 class="app-card-title">Agregar Deducciones</h4>
										@endif
						                
							        </div><!--//col-->

						        </div><!--//row-->
					        </div><!--//app-card-header-->
					        <div class="app-card-body p-6 p-lg-4">
                                          @include('livewire.'.$viewdedu)
			        </div><!--//col-->
			        
			    </div><!--//row-->
      
			</div>
			@if($a2!=null)
			<div class="col-12 col-lg-8">
				<div class="app-card app-card-chart h-100 shadow-sm">
					<div class="app-card-header p-3">
						<div class="col-auto">
							@if($id_dia_falta!=null)
							{{session(['nuevo2' => '1']);}}
							<h4 class="app-card-title"> Editar dias faltantes</h4>
							@else
						{{session(['nuevo' => '1']);}}
							<h4 class="app-card-title"> Agregar dias faltantes</h4>
							@endif

						</div><!--//row-->
					</div><!--//app-card-header-->
					<div class="app-card-body p-6 p-lg-4">
							  <div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" wire:click='activediasfal()' name="inlineRadioOptions" id="inlineRadio1" value="option1">
								<label class="form-check-label" for="inlineRadio1">Si</label>
							  </div>
							  <div class="form-check form-check-inline">
								<input class="form-check-input" type="radio"  wire:click='desactdiasfal()'name="inlineRadioOptions" id="inlineRadio2" value="option2">
								<label class="form-check-label" for="inlineRadio2">No</label>
							  </div>
					
			</div><!--//col-->
			</div><!--//row-->
			</div>
	@endif
			   
			   @if(Session::get('a5')!=null)
				<div class="col-12 col-lg-8">
					<div class="app-card app-card-chart h-100 shadow-sm">
						<div class="app-card-header p-3">
							<div class="">
								<div class="col-auto">
									@if($id_dia_falta!=null)
									<h4 class="app-card-title">Editar Dias faltantes</h4>
									@else
									<h4 class="app-card-title">Agregar Dias Faltantes</h4>
									@endif
									
								</div><!--//col-->
				
							</div><!--//row-->
						</div><!--//app-card-header-->
						<div class="app-card-body p-6 p-lg-4">
									  @include('livewire.'.$viewdiasfal)
				</div><!--//col-->
				</div><!--//row-->
				</div>
		@endif
		<div class="text-center">
			@if(Session::get('a3')!=null)
		<button class="btn app-btn-primary" wire:click="updatepd2()">Editar Acciones</button>
		@else
		@if($a!=null)
		<button class="btn app-btn-primary" wire:click="updatepd()">Editar Acciones</button>
		
												@else

							<button class="btn app-btn-primary" wire:click="save">Guardar Acciones</button>
												@endif
		@endif

</div>
			<div class="inner">
		   @if(Session::get('var')!=null)
		 {{session()->forget('var');}}
		   <div class="alert alert-success d-flex align-items-center" role="alert">
			 <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
			 <div>
			   Asignado Correctamente.
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
		   </div>
<div class="col-12 col-lg-10">
	<div class="app-card app-card-chart h-100 shadow-sm">
	<div class="app-card-header p-3">
	<div class="row justify-content-between align-items-center">
	<div class="col-auto">
		<h4 class="app-card-title text-center">Registro Asignaciones</h4>
	</div><!--//col-->
	
	</div><!--//row-->
	</div><!--//app-card-header-->
	<div class="app-card-body p-3 p-lg-9">
	<div class="chart-container">
	<div class="app-card app-card-orders-table shadow-sm mb-5">
	 
		<div class="table-responsive">
			<table id="table_id" class="table app-table-hover mb-0 text-left">
		<thead>
		  <tr>
			<th class="cell">NoEmpleado</th>
			<th class="cell">Empleado</th>
			<th class="cell">Accion</th>
		  </tr>
		</thead>
		<tbody>
			@foreach ($asignaciones as $asignacion)
				<tr>
					<td class="cell">{{ $asignacion->NoEmpleado }}</td>
					<td class="cell">{{ $asignacion->Primer_Nombre }} {{ $asignacion->Primer_Apellido }}</td>
					<td class="cell">
						<button type="button" class="btn btn-success" wire:click='edit("{{ $asignacion->id}}","{{$asignacion->Primer_Nombre }} {{$asignacion->Primer_Apellido }}")'>Editar</button>
					</td>
					<td class="cell">
						<button type="button" class="btn btn-danger" wire:click='eliminarasig({{ $asignacion->id}})'>Borrar</button>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	</div>
	  
	
	</div><!--//app-card-body-->
	</div><!--//app-card-->
	</div><!--//col-->
	
	</div><!--//row-->
	
	</div>

	<div class="col-12 col-lg-10">
		<div class="app-card app-card-chart h-100 shadow-sm">
		<div class="app-card-header p-3">
		<div class="row justify-content-between align-items-center">
		<div class="col-auto">
			<h4 class="app-card-title text-center">Bitacora del Mes (Aplican a Descuento por dias no laborados).</h4>
		</div><!--//col-->
		
		</div><!--//row-->
		</div><!--//app-card-header-->
		<div class="app-card-body p-3 p-lg-9">
		<div class="chart-container">
		<div class="app-card app-card-orders-table shadow-sm mb-5">
		 
			<div class="table-responsive">
				<table id="table_id" class="table app-table-hover mb-0 text-left">
			<thead>
			  <tr>
				<th class="cell">NoEmpleado</th>
				<th class="cell">Empleado</th>
				<th class="cell">Dias No Laborados</th>
				<th class="cell">Monto Descuento</th>

				<th class="cell">Accion</th>
			  </tr>
			</thead>
			<tbody>
				@foreach ($tb_dias_fal as $tb_dias_fa)
					<tr>
						@foreach ($perce as $per)
						@foreach ($asignaciones as $asignacion)
						@if($tb_dias_fa->id_percepcion==$per->id_per && $asignacion->id==$per->id_empleado)
						<td class="cell">{{ $asignacion->NoEmpleado }}</td>
						<td class="cell">{{ $asignacion->Primer_Nombre }} {{ $asignacion->Primer_Apellido }}</td>
						@endif
						@endforeach
						@endforeach
						<td class="cell text-center">{{ $tb_dias_fa->dias_faltantes }}</td>
						<td class="cell text-center">Q. {{ $tb_dias_fa->monto_descuento }}.00</td>
						<td class="cell">
							<button type="button" class="btn btn-danger" wire:click='eliminardias({{ $tb_dias_fa->id_dia_falta}})'>Borrar</button>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		</div>
		  
		
		</div><!--//app-card-body-->
		</div><!--//app-card-->
		</div><!--//col-->
		
		</div><!--//row-->
		
		</div>
</div>
