
<div class="container">
    <section>
      <button type="button" wire:click="nuevo()" class="btn btn-lg bg-gradient-primary btn-lg w-18 mt-4 mb-0">Nuevo</button>
   
      <div class="card-header">
        @if($a!=null)
        <h4 class="font-weight-bolder">Editar Platillo</h4>
        @else
        <h4 class="font-weight-bolder">Registrar Platillo</h4>
        @endif
      </div>
      <div class="card-body">
        @if($a!=null)
        <form wire:submit.prevent="updatePlatillo()" class="form-floating">
        @else
        <form wire:submit.prevent="guardarplatillo()" class="form-floating">
        @endif
        
          <div class="row g-2">
            <div class="col-md">
             
          <label class="form-label">Nombre:</label>
          <div class="input-group input-group-outline mb-3">
            <input type="text" class="form-control" wire:model="TITULO_PLATILLO" required>
          </div>
        @error('TITULO_PLATILLO') 
        <div class="alert alert-danger d-flex align-items-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <span>Pendiente de ingreso</span>
           </div> @enderror
      </div>
    
             <div class="col-md">
             <label class="form-label">Descripcion:</label>
          <div class="input-group input-group-outline mb-3">
              <input type="text" class="form-control" wire:model="DESCRIPCION_PLATILLO">
            </div>
         
          @error('DESCRIPCION_PLATILLO') 
            <div class="alert alert-danger d-flex align-items-center" role="alert">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
              
                <span>Pendiente de ingreso</span>
               </div> @enderror

        </div>
        <div class="col-md">
            <label class="form-label">Foto:</label>
         <div class="input-group input-group-outline mb-3">
          
           <input type="file" class="form-control" wire:model="FOTO_PLATILLO">
         </div>
         @error('FOTO_PLATILLO') 
         <div class="alert alert-danger d-flex align-items-center" role="alert">
           <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
           
             <span>Pendiente de ingreso</span>
            </div> @enderror
           </div>
              </div>
    
              <div class="row g-2">
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
              <div class="col-md">
                <label class="form-label">Categoria:</label>
                <div class="input-group input-group-outline mb-3">
                    <select name="" id="" class="form-control" wire:model="ID_CATEGORIA">
                      <option select></option>
                    @foreach ($categorias as $categoria)
                      <option value="{{$categoria->ID_CATEGORIA}}">{{$categoria->TITULO}}</option>
                      @endforeach
                    </select>
                  </div>
                  @error('ID_CATEGORIA') 
                  <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                    
                      <span>Pendiente de ingreso</span>
                     </div> @enderror
                    </div>
                    <div class="col-md">
                      <label class="form-label">Precio:</label>
                   <div class="input-group input-group-outline mb-3">
                       <input type="number" class="form-control" step="any" wire:model="COSTO_PLATILLO">
                     </div>
                  
                   @error('COSTO_PLATILLO') 
                     <div class="alert alert-danger d-flex align-items-center" role="alert">
                       <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                       
                         <span>Pendiente de ingreso </span>
                        </div> @enderror
         
                 </div>
            </div>
            <div class="row g-2">
              @if($FOTO_PLATILLO!=null && $a!=null && $FOTO_PLATILLO==$FOTO_PLATILLO1)
              <div class="col-md">
                <label class="form-label">Imagen Platillo:</label>

                <div class="input-group input-group-outline mb-3">
                <img src="public/imagen/platillos/{{$FOTO_PLATILLO}}" width="200" height="175">
              </div>
              @endif
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
      @if(Session::get('delete1')!=null)
      {{session()->forget('delete1');}}
      <div class="alert alert-success d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
      <div>
      Eliminado Correctamente.
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
    <div>
      <div class="row g-2">
        <div class="col-md">
         
      <label class="form-label">Buscar x Platillo:</label>
      <div class="input-group input-group-outline mb-2">
        <input type="text" class="form-control" wire:model="platillobus" required>
      </div>
  
    @error('platillobus') 
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
    <div class="table-responsive">

      <h4 class="font-weight-bolder">Registros Platillos</h4>

      <table  id="example" class="table table-striped" style="width:100%">

        <thead>
        <tr>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Titulo Platillo</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Precio</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Accion</th>
        </tr>
      </thead>
      <tbody>
        
          @foreach ($platillos as $platillo)
          <tr>
          <td class="align-middle text-sm">
            <span class="text-xs font-weight-bold"> {{$platillo->TITULO_PLATILLO}} </span>
          </td>
          <td class="align-middle text-sm">
            <span class="text-xs font-weight-bold">  Q. {{$platillo->COSTO_PLATILLO}}.00 </span>
          </td>
          @include('platillo.eliminar')
          <td class="align-middle">
            
            <a  class="material-icons text-sm me-2"><button type="button" class="btn btn-link text-dark px-3 mb-0"  data-bs-toggle="modal" data-bs-target="#delete{{$platillo->ID_PLATILLO}}"title="delete">
              <i class="material-icons text-sm me-2">
              delete</i>Eliminar
            
            </button>
          </a>
            <a class="btn btn-link text-dark px-3 mb-0" wire:click="edit({{$platillo->ID_PLATILLO}})"><i class="material-icons text-sm me-2">edit</i>Editar</a>
          </td>
        </tr>
          @endforeach
  
      </tbody>
    </table> 
  </div>
  </div>