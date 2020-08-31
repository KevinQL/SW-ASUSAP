<?php
$AjaxRequest=true;
require_once "../core/configSite.php";

require_once "../controllers/adminController.php";

$val=$_POST['valor'];
if(!empty($val))
{
    $valor=$_POST['valor'];
    $inst = new adminController();
    $r=$inst->listaRservicio($valor);
    //print_r($r);
    echo json_encode($r);
}

if (isset($_POST['idV'])){
    $insertv=$_POST['insertV'];
    $idv=$_POST['idV'];
    $db_handle->updGConsumo($insertv,$idv);
    /*
        $queryUpd = "UPDATE factura_recibo SET consumo = $editv WHERE  idfactura_recibo= $idv";
        $result = $db_handle->consultaAsociado($queryUpd);
    */

    echo $result;
}

?>

