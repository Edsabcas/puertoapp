<div wire:ignore.self class="modal fade" id="delete{{ $bebida->ID_BEBIDA }}" tabindex="-1" role="dialog"  aria-labelledby="delete{{$bebida->ID_BEBIDA }}" aria-hidden="true" >
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <div class="modal-body">
                <label class="form-label">¿Seguro que desea eliminar?:</label>
</div>

<div class="modal-footer">
    <input class="form-control btn btn-primary" type="button"  value="Si" data-bs-dismiss="modal" wire:click="eliminarbebida({{$bebida->ID_BEBIDA}})"/>
    <button class="form-control"type="button" data-bs-dismiss="modal" wire:click.prevent='cancelar()'>No</button>
</div>
</div>

</div>
</div>
