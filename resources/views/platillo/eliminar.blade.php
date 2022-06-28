<div wire:ignore.self class="modal fade" id="delete{{ $platillo->ID_PLATILLO }}" tabindex="-1" role="dialog"  aria-labelledby="delete{{ $platillo->ID_PLATILLO }}" aria-hidden="true" >
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
        
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <div class="modal-body">
                <label class="form-label">¿Seguro que desea eliminar el Platillo?:</label>
</div>

<div class="modal-footer">
    <input class="form-control btn btn-primary" type="button"  value="Si" data-bs-dismiss="modal" wire:click="elimiarPlatillo({{$platillo->ID_PLATILLO}})"/>
    <button class="form-control"type="button" data-bs-dismiss="modal" wire:click.prevent='cancelar()'>No</button>
</div>
</div>

</div>
</div>
