<div class="table-responsive">
  <table class="table table-hover">
    <thead>

        <th scope="row">Mesero: {{$pedido->name}}</th>
            @if($pedido->ID_MESA !=null)
          @foreach($mesas as $mesa)
          @if($mesa->ID_MESA == $pedido->ID_MESA )
          <th scope="row" class="text-center">Mesa: {{$mesa->NO_MESA}}</th>

            @endif
            @endforeach
            @endif

            @if($pedido->tipo_pedido ==2)
            <th scope="row" class="text-center">A Domicilio: {{$pedido->nombre_cliente}}</th>
            @elseif($pedido->tipo_pedido ==3)
            <th scope="row" class="text-center">Para Llevar: {{$pedido->nombre_cliente}}</th>
            @elseif($pedido->tipo_pedido ==4)
            <th scope="row" class="text-center">P. Interno: {{$pedido->nombre_cliente}}</th>
            @endif

          <th scope="row" class="text-center">{{$pedido->FECHA_CREACION_PEDIDO}}</th>
          
          </thead>
    <thead >
      <td scope="row" class="text-center">Cantidad</td>
      <td scope="row" class="text-left">Platillo</td>
      <td scope="row" class="text-left">Observación</td>
    </thead>
    <tbody> 
          <tr>
          @foreach($detalle_pe as $detalle_p)
            @if($detalle_p->ID_PEDIDIO ==$pedido->ID_PEDIDO && $detalle_p->extra==0)
           @if($r==1 or $r==2 or $r==5 or  $r==4 or  $r==3)
            @foreach($platillos as $platillo)
            @foreach($categorias as $categoria)
            @if($detalle_p->ID_PLATILLO==$platillo->ID_PLATILLO)
            @if( $platillo->ID_CATEGORIA==$categoria->ID_CATEGORIA)
            <th scope="row" class="text-center">{{$detalle_p->CANTIDAD_SOLICITADA}}</th>
            <td  class="text-left"> {{$platillo->TITULO_PLATILLO}} </td>
            <td  class="text-left">{{$detalle_p->OBSERVACION}}</td>

          @endif
          @endif
            @endforeach
            @endforeach

            
            @foreach($bebidas as $bebida)
           @foreach($categorias as $categoria)

            @if($detalle_p->ID_PLATILLO==$bebida->ID_BEBIDA)
            @if( $bebida->ID_CATEGORIA==$categoria->ID_CATEGORIA)
              @if($categoria->ID_AREA==1)
           <td scope="row" class="text-center">{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
           <td class="text-left"> {{$bebida->TITUTLO_BEBIDA}} </td>
           <td  class="text-left">{{$detalle_p->OBSERVACION}}</td>
           @endif
           @endif
           @endif

           @endforeach
          @endforeach



            @endif


            @if($r==1 or $r==2 or $r==5 or $r==3)
            @foreach($bebidas as $bebida)
           
          @if( $detalle_p->ID_PLATILLO == $bebida->ID_BEBIDA)
          <?php$ca=$ca+1;?>
          <td scope="row" class="text-center">{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
          <td class="text-left"> {{$bebida->TITUTLO_BEBIDA}} </td>
          <td  class="text-left">{{$detalle_p->OBSERVACION}}</td>
        @endif
        @endforeach
        @endif

      </tr>
        @endif
        @endforeach
      </tbody>
    </table>
</div>