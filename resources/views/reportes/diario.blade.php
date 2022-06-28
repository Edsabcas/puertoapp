<div>
    @if(Session::get('rolus')==1)
    @if($fecha_busqueda!=null)
    <div class="card border-primary">
        <div class="card-header"></div>
        <div class="card-body">
          <h5 class="card-title"></h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                      <th></th>
                      <th></th>
                      <th style='text-align:right'>Reporte Diario</th>
                      <th></th>
                      <th></th>
                      <th></th>
                </thead>

                <tbody > 
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <td></td>
                        <td ></td>
                        <td style='text-align:right'> <b>Venta Total:</b> </td>
                        <td><b> Q. {{$venta_total}}</b></td>
                        <td ></td>
                        <td></td>
                    </tr>
                    <tr >
                        <td></td> 
                        <td></td>
                        <td style='text-align:right'>Sub total: </td>
                        <td> <b>Q. {{$venta_total-($total_cevicheria)}}</b> </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style='text-align:right'>Cevicheria: </td>
                        <td><b>Q. {{$total_cevicheria}}</b> </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr  class="table-dark">
                        <td></td>
                        <td ></td>
                        <td></td>
                        <td ></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style='text-align:right'>Propina total: </td>
                        <td> <b>Q. {{$total_propina}}</b> </td>
                        <td></td>
                        <td></td>
                        <td style='text-align:right'>Total Tarjeta: </td>
                        <td> <b>Q. {{$total_tc_sin_rec}}</b></td>
                    </tr>
                    <tr>
                        
                        <td style='text-align:right'>Personal: </td>
                        <td><b>Q. {{$total_personal}}</b> </td>
                        <td></td>
                        <td></td>
                        <td style='text-align:right'>Recargo: </td>
                        <td> <b>Q. {{$monto_recargo}}</b></td>
                    </tr>



                    <tr>
                    <td></td>
                    <td></td>
                        <td style='text-align:right'>Efectivo: </td>
                        <td> <b>Q. {{$total_efe}}</b></td>
                        <td ></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td ></td>
                        <td></td>
                        <td ></td>
                        <td></td>
                        <td></td>
                    </tr>
                
                    <tr class="table-dark">
                        <td></td>
                        <td ></td>
                        <td></td>
                        <td ></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <div class='card text-center'>
                <th><button type="button" class="btn btn-warning" wire:click="imprimir">Generar Cierre</button></th>
                        
            </div>
            <div class='card text-center'>
                <th><button type="button" class="btn btn-warning" wire:click="imprimir2">Generar Detalle cierre</button></th>
                        
            </div>
          </div> 
        </div>
      </div> 
      <div class="card text-center border-primary">
        <div class="card-header"></div>
        <div class="card-body">
          <h5 class="card-title">Detalle del dia</h5>
    
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-dark">
                    <tr>
                     <th>Mesa</th>
                     <th>Mesero</th>
                     <th>Monto Orden</th>
                     <th>Acción</th>
                    </tr>
                  </thead>
                  <tbody>        
                      @foreach ($pedidos as $pedido)
                      <tr>
                          @if($pedido->ID_MESA!=null)
                          @foreach($mesas as $mesa)
                          @if($mesa->ID_MESA==$pedido->ID_MESA)
                          <td>{{$mesa->NO_MESA}}</td>
                          @endif
                          @endforeach
                          @else
                          <td>...</td>
                          @endif
                        
                          
                         
                          @foreach($usuarios as $usuario)
                          @if($usuario->id ==$pedido->ID_EMPLEADO)
                          <td>{{$usuario->name}}</td>
                          @endif
                          @endforeach
                          
                          <td>Q. {{$pedido->MONTO_CUENTA}}</td>
                          <td>
                            <button type="button" class="btn btn-warning">...</button>
                          </td>
                      </tr>
                      @endforeach
                    
                  </tbody>
                </table>
              </div>
        </div>
    </div>     
 @else
 <div class="row text-center" style="background-color: #e9db6e; border:3px solid #d6e7a6; border-radius: 60px 60px 60px 60px;">
    <h3>Seleccione Fecha para Generar Reporte: </h3>
    <br>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6  justify-content-center" style="text-align: center;">
    <input type="date"  style="background-color: #cecdca; color:black" class="form-control" wire:model="fecha_se">
    <br>
    <button class="btn btn-success" wire:click="fecha()">Consultar </button>
    </div>
    <br>
    <br> 
<br>     
</div>     
  @endif  
@endif


@if(Session::get('rolus')==2)
@if($fecha_busqueda!=null)
<div class="row text-center" style="background-color: #ede6b3; border:3px solid #faf09f; border-radius: 60px 60px 60px 60px;">
    <h5>Buqueda ordenes meseros: </h5>
    <br>
    <center>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4  justify-content-center" style="text-align: center;">
        <select style="background-color: #ffffff; color:black" class="form-select form-select-lg mb-3" wire:model="mesero_con" aria-label=".form-select-lg example">
            <option selected>Seleccionar mesero</option>
            @foreach($meseros as $mesero)
                <option value="{{$mesero->id_user}}">{{$mesero->name}}</option>
            @endforeach
          </select>
    <h5>Fecha busqueda: </h5>
    <input type="date"  style="background-color: #ffffff; color:black" class="form-control" wire:model="fecha_se">
    
    <button class="btn btn-success" wire:click="fecha2()">Consultar </button>
    </div>
</center>
    <br>
    <br> 
<br>     
</div>
<div class="card text-center border-primary">
    <div class="card-header"></div>
    <div class="card-body">
      <h5 class="card-title">Detalle del dia</h5>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-dark">
                <tr>
                 <th>Mesa</th>
                 <th>Mesero</th>
                 <th>Monto Orden</th>
                 <th>Acción</th>
                </tr>
              </thead>
              <tbody>        
                  @foreach ($pedidos as $pedido)
                  <tr>
                      @if($pedido->ID_MESA!=null)
                      @foreach($mesas as $mesa)
                      @if($mesa->ID_MESA==$pedido->ID_MESA)
                      <td>{{$mesa->NO_MESA}}</td>
                      @endif
                      @endforeach
                      @else
                      <td>...</td>
                      @endif
                    
                      
                     
                      @foreach($usuarios as $usuario)
                      @if($usuario->id ==$pedido->ID_EMPLEADO)
                      <td>{{$usuario->name}}</td>
                      @endif
                      @endforeach
                      
                      <td>Q. {{$pedido->MONTO_CUENTA}}</td>
                      <td>
                        <button type="button" class="btn btn-warning">...</button>
                      </td>
                  </tr>
                  @endforeach
                
              </tbody>
            </table>
          </div>
    </div>
</div>
@else
<div class="row text-center" style="background-color: #ede6b3; border:3px solid #faf09f; border-radius: 60px 60px 60px 60px;">
    <h5>Buqueda ordenes meseros: </h5>
    <br>
    <center>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4  justify-content-center" style="text-align: center;">
        <select style="background-color: #ffffff; color:black" class="form-select form-select-lg mb-3" wire:model="mesero_con" aria-label=".form-select-lg example">
            <option selected>Seleccionar mesero</option>
            @foreach($meseros as $mesero)
                <option value="{{$mesero->id_user}}">{{$mesero->name}}</option>
            @endforeach
          </select>
    <h5>Fecha busqueda: </h5>
    <input type="date"  style="background-color: #ffffff; color:black" class="form-control" wire:model="fecha_se">
    
    <button class="btn btn-success" wire:click="fecha2()">Consultar </button>
    </div>
</center>
    <br>
    <br> 
<br>     
</div>


@endif  
@endif
</div>

