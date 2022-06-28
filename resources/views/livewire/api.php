<?php
use Illuminate\Support\Facades\DB;

$anio=date("Y");
$mes=date("m");
$dia=date("d");
$sql = "SELECT * FROM tb_pedidos where ESTADO_PEDIDO>=0 and YEAR(FECHA_CREACION_PEDIDO)=? and MONTH(FECHA_CREACION_PEDIDO)=? and DAY(FECHA_CREACION_PEDIDO)=?";
$pedidos= DB::select($sql,array($anio,$mes,$dia));

if ($pedidos!=null){

    $datanew = [];

    foreach ($pedidos as  $value) {
      // code...
      $datacol['NO_PEDIDO']  = $value['NO_PEDIDO'];
      $datacol['ID_MESA']  = $value['ID_MESA'];
      $datacol['ID_EMPLEADO']  = $value['ID_EMPLEADO'];

      DB::beginTransaction();
      if(DB::table('tb_pedidos')
      ->where('ID_PEDIDO', $value['ID_PEDIDO'])
      ->update( 
          ['leido' =>1,
        ]))
        {
          DB::commit();
        }
      else{
          DB::rollback();
      }  

      array_push($datanew,$datacol);
    }

    $response['registro'] = $datanew;
    $response['success'] = true;
  }
  else {
    $response['registro'] = null;
    $response['success'] = false;
  }

  // respuesta eb json
  echo json_encode($response);


?>