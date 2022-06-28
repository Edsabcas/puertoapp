<div class="row">
    <div class="col-12">
      <div class="card mb-3 btn-reveal-trigger">
        <div class="card-header position-relative min-vh-25 mb-8">
          <div class="cover-image">

  @if(Session::get('var')!=null)
{{session()->forget('var');}}
  <div class="alert alert-success border-2 d-flex align-items-center" role="alert">
    <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-3"></span></div>
    <p class="mb-0 flex-1">Actulizado correctamente</p>
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif


 
 
  

            <!--/.bg-holder-->
   
          
          </div>
          <div class="avatar avatar-5xl avatar-profile shadow-sm img-thumbnail rounded-circle">

          
            @if(auth()->user()->foto!=null)
           
            <div class="h-100 w-100 rounded-circle overflow-hidden position-relative"> <img src="../../assets/img/team/{{auth()->user()->foto}}" width="200" alt="" data-dz-thumbnail="data-dz-thumbnail" /> 
       
            @else
            <div class="h-100 w-100 rounded-circle overflow-hidden position-relative"> <img src="../../assets/img/team/avatar.png" width="200" alt="" data-dz-thumbnail="data-dz-thumbnail" />
            @endif
          

            <form action="/fperfil" enctype="multipart/form-data" method="POST">
                @csrf   
                
                <input class="d-none" id="profile-image" accept="image/*" name="imagen" type="file" required />
                
              <label class="mb-0 overlay-icon d-flex flex-center" for="profile-image">
                <span class="bg-holder overlay overlay-0"></span>
                <span class="z-index-1 text-white dark__text-white text-center fs--1">
                  <span class="fas fa-camera"></span><span class="d-block">Cargar</span></span>
                </label>
            </div>
            <div class="col-12 d-flex justify-content-end">
                <button class="btn btn-primary" type="submit">Actualizar foto </button>
              </div>
            </div>

        </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row g-0">
    <div class="col-lg-8 pe-lg-2">
      <div class="card mb-3">
        <div class="card-header">
          <h5 class="mb-0">Mi informacion</h5>
        </div>
        <div class="card-body bg-light">
         
            <div class="col-lg-6">
              <label class="form-label" for="first-name" >Nombre de Usuario</label>
              <input class="form-control" id="first-name" type="text" value="{{auth()->user()->name}}" disabled/>
            </div>
            <div class="col-lg-6">
              <label class="form-label" for="email1">Email</label>
              <input class="form-control" id="email1" type="text" value="{{auth()->user()->email}}"disabled />
            </div>
        
        </div>
      </div>

      <div class="card mb-3 mb-lg-0">
        <div class="card-header">
          <h5 class="mb-0">Cambiar Contraseña</h5>
        </div>
        <div class="card-body bg-light"><a class="mb-4 d-block d-flex align-items-center" href="#education-form" data-bs-toggle="collapse" aria-expanded="false" aria-controls="education-form"><span class="circle-dashed"><span class="fas fa-plus"></span></span><span class="ms-3">Presiona...</span></a>
          <div class="collapse" id="education-form">
            <div id="form" onkeypress="enterEnviar(event);">
            <form method="POST" class="row" action="/updatecontra" name="formulario" >
              @csrf 
              <input type="hidden" name="id" value="{{auth()->user()->id}}"> 
             <div id="resultado"></div>
              <div class="col-3 mb-3 text-lg-end">
                <label class="form-label" for="password">Contraseña Actual</label>
              </div>
              <div class="col-9 col-sm-7 mb-3">
                <input class="form-control form-control-sm" id="password" type="password" name="actualpassword"/>
              </div>
              <div class="col-3 mb-3 text-lg-end">
                <label class="form-label" for="degree">Contraseña Nueva</label>
              </div>
              <div class="col-9 col-sm-7 mb-3">
                <input class="form-control form-control-sm" type="password" placeholder="Contraseña" id="pass"  name="password">
              </div>
              <div class="col-3 mb-3 text-lg-end">
                <label class="form-label" for="degree">Confirmar Contraseña Nueva</label>
              </div>
              <div class="col-9 col-sm-7 mb-3">
                <input  class="form-control form-control-sm" type="password" placeholder="Repetir contraseña" id="pass2">
              </div>
              <div class="col-9 col-sm-7 offset-3">
                <input class="btn btn-primary" type="button" onclick="validarContraseña()"  value="Verificar">
              </div>
            
            </form>
          </div>
            <div class="border-dashed-bottom my-3"></div>
        </div>
      </div>
    </div>

  </div>






 <script>
   //función para ahorrar codigo [document.getElementById() = __()];
function __(id){
  return document.getElementById(id);
}

//Validar contraseña
function validarContraseña() {
  var pass = __('pass').value,
      pass2 = __('pass2').value;
  if(pass != '' && pass2 != ''){
    if(pass != pass2){
      //si las contraseñas no coinciden
     
      __('resultado').innerHTML = '<p class="error"><strong>Error: </strong>¡Las contraseñas no coinciden!</p>';
    
    } else {
     
     
      
      document.formulario.submit()
      //Si todo esta correcto 
      __('form').innerHTML = '<p class="correcto"><strong>✓ Correcto: </strong>Los datos son correctos :)</p>';
    
    }
  } else {
    //si los campos o uno, este vacio
    __('resultado').innerHTML = '<p class="error"><strong>Error: </strong>¡Los campos no deben estar vacios!</p>';
  } 
}

//enviar formulario con la tecla ENTER
function enterEnviar(event){
    if(event.keyCode == 13){
      validarContraseña()
     
    }
}

 </script>
