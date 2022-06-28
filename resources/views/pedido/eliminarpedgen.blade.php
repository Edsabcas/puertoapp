<div wire:ignore.self class="modal fade" id="delete{{$pedido->ID_PEDIDO}}" tabindex="-1" role="dialog"  aria-labelledby="delete{{$pedido->ID_PEDIDO}}" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" >¿Seguro que desea eliminar el pedido?</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <div class="modal-body">
                
</div>
<div class="modal-footer">
    <input class="form-control btn btn-primary" type="button"  value="Si" data-bs-dismiss="modal" wire:click="eliminarpedgen('{{$pedido->ID_PEDIDO}}','{{$pedido->ID_MESA}}')"/>
    <button class="form-control"type="button" data-bs-dismiss="modal">No</button>
</div>
</div>
</div>
</div>