
<div class="app-card app-card-orders-table shadow-sm mb-5">
    <div class="col-16 col-md-14">
        @include('livewire.'.$view)
</div>

    <div class="app-card-body">
        <div class="inner">
            <div class="app-card-body p-3 p-lg-4">
        <h1 class="app-page-title">Registros</h1>
    </div>
</div>
                <div class="table-responsive">
                    <table id="table_id" class="table app-table-hover mb-0 text-left">
                <thead>
                  <tr>
                    <th class="cell">NoEmpleado</th>
                    <th class="cell">Primer Nombre</th>
                    <th class="cell">Primer Apellido</th>
                    <th class="cell">Puesto</th>
                    <th class="cell">Estado</th>
                    <th class="cell">Correo</th>
                    <th class="cell">Accion</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($empleados as $empleado)
                        <tr>
                            <td class="cell">{{ $empleado->NoEmpleado }}</td>
                            <td class="cell">{{ $empleado->Primer_Nombre }}</td>
                            <td class="cell">{{ $empleado->Primer_Apellido }}</td>
                            <td class="cell">{{ $empleado->Puesto }}</td>
                            @if($empleado->Estado==0)
                            {
                                <td class="cell">Inactivo</td>
                            }
                            @else
                            <td class="cell">Activo</td>
                            @endif
                            
                            <td class="cell">{{ $empleado->Correo }}</td>
                            <td class="cell">
                                <button type="button" class="btn btn-success" wire:click='edit({{ $empleado->id }})'>Editar</button>
                            </td>
                            <td class="cell">
                                <a href="/eliminar1/{{$empleado->id}}" class="btn btn-danger delete-confirm">Borrar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> 
</div>
<script>
    $('.delete-confirm').on('click', function (event) {
       event.preventDefault();
       const url = $(this).attr('href');
       swal({
           title: 'Esta seguro que desea eliminar?',
           text: 'Se borraran todos los datos de ese registro!',
           icon: 'warning',
           buttons: ["Cancelar", "Eliminar!"],
       }).then(function(value) {
           if (value) {
               window.location.href = url;
           }
       });
   });
   </script>