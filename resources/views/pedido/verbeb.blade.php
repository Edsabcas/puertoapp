<div wire:ignore.self class="modal fade" id="verbeb{{$bebidas->ID_BEBIDA}}" tabindex="-1" role="dialog"  aria-labelledby="verbeb{{$bebidas->ID_BEBIDA}}" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="verbeb{{$bebidas->ID_BEBIDA}}"></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <div class="modal-body">
                <div class="col-sm-10">
                    <div class="card1">
                        @if($bebidas->FOTO_BEBIDA!=null OR $bebidas->FOTO_BEBIDA!="")
                          <img src="public/imagen/bebidas/{{$bebidas->FOTO_BEBIDA}}" width="120" height="250" class="card-img-top" alt="..." />
                          @else
                          <img src="public/logo.png" class="card-img-top" alt="..." width="130" height="230"/>
                        @endif
                        <div class="card-body">
                          <h5 class="card-title">{{$bebidas->TITUTLO_BEBIDA}}</h5>
                          <p class="card-text">
                            {{$bebidas->DESCRIPCION_BEBIDA}}
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