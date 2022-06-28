
<div class="container">
    <section>
      <button type="button" wire:click="nuevo()" class="btn btn-lg bg-gradient-primary btn-lg w-18 mt-4 mb-0">Nuevo</button>
   
      <div class="card-header">
        @if($a!=null)
        <h4 class="font-weight-bolder">Editar Categoria</h4>
        @else
        <h4 class="font-weight-bolder">Registrar Categoria</h4>
        @endif
      </div>
      <div class="card-body">
        @if($a!=null)
        <form wire:submit.prevent="updateCategoria()" class="form-floating">
        @else
        <form wire:submit.prevent="guardarCategoria()" class="form-floating">
        @endif
        
          <div class="row g-2">
            <div class="col-md">
             
          <label class="form-label">Titulo categoria:</label>
          <div class="input-group input-group-outline mb-3">
            <input type="text" class="form-control" wire:model="TITULO" required>
          </div>
        @error('TITULO') 
        <div class="alert alert-danger d-flex align-items-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <span>Pendiente de ingreso</span>
           </div> @enderror
      </div>
    
             <div class="col-md">
             <label class="form-label">Descripcion:</label>
          <div class="input-group input-group-outline mb-3">
              <input type="text" class="form-control" wire:model="DESCRIPCION">
            </div>
         
          @error('DESCRIPCION') 
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

       
        </div>
    
              <div class="row g-2">
              <div class="col-md">
                <label class="form-label">Seleccione el area:</label>
                <div class="input-group input-group-outline mb-3">
                    <select name="" id="" class="form-control" wire:model="ID_AREA">
                      <option select></option>
                      @foreach($areas as $area)
                      <option value="{{$area->ID_AREA}}">{{$area->TITUTO_AREA}}</option>
                      @endforeach
                    </select>
                  </div>
                  @error('ID_AREA') 
                  <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                    
                      <span>Pendiente de ingreso</span>
                     </div> @enderror
                    </div>
                    <div class="col-md">
                      <label class="form-label">Imagen Categoria:</label>
                   <div class="input-group input-group-outline mb-3">
                     <input type="file"  class="form-control" wire:model="FOTO_CATEGORIA" accept="image/*"s>
                   </div>
                   <div id="imagePreview">
          
                   </div>
                   @error('FOTO_CATEGORIA') 
                   <div class="alert alert-danger d-flex align-items-center" role="alert">
                     <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                     
                       <span>Pendiente de ingreso</span>
                      </div> @enderror
                     </div>
                    </div>
              <div class="row g-2">
                @if($FOTO_CATEGORIA!=null && $a!=null && $FOTO_CATEGORIA==$FOTO_CATEGORIA1)
                <div class="col-md">
                  <label class="form-label">Imagen Categoria:</label>

                  <div class="input-group input-group-outline mb-3">
                  <img src="public/imagen/categoria/{{$FOTO_CATEGORIA}}" width="200" height="175">
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
      @if(Session::get('errorllave')!=null)
      {{session()->forget('errorllave');}}
      <div class="alert alert-warning d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
      <div>
     No es posible eliminar debido a que la categoria se encuentra relacionada con algun platillo. 
      </div>
      </div>
      @endif
      </div>
    </section>

    <div class="table-responsive">
      <h4 class="font-weight-bolder">Registros Categorias</h4>
      <div>
        <div class="row g-2">
          <div class="col-md">
           
        <label class="form-label">Buscar categoria:</label>
        <div class="input-group input-group-outline mb-2">
          <input type="text" class="form-control" wire:model="categoriabus" required>
        </div>
    
      @error('categoriabus') 
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
        <tr  class="align-middle text-center text-sm">
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Titulo</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Descipcion</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Accion</th>
        </tr>
      </thead>
      <tbody>
        
          @foreach ($categorias as $categoria)
          <tr>
          <td class="align-middle text-center text-sm">
            <span class="text-xs font-weight-bold"> {{$categoria->TITULO}} </span>
          </td>
          <td class="align-middle text-center text-sm">
            <span class="text-xs font-weight-bold"> {{$categoria->DESCRIPCION}} </span>
          </td>
          <td class="align-middle text-center text-sm">
              @if($categoria->ESTADO==1)
              <span class="text-xs font-weight-bold">Activo</span>
              @else
              <span class="text-xs font-weight-bold">Inactivo</span>
              @endif
            
          </td>
          @include('categoria.eliminar')
          <td class="align-middle text-center text-sm">
            
            <a  class="material-icons text-sm me-2"><button type="button" class="btn btn-link text-dark px-3 mb-0"  data-bs-toggle="modal" data-bs-target="#delete{{$categoria->ID_CATEGORIA}}"title="delete">
              <i class="material-icons text-sm me-2">
              delete</i>Eliminar
            </button>
          </a>
            <a class="btn btn-link text-dark px-3 mb-0" wire:click="edit({{$categoria->ID_CATEGORIA}})">
              <i class="material-icons text-sm me-2">edit</i>Editar</a>
          </td>
        </tr>
          @endforeach
  
      </tbody>
    </table>
  </div>
  </div>
</div>