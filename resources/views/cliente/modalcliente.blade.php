<div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="modalcliente" tabindex="-1" role="dialog"  aria-labelledby="modalcliente" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <center>
                <h4 class="modal-title" id="confirmartippago">Facturación</h4>
            </center>
            
            <button type="button" class="btn btn-warning" wire:click="limpiarcliente()" data-bs-dismiss="modal" aria-label="Close">x</button>
          </div>
            <div class="modal-body">
                <center>
                    <h5>
                   
                      </h5>
                      <div class="row">
                        <button class="btn btn-success btn-lg btn-block"  wire:click="cliente(1)" type="button">NIT</button>
                        <button class="btn btn-secondary btn-lg btn-block" wire:click="cliente(2)" type="button">C/F</button>
                        <button class="btn btn-warning btn-lg btn-block" wire:click="cliente(3)" type="button" >S/F</button>
                      </div>
                      
                </center>


                <h4 >Datos Cliente</h4>
                <form >
                    <div class="col-md">
                        <div class="input-group input-group-outline mb-3">
                          {{--   <button class="btn btn-outline-warning" wire:click="modalinsercliente" data-bs-toggle="modal" data-bs-target="#insertarcliente" type="button" id="button-addon1">+</button>
                           --}}  
          {{--                  @if(($tipo_selc_imp!="" or $tipo_selc_imp!=null) && $tipo_selc_imp==1) --}}
                           <input type="number" class="form-control" wire:model="nitcliente" placeholder="Nit">
                            <button class="btn btn-outline-success" wire:click="buscarCliente()" type="button" id="button-addon2">Buscar</button>
                         {{--   @else --}}
                           <input type="text" class="form-control" wire:model="nitcliente" disabled>
                           {{--  @endif --}}
                    </div>
                    @error('nitcliente')
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                         Ingrese el nit para la busqueda.
                        </div>
                      </div>
                    @enderror
                    @if($existe==2)    
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                       Validar Nit, no aparece en sistema de SAT.
                        </div>
                      </div>
                    @endif
                </div>
                <div class="col-md">
                    <label  class="form-label">Cliente</label>
                        <div class="input-group input-group-outline mb-3">
                        <input type="text" wire:model='nombcliente'  class="form-control" id="validationCustom01" disabled required>
                      </div>
                    </div>
                    <div class="col-md">
                        <label  class="form-label">Dirección:</label>
                        <div class="input-group input-group-outline mb-3">
                        <input type="text"  wire:model="direccioncliente" class="form-control" id="validationCustom02" disabled required>
                        <div class="valid-feedback">
                          Looks good!>
                    </div>
                      </div>
                    </div>
                </form>

                @if($nombcliente!=null && $nombcliente!="" && $direccioncliente!=null && $direccioncliente!="")
                <div class="row">
                  <h2>¿Factura con detalle?</h2>
                  <button class="btn btn-success btn-lg btn-block"  wire:click="formafac(1)" type="button">SI</button>
                      <button class="btn btn-secondary btn-lg btn-block" wire:click="formafac(2)" type="button">NO</button>
                </div>
                

                @endif 
</div>
<div class="modal-footer">
    @if ($nitcliente!=null && $nombcliente!=null && $direccioncliente !=null && $forma_fac!=null && $forma_fac!="")
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmartippago"title="Confirmar Pago">Confirmar</button>
    @endif
 {{--     <input class="form-control btn btn-primary" type="button"  value="Si" data-bs-dismiss="modal" wire:click="cierrecuentaf({{$tpago}})"/> --}}
{{--     <button class="form-control"type="button" data-bs-dismiss="modal">No</button> --}}
</div>
</div>
</div>
</div>