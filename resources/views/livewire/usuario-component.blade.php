
<div class="container">
  <section>
    <button type="button" wire:click="nuevo()" class="btn btn-lg bg-gradient-primary btn-lg w-18 mt-4 mb-0">Nuevo</button>
   
    <div class="card-header">
      @if($view!=null)
      <h4 class="font-weight-bolder">Editar Empleados</h4>
      @else
      <h4 class="font-weight-bolder">Registrar Empleados</h4>
      @endif
    </div>
    <div class="card-body">
      <form role="form">
        <div class="row g-2">
          <div class="col-md">
           
        <label class="form-label">Nombres:</label>
        <div class="input-group input-group-outline mb-3">
          <input type="text" class="form-control" wire:model="NOMBRES" required>
        </div>
    
      @error('NOMBRES') 
      <div class="alert alert-danger d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
          <span>Pendiente de ingreso</span>
         </div> @enderror
    </div>
  
           <div class="col-md">
           <label class="form-label">Apellidos:</label>
        <div class="input-group input-group-outline mb-3">
            <input type="text" class="form-control" wire:model="APELLIDOS">
          </div>
       
        @error('APELLIDOS') 
          <div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            
              <span>Pendiente de ingreso</span>
             </div> @enderror
      </div>
            </div>
  
            <div class="row g-2">
              <div class="col-md">
             <label class="form-label">DPI:</label>
          <div class="input-group input-group-outline mb-3">
           
            <input type="number" class="form-control" wire:model="DPI">
          </div>
          @error('DPI') 
          <div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            
              <span>Pendiente de ingreso</span>
             </div> @enderror
            </div>
            <div class="col-md">
          <label class="form-label">Fecha De Nacimiento:</label>
          <div class="input-group input-group-outline mb-3">
            <input type="date" class="form-control" wire:model="FECHA_NACIMIENTO">
          </div>
          @error('FECHA_NACIMIENTO') 
          <div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            
              <span>Pendiente de ingreso</span>
             </div> @enderror
            </div>
            <div class="col-md">
             <label class="form-label">Edad Actual:</label>
          <div class="input-group input-group-outline mb-3">
          
            <input type="number" class="form-control" min="0" max="99"  wire:model="EDAD_ACTUAL">
          </div>
          @error('EDAD_ACTUAL') 
          <div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            
              <span>Pendiente de ingreso</span>
             </div> @enderror
            </div>
  
            <div class="row g-2">
              <div class="col-md">
             <label class="form-label">Usuario Acceso:</label>
        <div class="input-group input-group-outline mb-3">
          @if(Session::get('usuario1')!=null)
          <input type="text" class="form-control" wire:model="usurioacc" disabled>
           @else
           <input type="text" class="form-control" wire:model="usurioacc">
           @endif
          
        </div>
        @error('usurioacc') 
        <div class="alert alert-danger d-flex align-items-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
          
            <span>Pendiente de ingreso</span>
           </div> @enderror
          </div>
          <div class="col-md">
           <label class="form-label">Contraseña Temporal:</label>
           <div class="input-group input-group-outline mb-3">
           @if(Session::get('usuario1')!=null)
           <input type="password" class="form-control" wire:model="password" disabled>
           @else
           <input type="password" class="form-control" wire:model="password">
           @endif                   
            
           </div>
           @error('password') 
           <div class="alert alert-danger d-flex align-items-center" role="alert">
             <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
             
               <span>Pendiente de ingreso</span>
              </div> @enderror
            </div>
            <div class="col-md">
        <label class="form-label">Rol del empleado:</label>
        <div class="input-group input-group-outline mb-3">
          @if(Session::get('usuario1')!=null)
          <input type="text"class="form-control" value="{{Session::get('usuario1')}}" disabled>
          @else
          <select name="" id="" class="form-control" wire:model="rol">
            <option select></option>
            @foreach($roles as $rol)
            <option value="{{$rol->id}}">{{$rol->descripcion}}</option>
            @endforeach
          </select>
          @endif
          </div>
          @error('rol') 
          <div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            
              <span>Pendiente de ingreso</span>
             </div>
             @enderror
            </div>
            <div class="col-md">
        <div class="text-center">
          @if(Session::get('usuario1')!=null)
          <button type="button" wire:click="actualizaremp()" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Editar</button>
          @else
          <button type="button" wire:click="createUsuario()" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Registrar</button>
         @endif
        </div>
      </div>
    </div>
      </form>
    </div>
  </div>
  <div class="inner">
    @if(Session::get('passup')!=null)
    {{session()->forget('passup');}}
    <div class="alert alert-success d-flex align-items-center" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
    <div>
    Contraseña Editada Correctamente.
    </div>
    </div>
    @endif

    <div class="inner">
      @if(Session::get('passno')!=null)
      {{session()->forget('passno');}}
      <div class="alert alert-success d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
      <div>
      No fue posible editar la contraseña.
      </div>
      </div>
      @endif
    @if(Session::get('var')!=null)
    {{session()->forget('var');}}
    <div class="alert alert-success d-flex align-items-center" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
    <div>
    Asignado Correctamente.
    </div>
    </div>
    @endif
    @if(Session::get('var2')!=null)
    {{session()->forget('var2');}}
    <div class="alert alert-success d-flex align-items-center" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
    <div>
    Ya existe registrado un DPI, favor validar.
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

    @if(Session::get('delete1')!=null)
    {{session()->forget('delete1');}}
    <div class="alert alert-warning d-flex align-items-center" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
    <div>
      Eliminado Correctamente
    </div>
    </div>
    @endif


    </div>
  </section>

  <div class="card-header">
    <h4 class="font-weight-bolder">Registros Empleados</h4>
  </div>

  <div class="table-responsive">
    <div>
      <div class="row g-2">
        <div class="col-md">
         
      <label class="form-label">Buscar x usuario:</label>
      <div class="input-group input-group-outline mb-2">
        <input type="text" class="form-control" wire:model="usuariobus" required>
      </div>
  
    @error('usuariobus') 
    <div class="alert alert-danger d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
        <span>Ingresar un dato</span>
       </div> @enderror
  </div>
  
         <div class="col-md">
          <button type="button" wire:click="buscar()" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Buscar...</button>
           
    </div>
          </div>
  
    </div>
  <table class="table table-striped" style="width:100%">
    <thead>
      <tr>
        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Usuario</th>
        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ROL</th>
        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Res Contraseña</th>
        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Accion</th>
      </tr>
    </thead>
    <tbody>
      
        @foreach ($empleados as $empleado)
        @foreach ($users as $user)
        @foreach ($rol_users as $rol_user)
        @foreach ($roles as $role)
        @if($user->id==$rol_user->id_user && $user->email==$empleado->email && $rol_user->id_tipo_rol == $role->id)
        <tr>

          <td class="align-middle text-center text-sm">
            <span class="text-xs font-weight-bold"> {{$user->name}} </span>
          </td>
          <td class="align-middle text-center text-sm">
            <span class="text-xs font-weight-bold"> {{$role->descripcion}} </span>
          </td>
          <td class="align-middle text-center text-sm">
            @include('admin.editcontra')
            <span class="text-xs font-weight-bold"> 
              <a href="#" ><button type="button" class="btn p-0"  data-bs-toggle="modal" data-bs-target="#update4User{{$user->id}}"title="Edit"><span class="text-500 fas fa-edit">  </span>
              </button>
              </a>
             </span>
          </td>
          <td class="align-middle text-center text-sm">
            <span class="text-xs font-weight-bold"> 
              @include('capitalhumano.eliminar')
            <a  class="material-icons text-sm me-2"><button type="button" class="btn btn-link text-dark px-3 mb-0"  data-bs-toggle="modal" data-bs-target="#delete{{$user->id}}"title="delete">
              <i class="material-icons text-sm me-2">
              delete</i>Eliminar
            </button>
          </a>
            <a class="btn btn-link text-dark px-3 mb-0"  wire:click="edit({{$empleado->ID_EMPLEADO}})"><i class="material-icons text-sm me-2">edit</i>Editar</a>
          </span>
          </td>
        </tr>
        @endif
        @endforeach
      @endforeach
      @endforeach
        @endforeach

    </tbody>
  </table>
</div>
</div>
