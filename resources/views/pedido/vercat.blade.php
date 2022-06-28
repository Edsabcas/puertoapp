<div wire:ignore.self class="modal fade" id="vercat{{$categoria->ID_CATEGORIA}}" tabindex="-1" role="dialog"  aria-labelledby="vercat{{$categoria->ID_CATEGORIA}}" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="vercat{{$categoria->ID_CATEGORIA}}">¿?</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <div class="modal-body">
                <div class="card1">
                    @if($categoria->FOTO_CATEGORIA!=null OR $categoria->FOTO_CATEGORIA!="")
                      <img src="public/imagen/categoria/{{$categoria->FOTO_CATEGORIA}}" width="120" height="250" class="card-img-top" alt="..." />
                      @else
                      <img src="public/logo.png" class="card-img-top" alt="..." width="130" height="230"/>
                    @endif
                    <div class="card-body">
                      <h5 class="card-title">{{$categoria->TITULO}}</h5>
                      <p class="card-text">
                        {{$categoria->DESCRIPCION}}
                      </p>
                  </div>
                  </div>	

</div>
<div class="modal-footer">
    <button class="form-control"type="button" data-bs-dismiss="modal">Regresar</button>
</div>
</div>
</div>
</div>