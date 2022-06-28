<div wire:ignore.self class="modal fade" id="delete{{$mesa->ID_MESA }}" tabindex="-1" role="dialog"  aria-labelledby="delete{{ $mesa->ID_MESA }}" aria-hidden="true" >
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="delete{{ $mesa->ID_MESA }}">¿?</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <div class="modal-body">
                <label class="form-label">¿Seguro que desea eliminar la mesa?:</label>
</div>

<div class="modal-footer">
    <input class="form-control btn btn-primary" type="button"  value="Si" data-bs-dismiss="modal" wire:click="eliminarMesa({{$mesa->ID_MESA}})"/>
    <button class="form-control"type="button" data-bs-dismiss="modal" wire:click.prevent='cancelar()'>No</button>
</div>
</div>

</div>
</div>
