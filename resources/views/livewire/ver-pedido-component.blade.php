<div class="container">
  <?php
$segundos =50;

header("Refresh:".$segundos."; url=/PENDIENTE_DE_ENTREGA");
?>
    <?php
    $ca=0;
    ?>    
    @if(Session::get('estado')!=null)
    {{session()->forget('estado');}}
    <div class="alert alert-success" role="alert">
       Estado actualizado
      </div>
    @endif

    @if($leido!=null and $leido!=0)
    @php
    $i =0;
    @endphp
    @while($i <= $leido)
    <audio autoplay>
      <source src="public/tono/tono.mp3" type="audio/mp3">
      Tu navegador no soporta HTML5 audio.
    </audio>

  @php
  //sleep(10);
   $i++;   
  @endphp
    @endwhile
    @endif

            @if($pedidos!= null)

            @foreach($rol as $ro)
            @if(auth()->user()->id==$ro->id_user)
            @php
            $r=$ro->id_tipo_rol; @endphp
            @endif
            @endforeach
            <h5 class="card-title text-center"> Pedidos pendientes 
              @php $can=0;@endphp
              @foreach($can_pedidos as $can_pedido)
            @php $can=$can_pedido->cantidad; @endphp
              @endforeach

              <b>
                {{$can}}
              </b>
              

            </h5>
            <hr>
            <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach($pedidos as $pedido)
            @php
            $con=0;
            @endphp
            @php
            $cadena="";
             $timestamp = strtotime($pedido->FECHA_CREACION_PEDIDO);       
           $fpedido=$pedido->FECHA_CREACION_PEDIDO;
           $strTime = array("segundo", "minuto", "hora", "dia", "mes", "año");
           $length = array("60","60","24","30","12","10");

           $currentTime = time();
           if($currentTime >= $timestamp) {
                        $diff = time()- $timestamp;
                        for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
                        $diff = $diff / $length[$i];
                        }

                        $diff = round($diff);
                        $cadena= $diff . " " . $strTime[$i] . "(s)";
           }
            @endphp


                                              @foreach($detalle_pe as $detalle_p)
                                              @if($detalle_p->ID_PEDIDIO ==$pedido->ID_PEDIDO)
                                              @foreach($platillos as $platillo)
                                              @if($detalle_p->ID_PLATILLO==$platillo->ID_PLATILLO)
                                              @foreach($categorias as $categoria)
                                              
                                              @if($categoria->ID_CATEGORIA==$platillo->ID_CATEGORIA)
                                              @if($categoria->ID_AREA==2  or $categoria->ID_AREA==5)
                                              @else
                                              @php
                                              $con=$con+1;
                                              @endphp
                                              @endif
                                              @endif
                                              @endforeach
                                           
                                              @endif 
                                              @endforeach

                                              @foreach($bebidas as $bebida)
                                              @if($detalle_p->ID_PLATILLO==$bebida->ID_BEBIDA)
                                              @foreach($categorias as $categoria)
                                              
                                              @if($categoria->ID_CATEGORIA==$bebida->ID_CATEGORIA)
                                              @if($categoria->ID_AREA==2 || $categoria->ID_AREA==5)

                                              @else
                                              @php
                                              $con=$con+1;
                                              @endphp

                                              @endif
                                              @endif
                                              @endforeach
                                           
                                              @endif 
                                              @endforeach


                                              @endif
                                              @endforeach
              
   

                @if($pedido->ESTADO_PEDIDO==0)
                
                @if($con==0 and $r==4)
                @else

                     @if($r==5 or $r==2 or $r==1 or $r==4 or $r==7 or $r==3)
                      <div class="col-sm-8">
                      <div  class="card text-dark bg-light mb-2" >        
                     <div  class="card-body text-success">
                       
                     @include('pedido.verordenl')
                    </div>
                    @if(($con==0 and $r==5) or ($con==0 and $r==7) or ($con==0 and $r==1)or ($con==0 and $r==2))
                    
                    <a class="btn btn-success" wire:click="cambio_entrega_pla('{{$pedido->ID_PEDIDO}}','{{$pedido->ESTADO_PEDIDO}}','{{$pedido->FECHA_CREACION_PEDIDO}}','{{$cadena}}')">Sale pedido</a>
                        
                    @else
                    @if($r!=3)
                    <a class="btn btn-warning" wire:click="cambio_bebi('{{$pedido->ID_PEDIDO}}','{{$pedido->ESTADO_PEDIDO}}','{{$pedido->FECHA_CREACION_PEDIDO}}','{{$cadena}}')">Sale pedido</a>
                     @endif   
                    @endif
                        <h5 class="card-title text-center">Ingresado hace: {{$cadena}} </h5>  
                      </div>
                    </div>

                    @endif

                @endif
                  

                      @elseif($pedido->ESTADO_PEDIDO==1)

                      @if($r==1 or $r==4 or $r==2 or $r==6 or $r==5 or $r==7 or $r==3)

                      <div class="col">
                        <div  class="card text-dark bg-light mb-3" > 
                      <div  class="card-body text-success">
                        @include('pedido.verordenl')
                      </div>
                          @if($r==5 or $r==7)

                          @else
                           @if($r!=3)
                          <a class="btn btn-danger" wire:click="cambio_cocina_pla('{{$pedido->ID_PEDIDO}}','{{$pedido->ESTADO_PEDIDO}}','{{$pedido->FECHA_CREACION_PEDIDO}}','{{$cadena}}')">Sale pedido</a>
                          <h5 class="card-title text-center">Ingresado hace: {{$cadena}} </h5>
                          @endif
                          @endif
                      </div>
                      </div>
                      @endif



                      @elseif($pedido->ESTADO_PEDIDO==2)
                      @if($r==1 or $r==5 or  $r==7 or  $r==2 or $r==3 )
                      <div class="col">
                        <div  class="card text-dark bg-light mb-3" > 
                      <div  class="card-body text-success">
                        @include('pedido.verordenl')
                       </div>
                        @if($r!=3)
                          <a class="btn btn-success" wire:click="cambio_entrega_pla('{{$pedido->ID_PEDIDO}}','{{$pedido->ESTADO_PEDIDO}}','{{$pedido->FECHA_CREACION_PEDIDO}}','{{$cadena}}')">Sale pedido</a>
                          <h5 class="card-title text-center">Ingresado hace: {{$cadena}} </h5>
                 @endif
                    </div>
                       </div>
                      @endif

                
                  @endif

    
              @endforeach


            </div>
            


              @else
           
                  <div class="card-body text-center">
                      <h5 class="card-title">
                         Sin pedidos pendientes
                      </h5>

                  </div>
                  <hr>
             
                @endif


                @if($leido2!=null and $leido2!=0)
                @php
                $i =0;
                @endphp
                @while($i <= $leido2)
                <audio autoplay>
                  <source src="public/tono/tono.mp3" type="audio/mp3">
                  Tu navegador no soporta HTML5 audio.
                </audio>
            
              @php
              //sleep(10);
               $i++;   
              @endphp
                @endwhile
                @endif


                @if($pedidos_extra!= null)
                <?php
                $r=0;
                ?>
                @foreach($rol as $ro)
                @if(auth()->user()->id==$ro->id_user)
                <?php $r=$ro->id_tipo_rol; ?>
                @endif
                @endforeach
                <br>
                <h5 class="card-title">Extras Pendientes</h5>
                <hr>
                <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach($pedidos_extra as $pedidos_extr)


                @php
                $cadena="";
               
    
                 $timestamp = strtotime($pedidos_extr->FECHA_CREACION_EXTRA);       
                 $fpedido=$pedidos_extr->FECHA_CREACION_EXTRA;
               $strTime = array("segundo", "minuto", "hora", "dia", "mes", "año");
               $length = array("60","60","24","30","12","10");
    
               $currentTime = time();
               if($currentTime >= $timestamp) {
                            $diff = time()- $timestamp;
                            for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
                            $diff = $diff / $length[$i];
                            }
    
                            $diff = round($diff);
                            $cadena= $diff . " " . $strTime[$i] . "(s)";
               }
                @endphp

                @php
                $con=0;
                @endphp
            
                                              @foreach($detalle_pe_ex as $detalle_p)
                                              @if($detalle_p->ID_PEDIDIO ==$pedidos_extr->ID_PEDIDO)
                                              @foreach($platillos as $platillo)
                                              @if($detalle_p->ID_PLATILLO==$platillo->ID_PLATILLO)
                                              @foreach($categorias as $categoria)

                                              @if($categoria->ID_CATEGORIA==$platillo->ID_CATEGORIA)
                                              @if($categoria->ID_AREA==2 || $categoria->ID_AREA==5)

                                              @else
                                              @php
                                              $con=$con+1;
                                              @endphp

                                              @endif

                                              @endif
                                              @endforeach
                                              @endif 
                                              @endforeach
                                              @endif


                                              @foreach($bebidas as $bebida)
                                              @if($detalle_p->ID_PLATILLO==$bebida->ID_BEBIDA)
                                              @foreach($categorias as $categoria )
                                              
                                              @if($categoria->ID_CATEGORIA==$bebida->ID_CATEGORIA)
                                              @if($categoria->ID_AREA==2  || $categoria->ID_AREA==5)
                                              @else
                                              @php
                                              $con=$con+1;
                                              @endphp
                                              @endif
                                              @endif
                                              @endforeach
                                           
                                              @endif 
                                              @endforeach
                                              

                                              @endforeach
                
                @if($pedidos_extr->ESTADO_EXTRA==0)

                @if($con==0 and $r==4)


                @else
                     @if($r==5 or $r==2 or $r==1 or $r==4 or $r==7 or $r==3)
                     <div class="col">
                      <div  class="card text-dark bg-light mb-3" >        
                     <div  class="card-body text-success">
                    
                     @include('pedido.verordenex')
                    </div>
                    @if(($con==0 and $r==5) or ($con==0 and $r==7) or ($con==0 and $r==1)or ($con==0 and $r==2))
                    <a class="btn btn-success" wire:click="cambio_entrega_extra('{{$pedidos_extr->ID_PEDIDO}}','{{$pedidos_extr->ESTADO_EXTRA}}','{{$pedidos_extr->FECHA_CREACION_PEDIDO}}','{{$cadena}}')">Sale pedido</a>
                           
                    @else
                    @if($r!=3)
                    <a class="btn btn-warning" wire:click="cambio_servicio_extra('{{$pedidos_extr->ID_PEDIDO}}','{{$pedidos_extr->ESTADO_EXTRA}}','{{$pedidos_extr->FECHA_CREACION_PEDIDO}}','{{$cadena}}')">Sale pedido</a>
                       @endif      
                    @endif

                        <h5 class="card-title text-center">Ingresado hace: {{$cadena}} </h5>  
               
                   </div>
                    </div>

                      @endif  
                      
                      
                @endif
                
                
 
                @elseif($pedidos_extr->ESTADO_EXTRA==1)

                       @if($r==1 or $r==4 or $r==2 or $r==6 or $r==5 or $r==7 or $r==3)
 
                       <div class="col">
                         <div  class="card text-dark bg-light mb-3" > 
                       <div  class="card-body text-success">
                         @include('pedido.verordenex')
                       </div>
                            @if($r==5 or $r==7)
                           @else
                           @if($r!=3)
                           <a class="btn btn-danger" wire:click="cambio_cocina_extra('{{$pedidos_extr->ID_PEDIDO}}','{{$pedidos_extr->ESTADO_EXTRA}}','{{$pedidos_extr->FECHA_CREACION_PEDIDO}}','{{$cadena}}')">Sale pedido</a>
                           <h5 class="card-title text-center">Ingresado hace: {{$cadena}} </h5>
                               @endif
                           @endif
                       </div>
                       </div>
                       @endif
                       
                       
                       
                       @elseif($pedidos_extr->ESTADO_EXTRA==2)
                      @if($r==1 or $r==5 or  $r==7 or  $r==2 or $r==3 )
                      <div class="col">
                        <div  class="card text-dark bg-light mb-3" > 
                      <div  class="card-body text-success">
                        @include('pedido.verordenex')
                       </div>
                         @if($r==1 or $r==5 or  $r==7 or  $r==2)
                          <a class="btn btn-success" wire:click="cambio_entrega_extra('{{$pedidos_extr->ID_PEDIDO}}','{{$pedidos_extr->ESTADO_EXTRA}}','{{$pedidos_extr->FECHA_CREACION_PEDIDO}}','{{$cadena}}')">Sale pedido</a>
                          <h5 class="card-title text-center">Ingresado hace: {{$cadena}} </h5>
                @endif
                    </div>
                       </div>
                      @endif
                      


                       
                      @endif

                  @endforeach

                </div>

                  @else
               
                      <div class="card-body text-center">
                          <h5 class="card-title">
                        Sin extras pendientes
                          </h5>
    
                      </div>
                      <hr>





                    @endif
</div>
