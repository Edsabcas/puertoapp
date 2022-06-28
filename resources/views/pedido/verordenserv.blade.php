<div class="col-sm-5">
  

    <div class="row g-2">
    <div class="card">
    <div class="card-body">
  <table class="table table-hover">
    <thead>
        @if($pedido->extra>0)
        <th scope="row">Extra</th>
        @else
         <th scope="row"></th>
        @endif
      @foreach($mesas as $mesa)
      @if($mesa->ID_MESA == $pedido->ID_MESA)
      <th scope="row" class="text-center">Mesa: {{$mesa->NO_MESA}}</th>
    @endif
    @endforeach
      <th scope="row">{{$pedido->FECHA_CREACION_PEDIDO}}</th>  
          </thead>
    <thead>
      <th scope="row">Cantidad</th>
      <th scope="row">Platillo</th>
      <th scope="row">Observacion</th>
    </thead>
    <tbody> 
          <tr>
          @foreach($detalle_pe as $detalle_p)
            @if($detalle_p->ID_PEDIDIO ==$pedido->ID_PEDIDO)
           @if($r==1 or $r==2 or $r==4)
            @foreach($platillos as $platillo)
            @if($detalle_p->ID_PLATILLO==$platillo->ID_PLATILLO)
          <th scope="row" class="text-center">{{$detalle_p->CANTIDAD_SOLICITADA}}</th>
          <td  class="text-center"> {{$platillo->TITULO_PLATILLO}} </td>
          <td  class="text-center">{{$detalle_p->OBSERVACION}}</td>
          @endif
            @endforeach
            @endif
            @if($r==1 or $r==2 or $r==5)
            @foreach($bebidas as $bebida)
          @if( $detalle_p->ID_PLATILLO == $bebida->ID_BEBIDA)
          <td scope="row" class="text-center">{{$detalle_p->CANTIDAD_SOLICITADA}}</td>
          <td class="text-center"> {{$bebida->TITUTLO_BEBIDA}} </td>
          <td  class="text-center">{{$detalle_p->OBSERVACION}}</td>
        @endif
        @endforeach
        @endif
      </tr>
        @endif
        @endforeach