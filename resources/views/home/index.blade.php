@extends('plantilla.layout')
@section('contenido')

@if(Session::get('usuario')!=null)
@include('login.register')
{{session()->forget('usuario');}}
@endif

@if(Session::get('platillo')!=null)
@include('platillo.index')
{{session()->forget('platillo');}}
@endif


@if(Session::get('bebida')!=null)
@include('bebida.index')
{{session()->forget('bebida');}}
@endif

@if(Session::get('categoria')!=null)
@include('categoria.index')
{{session()->forget('categoria');}}
@endif

@if(Session::get('mesa')!=null)
@include('mesa.index')
{{session()->forget('mesa');}}
@endif

@if(Session::get('adpedido')!=null)
@include('pedido.index')
{{session()->forget('adpedido');}}
@endif

@if(Session::get('verpedido')!=null)
@include('pedido.verpedido')
{{session()->forget('verpedido');}}
@endif

@if(Session::get('adextra')!=null)
@include('pedido.agregarextra')
{{session()->forget('adextra');}}
@endif

@if(Session::get('verpedidoentregado')!=null)
@include('pedido.mostrarpedidos')
{{session()->forget('verpedidoentregado');}}
@endif

@if(Session::get('edipedido')!=null)
@include('pedido.editarpedido')
{{session()->forget('edipedido');}}
@endif

@if(Session::get('alertacu')!=null)
@include('cuenta.alerta')
{{session()->forget('alertacu');}}
@endif

@if(Session::get('impcomprobante')!=null)
@include('cuenta.impcom')
{{session()->forget('impcomprobante');}}
@endif

@if(Session::get('tpropina')!=null)
@include('propina.index')
{{session()->forget('tpropina');}}
@endif

@if(Session::get('reportes')!=null)
@include('reportes.index')
{{session()->forget('reportes');}}
@endif


@endsection