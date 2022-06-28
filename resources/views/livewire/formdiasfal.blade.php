
<form class="settings-form">
    <div class="col-auto">
        <label class="form-check-label">Dias Faltantes</label>
        <input type="number" class="form-control" wire:model='dias_faltantes' wire:keydown='desdiasfal()'wire:click='desdiasfal()'>
        @error('dias_faltantes') 
        <div class="alert alert-danger d-flex align-items-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <span>Pendiente de ingreso</span>
           </div> @enderror
    </div>

    <div class="col-auto">
      <label class="form-check-label">Mes de Descuento: </label>
      <select class="form-select w-auto" wire:model='id_mes_descuento'>
          @if(Session::get('mesdes')!=null)
          <option selected wire:model='id_mes_descuento'>{{Session::get('mesdes')}}</option>
          @else
          @if(Session::get('meses')!=null)
          <option selected >Seleccione:</option>
          @foreach(Session::get('meses') as $mes)
          @if($mes->id>=Session::get('mesactual'))
          <option value="{{$mes->id}}">{{$mes->descripcion}}</option>
          @endif
          @endforeach
          @endif
          @endif
      </select>
      @error('id_mes_descuento') 
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
   <span>Pendiente de ingreso</span>
   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @enderror
  </div>

    <div class="col-auto">
      <label class="form-check-label">Observacion</label>
      <textarea class="form-control"rows="2" cols="25" wire:model='observacion'>Observacion:</textarea>
      @error('observacion')    <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <span>Pendiente de ingreso</span>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div> @enderror
    </div>
    <div class="col-auto">
      <label class="form-check-label">Dias Faltantes</label>
      <input type="number" class="form-control" wire:model='monto_descuento'>
      @error('monto_descuento') 
      <div class="alert alert-danger d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
          <span>Pendiente de ingreso</span>
         </div> @enderror
  </div>
    </form>