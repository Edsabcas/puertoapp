<div wire:ignore.self class="modal fade" id="confirmartippago" tabindex="-1" role="dialog"  aria-labelledby="confirmartippago" aria-hidden="true" >
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="confirmartippago">Alerta cobro cuenta</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <div class="modal-body">
                <h4 class="modal-title" id="confirmartippago">¿Confirme cobro efectuado?</h4>
</div>
<div class="modal-footer">
  
  <input class="form-control btn btn-primary" type="button"  value="Si" data-bs-dismiss="modal" wire:click="guardar_tipo_doc()"/>
{{--     <input class="form-control btn btn-primary" type="button"  value="Si" data-bs-dismiss="modal" wire:click="cierrecuentaf({{$tpago}})"/> --}}
    <button class="form-control"type="button"data-bs-toggle="modal" data-bs-target="#modalcliente">No</button>
</div>
</div>
</div>
</div>