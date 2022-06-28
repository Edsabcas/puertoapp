<div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="insertarcliente" tabindex="-1" role="dialog"  aria-labelledby="insertarcliente" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <center>
                <h4 class="modal-title" id="confirmartippago">Información requerida</h4>
            </center>
            
            <button type="button" class="btn btn-warning"  data-bs-toggle="modal" data-bs-target="#modalcliente" aria-label="Close">x</button>
          </div>
            <div class="modal-body">
                <h4 >Datos Cliente</h4>
                    <div class="col-md">
                        <label  class="form-label">Nit</label>
                        <div class="input-group input-group-outline mb-3">
                            <input type="number" class="form-control" wire:model="nitclientereg" placeholder="Nit">
                    </div>
                </div>
                <div class="col-md">
                    <label  class="form-label">Cliente</label>
                        <div class="input-group input-group-outline mb-3">
                        <input type="text"  wire:model="nombclientereg" class="form-control" id="validationCustom01"  required>
                      </div>
                    </div>
                    <div class="col-md">
                        <label  class="form-label">Dirección:</label>
                        <div class="input-group input-group-outline mb-3">
                        <input type="text"  wire:model="direccionclientereg" class="form-control" id="validationCustom02" required>
                        <div class="valid-feedback">
                          Looks good!>
                    </div>
                      </div>
                    </div>
                    <button class="btn btn-warning"wire:click="guardarcliente()">Guardar</button>

                @if ($mensaje==1)
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                    <div>
                    Insertado correctamente
                    </div>
                  </div>
                @elseif($mensaje==2)    
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div>
                      No fue posible insertar, intente nuevamente.
                    </div>
                  </div>
                @endif
                @if($existe==1)    
                <div class="alert alert-warning d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div>
                     Ya existe un nit registrado, validar.
                    </div>
                  </div>
                @endif


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmartippago"title="Confirmar Pago">Confirmar</button>
{{--     <input class="form-control btn btn-primary" type="button"  value="Si" data-bs-dismiss="modal" wire:click="cierrecuentaf({{$tpago}})"/> --}}
{{--     <button class="form-control"type="button" data-bs-dismiss="modal">No</button> --}}
</div>
</div>
</div>
</div>