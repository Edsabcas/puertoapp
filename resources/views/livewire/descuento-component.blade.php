
			    <div class="row g-4 mb-4">
			        <div class="col-12 col-lg-5">
				        <div class="app-card app-card-chart h-100 shadow-sm">
					        <div class="app-card-header p-3">
						        <div class="row justify-content-between align-items-center">
							        <div class="col-auto">
										@if($a!=null)
						                <h4 class="app-card-title">Editar Anticipo</h4>
										@else
										<h4 class="app-card-title">Agregar Anticipo</h4>
										@endif
							        </div><!--//col-->
							        <div class="col-auto">
								        <div class="card-header-action">
									        
								        </div><!--//card-header-actions-->
							        </div><!--//col-->
						        </div><!--//row-->
					        </div><!--//app-card-header-->
					        <div class="app-card-body p-6 p-lg-4">
                                
                                    @include('livewire.'.$viewdes)
									
					        </div><!--//app-card-body-->
				        </div><!--//app-card-->
			        </div><!--//col-->
<div class="col-12 col-lg-10">
	<div class="app-card app-card-chart h-100 shadow-sm">
	<div class="app-card-header p-3">
	<div class="row justify-content-between align-items-center">
	<div class="col-auto">
		<h4 class="app-card-title">Registro Anticipos Del mes</h4>
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
			<th class="cell">NoEmpleado </th>
			<th class="cell">Nombre Empleado</th>
			<th class="cell">Mes de Descuento</th>
			<th class="cell">Monto</th>
			<th class="cell">Cobro</th>
			<th class="cell">Accion</th>
		  </tr>
		</thead>
		<tbody>
			@foreach ($descuentos as $descuento)
				
			
						@foreach ($descuentos_activos as $descuentos_activo)
						@if ($descuento->id==$descuentos_activo->id_empleado)
						<tr>
						<td class="cell">{{ $descuento->NoEmpleado }}</td>
						<td class="cell">{{ $descuento->Primer_Nombre }} {{ $descuento->Primer_Apellido }}</td>
						@foreach($meses as $me)
						@if($me->id==$descuentos_activo->id_mes_descuento)
						
						<td class="cell">
							{{$me->descripcion}}
						</td>
						<td class="cell">
							Q. {{$descuentos_activo->monto}}.00
						</td>
							@if($descuentos_activo->cobro_efectuado==0)
							<td class="cell">
								Pendiente de cobro
							</td>
							@else
							<td class="cell">
								Cobro Efectuado
							</td>
							@endif
							<td class="cell">
								<button type="button" class="btn btn-success" wire:click='edit("{{ $descuentos_activo->id_descuento}}","{{ $descuento->Primer_Nombre }} {{ $descuento->Primer_Apellido }}")'>Editar</button>
							</td>
							<td class="cell">
								<button type="button" class="btn btn-danger" wire:click='eliminardes("{{ $descuentos_activo->id_descuento}}","{{ $descuento->id}}")'>Borrar</button>
							</td>
							
				
						@endif
						@endforeach
						

						@endif
					</tr>
					@endforeach

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

<div class="row g-4 mb-4">


</div>