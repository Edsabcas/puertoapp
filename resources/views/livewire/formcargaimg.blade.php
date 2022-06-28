<form class="form-floating" wire:submit.prevent="validarcargab">
    <div class="mb-3 row">
  <label for="inputGroupFile01">Cargar Captura Cheque/Transferencia</label>
  <input type="file"  name="imagen" id="imagen" class="form-control"  wire:model="fileBoleta">
  @error('fileBoleta') 
  <div class="alert alert-danger" role="alert">
  Pendiente de cargar captura
  </div>
  @enderror
</div>
<hr>
<button class="btn app-btn-primary" type="submit">Editar Acciones</button>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script type="text/javascript">
	function readURL(input) {
	  if (input.files && input.files[0]) {
	  var reader = new FileReader();
	  reader.onload = function(e) {
		// Asignamos el atributo src a la tag de imagen
		$('#imagenmuestra').attr('src', e.target.result);
	  }
	  reader.readAsDataURL(input.files[0]);
	  }
	}
	
	// El listener va asignado al input
	$("#imagen").change(function() {
	  readURL(this);
	});
	  </script>
</form>
<div class="app-card-thumb-holder p-3">
<div class="app-card-thumb">
<img src="" width="150px" height="120px" class="thumb-image" alt="" id="imagenmuestra">
</div>

</div>

