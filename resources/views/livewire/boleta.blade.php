<div class="col-12 col-lg-10">
    <div class="app-card app-card-chart h-100 shadow-sm">
    <div class="app-card-header p-3">
    <div class="row justify-content-between align-items-center">
    <div class="col-auto">
        <div class="table-responsive">
            <table id="table_id" class="table app-table-hover mb-0 text-left">
        <thead>
            <tr>
                <th class="cell">
             <img src="assets/images/logo.png" width="150" height="110">
                </th>
                <th class="cell" width="450" height="">
                    <h4 class="app-card-title text-center" >Recibo mes en curso Empleado</h4>
                </th>
                <th class="cell">
                    Recibo No. {{$Norecibo}} <h6></h6>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="cell">
                    <p> Empleado:</p>
                   <p> Mes Laborado:</p>
                   <p>Dias Laborados:</p>
                   <p>Periodo Laborado: </p>
                </td>
                <td class="cell">
                    <p> {{$nomcompleto}}</p>
                    <p>{{$descripcionmes}}</p>
                    <p> {{$dia[2]}} dias.</p>
                    <p>Del {{$p_laborado_inicio}} Al {{$p_laborado_fin}}</p>
                </td>
                <td class="cell">
                   <p>No. DPI:</p>
                   <p>Puesto:</p>
                </td>
                <td class="cell">
                    <p>{{$DPI}}</p>
                    <p>{{$Puesto}}</p>
                </td>
            </tr>
        </tbody>
    </table>
    </div>
    </div><!--//col-->
    
    </div><!--//row-->
    </div><!--//app-card-header-->
    <div class="app-card-body p-3 p-lg-9">
    <div class="chart-container">
    <div class="app-card app-card-orders-table shadow-sm mb-5">

        <div class="table-responsive">
            <table id="table_id" class="table table-bordered border-primary">
        <thead>
          <tr style="text-align:center">
            <th class="cell">Concepto</th>
            <th class="cell">Descripcion</th>
            <th class="cell">Debe</th>
            <th class="cell">Haber</th>
        
          </tr>
        </thead>
        <tbody>
            <tr>
                <td class="cell">
                    <h6>Percepciones</h6>
                    
                </td>
                <td class="cell">
                    <p>Salario Ordinario</p>
                    
                    <p>Bonificacion Incentivo dto. 78-98 y reformas</p>
                    
                    <p>Bonificacion Productividad</p>
                    
                </td>
                <td class="cell">
                    
                    <p style="text-align:right">Q. {{$salario_ordinario}}</p>
                    
                    <p style="text-align:right">Q. {{$bonificacion_mensual}}.00</p>
                    
                    <p style="text-align:right">Q. {{$bonificacion_productividad}}.00 </p>
                   
                </td>
            </tr>
            <tr>
                <td class="cell">
                    
                </td>
                <td class="cell" style="text-align:right">
                    <h6>Total: </h6>
                    
                </td>
                <td class="cell" style="text-align:right">
                    Q.{{$totalper}}
                </td>
                <td class="cell">
                    
                </td>
               
            </tr>
            <tr>
                <td class="cell">
                    <h6>Deducciones</h6>
                    
                </td>
                <td class="cell">
                    <p>Iggs laboral</p>
                    
                    <p>ISR</p>
                    
                    <p>Descuentos Judiciales</p>
                    
                    <p>Dias no Laborados: </p>
                    
                    <p>Descuentos Por Anticipo: </p>
                    
                    <p>Cheque BAM: </p>
               
                </td>
                <td class="cell">
        
        
                </td>
                <td class="cell" style="text-align:right">
                    <p>Q. {{$iggs_laboral}} </p>
                    
                    <p>Q.  {{$isr}}.00</p>
                    
                    <p>Q. {{$descuentos_judiciales}}.00 </p>
                    
                    <p>Q. {{$monto_descuento}}.00 </p>
                    
                    <p>Q.  {{$montod}}.00</p>
                    
                    <p>Q.  .00</p>
            
                </td>
            </tr>
            <tr>
                <td class="cell">
                    
                </td>
             
              
                <td class="cell">
                    
                </td>
                <td class="cell" style="text-align:right">
                    <h6>Total:  </h6>
                    
                </td>
                <td class="cell" style="text-align:right">
                    Q. {{$totaldedu}}
                </td>
            </tr>
            <tr>
                <td class="cell">
                    
                </td>
                <td class="cell" style="text-align:right">
                    <h5  style="text-align:right">Total a Recibir:</h5>
                </td>
                <td class="cell">
                    
                </td>
                <td class="cell"style="text-align:right" >
                    <h5>Q. {{$totalrecibir}}</h5>
                    </td>
            </tr>
            <tr>
               
            </tr>
        </tbody>
        </table>
        <div>
            @if($ruta_cheque!=null)
            <img src="public/imagen/boleta/{{$dia[0]}}/{{$dia[1]}}/{{$ruta_cheque}}" width="855" height="300">
            @endif
        </div>
        </div>
    </div><!--//app-card-body-->
    </div><!--//app-card-->
    </div><!--//col-->
    
    </div><!--//row-->

    
    </div>

