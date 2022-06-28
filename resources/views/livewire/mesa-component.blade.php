
<div class="container">
    <section>
      <div class="card-header">
        @if($a!=null)
        <h4 class="font-weight-bolder">Editar Mesa</h4>
        @else
        <h4 class="font-weight-bolder">Registrar Mesa</h4>
        @endif
      </div>
      <div class="card-body">
        @if($a!=null)
        <form wire:submit.prevent="actualizazmesa()" class="form-floating">
        @else
        <form wire:submit.prevent="guardarmesa()" class="form-floating">
        @endif
          <div class="row g-2">
            <div class="col-md">
             
          <label class="form-label"># de Mesa:</label>
          <div class="input-group input-group-outline mb-3">
            <input type="text" class="form-control" wire:model="NO_MESA" required>
          </div>
        @error('NO_MESA') 
        <div class="alert alert-danger d-flex align-items-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <span>Pendiente de ingreso</span>
           </div> @enderror
      </div>
    
             <div class="col-md">
             <label class="form-label">Ubicacion mesa:</label>
          <div class="input-group input-group-outline mb-3">
            <select class="form-control" wire:model="UBICACION">
                <option select></option>
                <option value="1er. Nivel">1er. Nivel</option>
                <option value="2do. Nivel">2do. Nivel</option>
              </select>
            </div>
         
          @error('UBICACION') 
            <div class="alert alert-danger d-flex align-items-center" role="alert">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
              
                <span>Pendiente de ingreso</span>
               </div> @enderror

        </div>
        <div class="col-md">
            <label class="form-label">Estado:</label>
            <div class="input-group input-group-outline mb-3">
              <select class="form-control" wire:model="ESTADO">
                <option select></option>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
            </div>
            @error('ESTADO') 
            <div class="alert alert-danger d-flex align-items-center" role="alert">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
              
                <span>Pendiente de ingreso</span>
               </div> @enderror
              </div>
              @if($a!=null)
              <div class="col-md">
                  <div class="text-center">
                    <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Editar</button>
                  </div>
                </div>
                @else
                <div class="col-md">
                  <div class="text-center">
                    <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Registrar</button>
                  </div>
                </div>     
                @endif
              </div>
        </form>
      </div>

    <div class="inner">
      @if(Session::get('var')!=null)
      {{session()->forget('var');}}
      <div class="alert alert-success d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
      <div>
      Agregada Correctamente.
      </div>
      </div>
      @endif
      @if(Session::get('var1')!=null)
      {{session()->forget('var1');}}
      <div class="alert alert-warning d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="warning:"><use xlink:href="#check-circle-fill"/></svg>
      <div>
      Ya existe registrado con el # de mesa, favor validar.
      </div>
      </div>
      @endif
      @if(Session::get('edit')!=null)
      {{session()->forget('edit');}}
      <div class="alert alert-success d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
      <div>
      Editada Correctamente.
      </div>
      </div>
      @endif
      @if(Session::get('delete1')!=null)
      {{session()->forget('delete1');}}
      <div class="alert alert-success d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
      <div>
      Eliminada Correctamente.
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
    </section>
    <div class="card-header">
      <h4 class="font-weight-bolder">Registros Mesas</h4>
    </div>
    <div class="table-responsive">
    <table class="table align-items-center mb-0">
      <thead>
        <tr>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"># de Mesa</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ubicacion</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Accion</th>
        </tr>
      </thead>
      <tbody>
        
          @foreach ($mesas as $mesa)
          <tr>
          <td class="align-middle text-center text-sm">
            <span class="text-xs font-weight-bold"> {{$mesa->NO_MESA}} </span>
          </td>
          <td class="align-middle text-center text-sm">
            <span class="text-xs font-weight-bold"> {{$mesa->UBICACION}} </span>
          </td>
          <td class="align-middle text-center text-sm">
              @if($mesa->ESTADO==1)
              <span class="text-xs font-weight-bold">Activa</span>
              @else
              <span class="text-xs font-weight-bold">Inactiva</span>
              @endif
            
          </td>
          <td class="align-middle">
            @include('mesa.eliminar')
            <a  class="material-icons text-sm me-2"><button type="button" class="btn btn-link text-dark px-3 mb-0"  data-bs-toggle="modal" data-bs-target="#delete{{$mesa->ID_MESA}}"title="delete">
              <i class="material-icons text-sm me-2">
              delete</i>Eliminar
            </button>
          </a>
            <a class="btn btn-link text-dark px-3 mb-0" wire:click="edit({{$mesa->ID_MESA}})"><i class="material-icons text-sm me-2">edit</i>Editar</a>
          </td>
        </tr>
          @endforeach
  
      </tbody>
    </table>
  </div>
    <script>
      Livewire.on('asd',da =>{
        Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success'
      )
    }
  })
      })
    </script>
  
  </div>
</div>