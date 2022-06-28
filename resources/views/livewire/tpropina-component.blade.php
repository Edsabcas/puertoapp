
<div class="container">
    <section>
      <div class="card-header">
        @if($view!=null)
        <h4 class="font-weight-bolder">Editar Propina</h4>
        @else
        <h4 class="font-weight-bolder">Registrar Propina</h4>
        @endif
        
      </div>
      <div class="card-body">
        <form role="form">
          <div class="row g-2">
   
             <div class="col-md">
             <label class="form-label">Rango Inicio:</label>
          <div class="input-group input-group-outline mb-3">
              <input type="number" class="form-control" wire:model="monto_inicial">
            </div>
         
          @error('monto_inicial') 
            <div class="alert alert-danger d-flex align-items-center" role="alert">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
              
                <span>Pendiente de ingreso</span>
               </div> @enderror
        </div>
        <div class="col-md">
          <label class="form-label">Rango Fin:</label>
       <div class="input-group input-group-outline mb-3">
           <input type="number" class="form-control" wire:model="monto_final">
         </div>
      
       @error('monto_final') 
         <div class="alert alert-danger d-flex align-items-center" role="alert">
           <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
             <span>Pendiente de ingreso</span>
            </div> @enderror
     </div>
              </div>
    
              <div class="row g-2">
                <div class="col-md">
               <label class="form-label">Monto Propina:</label>
            <div class="input-group input-group-outline mb-3">
             
              <input type="number" class="form-control" wire:model="monto">
            </div>
            @error('monto') 
            <div class="alert alert-danger d-flex align-items-center" role="alert">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
              
                <span>Pendiente de ingreso</span>
               </div> @enderror
              </div>
              <div class="col-md">
                <label class="form-label">Estado:</label>
                <div class="input-group input-group-outline mb-3">
                  <select class="form-control" wire:model="estado">
                    <option select></option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                  </select>
                  </div>
                  @error('estado') 
                  <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                    
                      <span>Pendiente de ingreso</span>
                     </div>
                     @enderror
                    </div>
                    @if($view!=null)
            <button type="button" wire:click="actualizaremp()" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Editar</button>
            @else
            <button type="button" wire:click="crearpro()" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Registrar..</button>
        
           @endif
       
      </div>
        </form>
      </div>
    <div class="inner">
      @if(Session::get('passup')!=null)
      {{session()->forget('passup');}}
      <div class="alert alert-success d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
      <div>
      Propina Editada Correctamente.
      </div>
      </div>
      @endif
  
        @if(Session::get('passno')!=null)
        {{session()->forget('passno');}}
        <div class="alert alert-success d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
        <div>
        No fue posible editar la propina.
        </div>
        </div>
        @endif
      @if(Session::get('var')!=null)
      {{session()->forget('var');}}
      <div class="alert alert-success d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
      <div>
      Agregada Correctamente.
      </div>
      </div>
      @endif
      @if(Session::get('var2')!=null)
      {{session()->forget('var2');}}
      <div class="alert alert-success d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
      <div>
      Ya existe registrado un rago, favor validar.
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
        Eliminada Correctamente
      </div>
      </div>
      @endif
  
  
      </div>
    </section>
    <div class="table-responsive">
      <h4 class="font-weight-bolder">Registros Propinas</h4>
    <table id="example" class="table table-striped" style="width:100%">
      <thead>
        <tr>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Descripcion</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Rango_Inicio</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Rango_Fiun</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Monto_Propina</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Accion</th>
        </tr>
      </thead>
      <tbody>
        
          @foreach ($propinas as $propina)
          <tr>
  
            <td class="align-middle text-center text-sm">
              <span class="text-xs font-weight-bold"> {{$propina->descripcion}} </span>
            </td>
            <td class="align-middle text-center text-sm">
              <span class="text-xs font-weight-bold">Q. {{$propina->monto_inicial}}.00 </span>
            </td>
            <td class="align-middle text-center text-sm">
              <span class="text-xs font-weight-bold">Q. {{$propina->monto_final}}.00 </span>
            </td>
            <td class="align-middle text-center text-sm">
                <span class="text-xs font-weight-bold">Q. {{$propina->monto}}.00 </span>
              </td>
              @include('propina.eliminar')
            <td class="align-middle text-center text-sm">
              <span class="text-xs font-weight-bold"> 
             
              <a  class="material-icons text-sm me-2"><button type="button" class="btn btn-link text-dark px-3 mb-0"  data-bs-toggle="modal" data-bs-target="#delete{{$propina->id_propina}}"title="delete">
                <i class="material-icons text-sm me-2">
                delete</i>Delete
              </button>
            </a>
              <a class="btn btn-link text-dark px-3 mb-0"  wire:click="edit({{$propina->id_propina}})"><i class="material-icons text-sm me-2">edit</i>Edit</a>
            </span>
            </td>
          </tr>
          @endforeach
  
  
      </tbody>
    </table>
  </div>
  </div>
  