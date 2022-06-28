<div class="container">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script>
    $(document).on('click', '#Crear', function() {
  $('#editorden').modal('show');
  });
  
  $(document).on('click', '#val', function() {
  $('#valpedidos').modal('show');
  });
  </script>
    <div class="card-header">
      @include('pedido.eliminar')
        <h4 class="font-weight-bolder text-center">
        
          @if($noMesa !=null or $tipo_pedido!=null)

          @if($noMesa !=null)
          PEDIDO EXTRA | Mesa
          <p>No. {{$noMesa}}</p>
          
          @endif

          @if($tipo_pedido==2)
          PEDIDO EXTRA | Pedido a Domicilio
          <p>Cliente: {{$nom_cliente}}</p>
          <p>Direccion: {{$dire}}</p>
          <p>Telefono: {{$telef}}</p>
          @endif
          
          @if($tipo_pedido==3)
          PEDIDO EXTRA | Pedido para llevar
          <p>Cliente: {{$nom_cliente}}</p>
          @endif

          @if($tipo_pedido==4)
          PEDIDO EXTRA | Pedido interno 
          <p>Colaborador: {{$nom_cliente}}</p>
          @endif

         @if($valpedido!=null)
         <a class="btn btn-link text-sdark px-3 mb-0" >
            <button type="button" id="Crear" class="btn btn-success" wire:click="verOrden()" >
              <i class="fas fa-list-ol"> &nbsp; Ver Detalle</i>
            </button>
          </a>
          @include('pedido.editpedido')
          @include('pedido.modalvalpedido')
          @endif

          @else
          Generar Pedido Extra
          @endif
          
          @if($notem!=null)
          <a class="btn btn-link text-sdark px-3 mb-0" >
            <button type="button" class="btn btn-danger"  data-bs-toggle="modal" data-bs-target="#delete"title="delete">
                <i class="bi bi-trash3"> &nbsp; Cancelar Pedido</i>
              </button>
            </a>
          @endif
        </h4>
          
        @if(Session::get('var')!=null)
        {{session()->forget('var');}}
        <div class="alert alert-success" role="alert">
            Agregado Correctamente.
          </div>
        @endif

        @if(Session::get('creado')!=null)
        {{session()->forget('creado');}}
        <div class="alert alert-success" role="alert">
            Agregado Correctamente.
          </div>
        @endif

        @if(Session::get('edit')!=null)
        {{session()->forget('edit');}}
        <div class="alert alert-warning" role="alert">
            Editado Correctamente.
          </div>
        @endif

        @if(Session::get('error')!=null)
        {{session()->forget('error');}}
        <div class="alert alert-danger" role="alert">
            No fue posible editar.
        </div>
        @endif 
        @if(Session::get('delete1')!=null)
        <div class="alert alert-light" role="alert">
          Se cancelo el pedido Correctamente.
        </div>
        {{session()->forget('delete1');}}
        @endif
    </div>

    <div class="accordion accordion-flush" id="accordionFlushExample">
      <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOn">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOn" aria-expanded="false" aria-controls="flush-collapseOn">
            <h4 class="font-weight-bolder text-center">Seleccionar tipo de pedido</h4>
          </button>
        </h2>
        <div id="flush-collapseOn" class="accordion-collapse collapse" aria-labelledby="flush-headingOn" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            <div class="row">
              <div class="input-group input-group-outline mb-3">
                <div class="form-check">
                  <input class="form-check-input" wire:click="tipo_pedido(1)"  type="radio" name="flexRadioDefaults" id="flexRadioDefaults1">
                  <label class="form-check-label" for="flexRadioDefaults1">
                   En Mesa
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" wire:click="tipo_pedido(2)"  type="radio" name="flexRadioDefaults" id="flexRadioDefaultss2" >
                  <label class="form-check-label" for="flexRadioDefaultss2">
                    A Domicilio
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" wire:click="tipo_pedido(3)"  type="radio" name="flexRadioDefaults" id="flexRadioDefaults3" >
                  <label class="form-check-label" for="flexRadioDefaults3">
                   Para Llevar
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" wire:click="tipo_pedido(4)"  type="radio" name="flexRadioDefaults" id="flexRadioDefaults4" >
                  <label class="form-check-label" for="flexRadioDefaults4">
                   Mi pedido
                  </label>
                </div>
                  </div>
              </div>
              </div>
        </div>
      </div>

      @if($op==1)
      <div class="accordion-item">

        <h2 class="accordion-header" id="flush-headingOne1">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne1" aria-expanded="false" aria-controls="flush-collapseOne1">
                Seleccionar Mesa:
          </button>
        </h2>
        <div id="flush-collapseOne1" class="accordion-collapse" aria-labelledby="flush-headingOne1" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
              <div class="row">
                  @foreach($pedidos as $pedido)
                  @foreach($mesas as $mesa)
                  @if($pedido->tipo_pedido==0 &&($mesa->ID_MESA == $pedido->ID_MESA))
                  @if($pedido->extra == 0 or $pedido->extra == 1)
                  <div class="list-group">
                  <a class="btn btn-link text-dark px-3 mb-0">
                      <button type="button" class="btn btn-link text-dark px-3 mb-0" wire:click="busquedacuenta2('{{$pedido->ID_PEDIDO}}')">
                          Mesa #: <b> {{$mesa->NO_MESA}}</b> 
                      </button>
                    </a>
              </div>
      
              @endif
                @endif
                @endforeach
                @endforeach
                </div>
                </div>
      
        </div>
      </div>
      @elseif($op==2)
      <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne2">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne2" aria-expanded="false" aria-controls="flush-collapseOne2">
               Pedidos A Domicilio
          </button>
        </h2>
        <div id="flush-collapseOne2" class="accordion-collapse collapse" aria-labelledby="flush-headingOne2" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
              <div class="row">
                  @foreach($pedidos as $pedido)
                  @if($pedido->tipo_pedido==2 && ($pedido->cancelado==0 or $pedido->cancelado==1 or $pedido->cancelado==2))
                  <div class="list-group">
                  <a class="btn btn-link text-dark px-3 mb-0">
                      <button type="button" class="btn btn-link text-dark px-3 mb-0" wire:click="busquedacuenta2('{{$pedido->ID_PEDIDO}}')">
                          Cliente: <b> {{$pedido->nombre_cliente}}</b> 
                      </button>
                    </a>
              </div>
                @endif
                @endforeach
                </div>
                </div>
      
        </div>
      </div>
      
      
      @elseif($op==3)
      <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne3">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne3" aria-expanded="false" aria-controls="flush-collapseOne3">
               Pedidos para llevar:
          </button>
        </h2>
        <div id="flush-collapseOne3" class="accordion-collapse collapse" aria-labelledby="flush-headingOne3" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
              <div class="row">
                  @foreach($pedidos as $pedido)
                  @if($pedido->tipo_pedido==3 && ($pedido->cancelado==0 or $pedido->cancelado==1 or $pedido->cancelado==2))
                  <div class="list-group">
                  <a class="btn btn-link text-dark px-3 mb-0">
                      <button type="button" class="btn btn-link text-dark px-3 mb-0" wire:click="busquedacuenta2('{{$pedido->ID_PEDIDO}}')">
                          Cliente: <b> {{$pedido->nombre_cliente}}</b> 
                      </button>
                    </a>
              </div>
                @endif
                @endforeach
                </div>
                </div>
      
        </div>
      </div>
      
      @elseif($op==4)
      <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOneaaa">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOneaaa" aria-expanded="false" aria-controls="flush-collapseOneaaa">
              Pedidos  del personal:
          </button>
        </h2>
        <div id="flush-collapseOneaaa" class="accordion-collapse collapse" aria-labelledby="flush-headingOneaaa" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
              <div class="row">
                  @foreach($pedidos as $pedido)
                  @if($pedido->tipo_pedido==4 && ($pedido->cancelado==0 or $pedido->cancelado==1 or $pedido->cancelado==2))
                  <div class="list-group">
                  <a class="btn btn-link text-dark px-3 mb-0">
                      <button type="button" class="btn btn-link text-dark px-3 mb-0" wire:click="busquedacuenta2('{{$pedido->ID_PEDIDO}}')">
                          Empleado: <b> {{$pedido->nombre_cliente}}</b> 
                      </button>
                    </a>
              </div>
                @endif
                @endforeach
                </div>
                </div>
      
        </div>
      </div>
      @endif


            @if($noMesa!=null or $tipo_pedido!=null)
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
              <h4 class="font-weight-bolder">Categoria </h4>
            </button>
          </h2>
          <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
                <div class="row">
                    <table class="table table-hover">
                      <thead>
                        <th scope="row">Categoria</th>
                        <th scope="row">Accion</th>
                      </thead>
                      <tbody>
                    @foreach($categorias as $categoria)
                    @include('pedido.vercat')
                          <tr>
                            <th scope="row" class="text-centert">{{$categoria->TITULO}}</th>
                            <th scope="row"  >                              
                              <a class="btn btn-link text-dark px-3 mb-0">
                                <button type="button" class="btn btn-link text-dark px-3 mb-0"wire:click='cargarlista("{{$categoria->ID_CATEGORIA}}")'title="Seleccionar">
                                <h3><i class="fas fa-check"></i></h3>
                                </button>
                              </a>
                              <a class="btn btn-link text-dark px-3 mb-0">
                                <button type="button" class="btn btn-link text-dark px-3 mb-0" data-bs-toggle="modal" data-bs-target="#vercat{{$categoria->ID_CATEGORIA}}"title="Ver Foto">
                                <h3> <i class="far fa-image"></i></h3>
                                </button>
                              </a>
                            </th>
                       
                          </tr>
                   @endforeach
                  </tbody>
                </table>
                  </div> 
            
            </div>
          </div>
        </div>
        @endif
        @if(Session::get('platillosc')!=null)
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
              <h4 class="font-weight-bolder">Seleccionar</h4>
            </button>
          </h2>
          <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
                <div class="row">  
                  <table class="table table-hover">
                    <thead>
                      <th scope="row">Platillo</th>
                      <th scope="row">Accion</th>
                    </thead>
                    <tbody>            
                    @foreach(Session::get('platillosc') as $platillos)
                    @include('pedido.verpla')
                    
                    <tr>
                      <th scope="row" class="text-center">{{$platillos->TITULO_PLATILLO}}</th>
                      <th scope="row"  >
                        <a class="btn btn-link text-dark px-3 mb-0">
                          <button type="button" class="btn btn-link text-dark px-3 mb-0"  wire:click='seleccionarplatillo("{{$platillos->ID_CATEGORIA}}","{{$platillos->ID_PLATILLO}}","{{$platillos->TITULO_PLATILLO}}","{{$platillos->DESCRIPCION_PLATILLO}}","{{$platillos->COSTO_PLATILLO}}","{{$platillos->boquitas}}","{{$platillos->costo_sin_guarnicion}}")' title="Seleccionar">
                          <h3> <i class="fas fa-plus"></i></h3>
                          </button>
                        </a>
                        
                        <a class="btn btn-link text-dark px-3 mb-0">
                          <button type="button" class="btn btn-link text-dark px-3 mb-0" data-bs-toggle="modal" data-bs-target="#verpla{{$platillos->ID_PLATILLO}}"title="Ver Foto">
                          <h3><i class="far fa-image"></i></h3>
                          </button>
                        </a>
                      </th>
                    </tr>
                   @endforeach
                  </tbody>
                </table>
                  </div>
                </div>
          </div>
        </div>
        @endif


        @if(Session::get('bebidasc')!=null)
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
              <h4 class="font-weight-bolder">Seleccionar</h4>
            </button>
          </h2>
          <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
                <div class="row">  
                  <table class="table table-hover">
                    <thead>
                      <th scope="row">Platillo</th>
                      <th scope="row">Accion</th>
                    </thead>
                    <tbody>             
                   @foreach(Session::get('bebidasc') as $bebidas)
                   @include('pedido.verbeb')
                   <tr>
                     <th scope="row" class="text-center">{{$bebidas->TITUTLO_BEBIDA}}</th>
                     <th scope="row">
                       <a class="btn btn-link text-dark px-3 mb-0">
                         <button type="button" class="btn btn-link text-dark px-3 mb-0"wire:click='seleccionarplatillob("{{$bebidas->ID_BEBIDA}}","{{$bebidas->TITUTLO_BEBIDA}}","{{$bebidas->DESCRIPCION_BEBIDA}}","{{$bebidas->COSTO_BEBIDA}}","{{$bebidas->boquitas}}","{{$bebidas->boquitas}}")' title="Seleccionar">
                         <h3><i class="fas fa-plus"></i></h3>
                         </button>
                       </a>
                       <a class="btn btn-link text-dark px-3 mb-0">
                         <button type="button" class="btn btn-link text-dark px-3 mb-0" data-bs-toggle="modal" data-bs-target="#verbeb{{$bebidas->ID_BEBIDA}}"title="Ver Foto">
                         <h3><i class="far fa-image"></i></h3>
                         </button>
                       </a>
                     </th>
                   </tr>
            @endforeach
          </tbody>
        </table>
                  </div>
                </div>
          </div>
        </div>
        @endif
      @if($idplatillo!=null)
      <div class="accordion-item">
        <h2 class="accordion-header" id="flush-collapseFOR">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFOR" aria-expanded="false" aria-controls="flush-collapseFOR">
            <h4 class="font-weight-bolder">Detalle</h4>
          </button>
        </h2>
        <div id="flush-collapseFOR" class="accordion-collapse" aria-labelledby="flush-collapseFOR" data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            <form wire:submit.prevent="guardartemp()" class="form-floating">
              <div class="row g-2">
                    <div class="col-md">
                  <label class="form-label">Platillo/Bebida:</label>
                  <div class="input-group input-group-outline mb-3">
                    <input type="text" class="form-control" wire:model="TITULO_PLATILLO" required disabled>
                  </div>
              </div>
                     <div class="col-md">
                     <label class="form-label">Descripcion:</label>
                  <div class="input-group input-group-outline mb-3">
                      <input type="text" class="form-control" wire:model="DESCRIPCION_PLATILLO" disabled>
                    </div>
                </div>
                <div class="col-md">
                  <label class="form-label">Costo:</label>
                  <div class="input-group input-group-outline mb-3">
                  <input type="text" class="form-control" value="Q. {{$COSTO_PLATILLO}}" disabled>
                      </div>
                  </div>
                <div class="col-md">
                  <label class="form-label">Cantidad:</label>
                  <div class="input-group input-group-outline mb-3">
                    <select class="form-control" wire:model="cantidadp">
                      <option select></option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                    </select>
                  </div>
                    </div>
                    @error('cantidadp') 
                       <div class="alert alert-danger" role="alert">
                        Seleccione la cantidad.
                      </div>
                       @enderror
               </div>
               <div class="col-md">
                <label class="form-label">Observaciones:</label>
                <div class="input-group input-group-outline mb-3">
                <input type="text" class="form-control" wire:model="observaciones">
                    </div>
                    @error('observaciones') 
                    <div class="alert alert-danger" role="alert">
                     Agrega una descripcion por el cambio.
                   </div>
                    @enderror
                </div>
                @if($cambioaplcat==2)
                <h4 class="font-weight-bolder">
                Cambio
              </h4>
              <div class="input-group input-group-outline mb-3">
              <div class="form-check">
                  <input class="form-check-input" wire:click="agregarextra(1)" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                  <label class="form-check-label" for="flexRadioDefault1">
                    Extra marisco 4oz. (Q. 25.00)
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" wire:click="agregarextra(2)" type="radio" name="flexRadioDefault" id="flexRadioDefault2" >
                  <label class="form-check-label" for="flexRadioDefault2">
                    Extra marisco 6oz. (Q. 40.00)
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" wire:click="agregarextra(0)" type="radio" name="flexRadioDefault" id="flexRadioDefault3" >
                  <label class="form-check-label" for="flexRadioDefault2">
                   Cancelar
                  </label>
                </div>
            </div>

                @endif
                @if($cambioaplcat==1)
                <h4 class="font-weight-bolder">
                Cambio
              </h4>
              <div class="input-group input-group-outline mb-3">
              <div class="form-check">
                  <input class="form-check-input" wire:click="agregarextra(3)" type="radio" name="flexRadioDefault1" id="flexRadioDefault11">
                  <label class="form-check-label" for="flexRadioDefault11">
                    Si
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" wire:click="agregarextra(0)" type="radio" name="flexRadioDefault1" id="flexRadioDefault22" >
                  <label class="form-check-label" for="flexRadioDefault22">
                    No
                  </label>
                </div>
              </div>
                @endif
                @if($sin_guarnicion==1)
                <h4 class="font-weight-bolder">
                ¿Sin guarnición?
              </h4>
              <div class="input-group input-group-outline mb-3">
              <div class="form-check">
                  <input class="form-check-input" wire:click="quitarguarnicion(1)" type="radio" name="flexRadioDefault2" id="flexRadioDefault111">
                  <label class="form-check-label" for="flexRadioDefault111">
                    Si
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" wire:click="quitarguarnicion(0)" type="radio" name="flexRadioDefault2" id="flexRadioDefault222" >
                  <label class="form-check-label" for="flexRadioDefault222">
                    No
                  </label>
                </div>
              </div>
                @endif
                @if($sin_guarnicion==2)
                <h4 class="font-weight-bolder">
                ¿Sin guarnición?
              </h4>
              <div class="input-group input-group-outline mb-3">
              <div class="form-check">
                  <input class="form-check-input" wire:click="quitarguarnicion(2)" type="radio" name="flexRadioDefault3" id="flexRadioDefault1111">
                  <label class="form-check-label" for="flexRadioDefault1111">
                    Si
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" wire:click="quitarguarnicion(0)" type="radio" name="flexRadioDefault3" id="flexRadioDefault2222" >
                  <label class="form-check-label" for="flexRadioDefault2222">
                    No
                  </label>
                </div>
              </div>
                @endif
                @if($BOQUITAS!=null)
                 @if($BOQUITAS==1)
                <div class="col-md">
                  <label class="form-label">Seleccionar Una boquita:</label>
                  <div class="input-group input-group-outline mb-3">
                    <div class="form-check">
                      <input class="form-check-input" wire:click="boquitaop1(1)" type="radio" name="flexRadioDefault" id="flexRadioDefault21">
                      <label class="form-check-label" for="flexRadioDefault21">
                        Cevichitos
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" wire:click="boquitaop1(2)"  type="radio" name="flexRadioDefault" id="flexRadioDefault112" >
                      <label class="form-check-label" for="flexRadioDefault112">
                        Sopitas con camarones
                      </label>
                    </div>
                      </div>
                  </div>
                  @elseif($BOQUITAS==2)
                  <div class="col-md">
                    <label class="form-label">Seleccionar Una boquita:</label>
                    <div class="input-group input-group-outline mb-3">
                      <div class="form-check">
                        <input class="form-check-input" wire:click="boquitaop2(1)"  type="radio" name="flexRadioDefaults" id="flexRadioDefaults1">
                        <label class="form-check-label" for="flexRadioDefaults1">
                          Cevichitos.
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" wire:click="boquitaop2(2)"  type="radio" name="flexRadioDefaults" id="flexRadioDefaultss2" >
                        <label class="form-check-label" for="flexRadioDefaultss2">
                          Sopitas con camarones.
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" wire:click="boquitaop2(3)"  type="radio" name="flexRadioDefaults" id="flexRadioDefaults3" >
                        <label class="form-check-label" for="flexRadioDefaults3">
                          Camarones fritos.
                        </label>
                      </div>
                        </div>
                    </div>

                    @elseif($BOQUITAS==3)
                    <div class="col-md">
                      <label class="form-label">Seleccionar dos boquitas:</label>
                      <div class="input-group input-group-outline mb-3">
                        <div class="form-check">
                          @if($idboq2!=null and $idboq3!=null)
                          <input class="form-check-input" wire:click="boquitaop3(1)"  type="checkbox" id="flexSwitchCheckDefault1" disabled>
                          <label class="form-check-label" for="flexSwitchCheckDefault1">Cevichitos</label>
                          @else
                          <input class="form-check-input" wire:click="boquitaop3(1)"  type="checkbox" id="flexSwitchCheckDefault1">
                          <label class="form-check-label" for="flexSwitchCheckDefault1">Cevichitos</label>
                    
                          @endif
                   </div>
                    <div class="form-check">
                      @if($idboq1!=null and $idboq3!=null)
                      <input class="form-check-input" wire:click="boquitaop3(2)"  type="checkbox" id="flexSwitchCheckChecked2" disabled >
                      <label class="form-check-label" for="flexSwitchCheckChecked2">Sopitas  con camarones</label>

                      @else
                      <input class="form-check-input" wire:click="boquitaop3(2)"  type="checkbox" id="flexSwitchCheckChecked2"  >
                      <label class="form-check-label" for="flexSwitchCheckChecked2">Sopitas  con camarones</label>
                      @endif
                 
                    </div>
                    <div class="form-check">
                      @if($idboq1!=null and $idboq2!=null)
                      <input class="form-check-input" wire:click="boquitaop3(3)"  type="checkbox" id="flexSwitchCheckChecked3" disabled>
                      <label class="form-check-label" for="flexSwitchCheckChecked3">Camarones fritos</label>
                      @else
                      <input class="form-check-input" wire:click="boquitaop3(3)"  type="checkbox" id="flexSwitchCheckChecked3" >
                      <label class="form-check-label" for="flexSwitchCheckChecked3">Camarones fritos</label>
                      @endif
                   
                    </div>
                  </div>
                </div>
                  @endif
                  @endif
                      <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Agregar</button>
                  
            </form>
        </div>
        </div>
      </div>
      @endif

</div>
</div>