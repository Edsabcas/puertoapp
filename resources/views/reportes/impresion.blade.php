<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
            <h5 class="card-title text-center">Restaurante El Puerto</h5>
              <p class="card-title text-center">Resumen del dia | {{$fechaactual}}</p>
              <div class="table-responsive">
                <table class="table table-hover">
                <thead style="background-color: rgb(9, 76, 139);">
                </thead>
                <tbody > 
                <tr style="background-color: rgb(9, 76, 139);">
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr style="background-color: rgb(9, 76, 139);">
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr style="background-color: rgb(9, 76, 139);">
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
                        <td> <b>Q. {{$venta_total-($total_cevicheria+$monto_recargo+$total_personal+$total_propina)}}</b> </td>
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
                    <tr style="background-color: rgb(9, 76, 139);">
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
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
                        <td> <b>Q. {{$venta_total-($total_tc_sin_rec+$monto_recargo)}}</b></td>
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
                
                    <tr style="background-color: rgb(9, 76, 139);">
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tbody>
            </table>
    <br>
    <br>  

 
    

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>