<div wire:ignore.self class="modal fade" id="verpla{{$platillos->ID_PLATILLO}}" tabindex="-1" role="dialog"  aria-labelledby="verpla{{$platillos->ID_PLATILLO}}" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="verpla{{$platillos->ID_PLATILLO}}"></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <div class="modal-body">
              <div class="col-sm-10">
                <div class="card1">
                    @if($platillos->FOTO_PLATILLO!=null OR $platillos->FOTO_PLATILLO!="")
                      <img src="public/imagen/platillos/{{$platillos->FOTO_PLATILLO}}" width="120" height="250" class="card-img-top" alt="..." />
                      @else
                      <img src="public/logo.png" class="card-img-top" alt="..." width="130" height="230"/>
                    @endif
                    <div class="card-body">
                      <h5 class="card-title">{{$platillos->TITULO_PLATILLO}}</h5>
                      <p class="card-text">
                        {{$platillos->DESCRIPCION_PLATILLO}}
                      </p>
                    </div>
                  </div>	
                </div>	


</div>
<div class="modal-footer">
    <button class="form-control"type="button" data-bs-dismiss="modal">Regresar</button>
</div>
</div>
</div>
</div>