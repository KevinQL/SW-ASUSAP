<?php
//Permite incluir los archivos necesarios para las funciones de consulta.
$AjaxRequest=true;

require_once "../core/configSite.php";

require_once "../controllers/adminController.php";

$inst = new adminController();

require "fpdf/fpdf.php";

//$idate=$_GET['inicioDate']  ;
//ADIR=${start_date}&AEST=${estad}&ACAT=${catA}
$aDirc=$_GET['ADIR'];
$aEstd=$_GET['AEST'];
$aCatg=$_GET['ACAT'];
$MdAso=$_GET['MdAsoci'];


if ($aDirc=="TODOS" && $aEstd==3 && $aCatg=="Todos" && $MdAso=="Todos"){

    $query = "SELECT s.cod_suministro,s.direccion, s.tiene_medidor,a.nombre,a.apellido,s.asociado_dni,s.categoria_suministro FROM (suministro s INNER JOIN asociado a ON a.dni = s.asociado_dni)";
    //$query .= 'direccion = "'.$aDirc.'"';

}else{

    $query = "SELECT s.cod_suministro,s.direccion, s.tiene_medidor,a.nombre,a.apellido,s.asociado_dni,s.categoria_suministro FROM suministro s INNER JOIN asociado a ON a.dni = s.asociado_dni WHERE ";

    //--------------------ESTADOS----------------------------------------
    if ($aDirc == "TODOS" && $aEstd == 0) {

        if ($aCatg=="Domestico"){

            if ($MdAso=='C Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND   tiene_medidor="'.'0'.'" AND';
            }
            else if ($MdAso=='Todos'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
            }

           // $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
        }
        if ($aCatg=="Comercial"){
            if ($MdAso=='C Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND   tiene_medidor="'.'0'.'" AND';
            }
            else if ($MdAso=='Todos'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
            }

           // $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND';
        }
        if ($aCatg=="Estatal"){
            if ($MdAso=='C Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND   tiene_medidor="'.'0'.'" AND';
            }
            else if ($MdAso=='Todos'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
            }
           // $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
        }
        if ($aCatg=="Industrial"){
            if ($MdAso=='C Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND   tiene_medidor="'.'0'.'" AND';
            }
            else if ($MdAso=='Todos'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
            }
            //$query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
        }
        ///.................PARA TODOS
        if ($aCatg=="Todos"){
            if ($MdAso=='C Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   tiene_medidor="'.'0'.'" AND';
            }
            else if ($MdAso=='Todos'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND';
            }
            //$query .= 'estado_corte ="'.$_POST["estad"].'" AND   categoria_suministro="'.$_POST["catA"] .'" AND';
        }

        $query .= ' estado_corte="' . $_GET['AEST']. '" ';
    }
    else if ($aDirc == "TODOS" && $aEstd == 2) {

        if ($aCatg=="Domestico"){
            if ($MdAso=='C Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND   tiene_medidor="'.'0'.'" AND';
            }
            else if ($MdAso=='Todos'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
            }

           // $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
        }
        if ($aCatg=="Comercial"){
            if ($MdAso=='C Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND   tiene_medidor="'.'0'.'" AND';
            }
            else if ($MdAso=='Todos'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
            }

           // $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND';
        }
        if ($aCatg=="Estatal"){
            if ($MdAso=='C Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND   tiene_medidor="'.'0'.'" AND';
            }
            else if ($MdAso=='Todos'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
            }
            //$query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
        }
        if ($aCatg=="Industrial"){
            if ($MdAso=='C Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND   tiene_medidor="'.'0'.'" AND';
            }
            else if ($MdAso=='Todos'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
            }
            //$query .= 'estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
        }

        ///.................PARA TODOS
        if ($aCatg=="Todos"){
            if ($MdAso=='C Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND   tiene_medidor="'.'0'.'" AND';
            }
            else if ($MdAso=='Todos'){
                $query .= 'estado_corte ="'.$_GET['AEST'].'" AND';
            }
            //$query .= 'estado_corte ="'.$_POST["estad"].'" AND   categoria_suministro="'.$_POST["catA"] .'" AND';
        }

        $query .= ' estado_corte="' . $_GET['AEST']. '" ';
    }

    //-----------------------------TIPO DE ESTADO DE DiVARSAS DIRECCIONES--------------------------------------------
    else if ($aDirc!="TODOS" && $aEstd==3){
        if ($aCatg=="Domestico"){

            if ($MdAso=='Todos'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND';
            }
            else if ($MdAso=='C Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'0'.'" AND';
            }

           // $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
        }
        if ($aCatg=="Comercial"){
            if ($MdAso=='Todos'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND';
            }
            else if ($MdAso=='C Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'0'.'" AND';
            }

          //  $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
        }
        if ($aCatg=="Estatal"){
            if ($MdAso=='Todos'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND';
            }
            else if ($MdAso=='C Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'0'.'" AND';
            }
           // $query .= ' direccion ="'.$_GET['ADIR'].'" AND  categoria_suministro="'.$_GET['ACAT'].'" AND';
        }
        if ($aCatg=="Industrial"){
            if ($MdAso=='Todos'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND';
            }
            else if ($MdAso=='C Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'0'.'" AND';
            }
           // $query .= ' direccion ="'.$_GET['ADIR'].'" AND  categoria_suministro="'.$_GET['ACAT'].'" AND';
        }
        if ($aCatg=="Todos"){
            if ($MdAso=='Todos'){
                $query .= ' direccion ="'.$_GET['ADIR'] .'" AND';
            }
            else if ($MdAso=='C Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   tiene_medidor="'.'0'.'" AND';
            }
            // $query .= ' direccion ="'.$_POST["start_date"].'" AND   categoria_suministro="'.$_POST["catA"] .'" AND';
        }

        $query .= ' direccion ="'.$_GET['ADIR'].'"';
    }
    else if ($aDirc!="TODOS" && $aEstd==2){
        if ($aCatg=="Domestico"){
            if ($MdAso=='Todos'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND';
            }
            else if ($MdAso=='C Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'0'.'" AND';
            }

          // $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
        }
        if ($aCatg=="Comercial"){
            if ($MdAso=='Todos'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND';
            }
            else if ($MdAso=='C Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'0'.'" AND';
            }
          //  $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
        }
        if ($aCatg=="Estatal"){
            if ($MdAso=='Todos'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND';
            }
            else if ($MdAso=='C Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'0'.'" AND';
            }
         //   $query .= ' direccion ="'.$_GET['ADIR'].'" AND  categoria_suministro="'.$_GET['ACAT'].'" AND';
        }
        if ($aCatg=="Industrial"){
            if ($MdAso=='Todos'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND';
            }
            else if ($MdAso=='C Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'0'.'" AND';
            }
          //  $query .= ' direccion ="'.$_GET['ADIR'].'" AND  categoria_suministro="'.$_GET['ACAT'].'" AND';
        }
        if ($aCatg=="Todos"){
            if ($MdAso=='Todos'){
                $query .= ' direccion ="'.$_GET['ADIR'] .'" AND';
            }
            else if ($MdAso=='C Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   tiene_medidor="'.'0'.'" AND';
            }
            // $query .= ' direccion ="'.$_POST["start_date"].'" AND   categoria_suministro="'.$_POST["catA"] .'" AND';
        }

        $query .= ' direccion ="'.$_GET['ADIR'].'" AND estado_corte ="'.$_GET['AEST'].'"';
    }
    else if ($aDirc!="TODOS" && $aEstd==0){
        if ($aCatg=="Domestico"){
            if ($MdAso=='Todos'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND';
            }
            else if ($MdAso=='C Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'0'.'" AND';
            }

           // $query .= ' direccion ="'.$_GET['ADIR'].'" AND estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
        }
        if ($aCatg=="Comercial"){
            if ($MdAso=='Todos'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND';
            }
            else if ($MdAso=='C Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'0'.'" AND';
            }

            //$query .= ' direccion ="'.$_GET['ADIR'].'" AND estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
        }
        if ($aCatg=="Estatal"){
            if ($MdAso=='Todos'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND';
            }
            else if ($MdAso=='C Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'0'.'" AND';
            }
           // $query .= ' direccion ="'.$_GET['ADIR'].'" AND estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
        }
        if ($aCatg=="Industrial"){
            if ($MdAso=='Todos'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND';
            }
            else if ($MdAso=='C Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   categoria_suministro="'.$_GET['ACAT'] .'" AND   tiene_medidor="'.'0'.'" AND';
            }
           // $query .= ' direccion ="'.$_GET['ADIR'].'" AND estado_corte ="'.$_GET['AEST'].'" AND   categoria_suministro="'.$_GET['ACAT'].'" AND';
        }

        if ($aCatg=="Todos"){
            if ($MdAso=='Todos'){
                $query .= ' direccion ="'.$_GET['ADIR'] .'" AND';
            }
            else if ($MdAso=='C Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   tiene_medidor="'.'1'.'" AND';
            }
            else if ($MdAso=='S Medidor'){
                $query .= ' direccion ="'.$_GET['ADIR'].'" AND   tiene_medidor="'.'0'.'" AND';
            }
            // $query .= ' direccion ="'.$_POST["start_date"].'" AND   categoria_suministro="'.$_POST["catA"] .'" AND';
        }

        $query .= ' direccion ="'.$_GET['ADIR'].'" AND estado_corte ="'.$_GET['AEST'].'"';
    }

    //-------------------------CATEGORIA DE SUMINISTRO-------------------------------------

    else if ($aDirc=="TODOS" && $aEstd==3 && $aCatg=="Domestico"){

        if ($MdAso=='C Medidor'){
            $query .= 'categoria_suministro ="'.$_GET['ACAT'].'" AND   tiene_medidor ="'.'1'.'"';
        }else if ($MdAso=="Todos"){
            $query .= 'categoria_suministro ="'.$_GET['ACAT'].'"';
        }else if ($MdAso=='S Medidor'){
            $query .= 'categoria_suministro ="'.$_GET['ACAT'].'" AND   tiene_medidor ="'.'0'.'"';
        }


        //$query .= 'categoria_suministro="'.$_GET['ACAT'].'"';
    }
    else if ($aDirc=="TODOS" && $aEstd==3 && $aCatg=="Comercial"){
        if ($MdAso=='C Medidor'){
            $query .= 'categoria_suministro ="'.$_GET['ACAT'].'" AND   tiene_medidor ="'.'1'.'"';
        }else if ($MdAso=="Todos"){
            $query .= 'categoria_suministro ="'.$_GET['ACAT'].'"';
        }else if ($MdAso=='S Medidor'){
            $query .= 'categoria_suministro ="'.$_GET['ACAT'].'" AND   tiene_medidor ="'.'0'.'"';
        }

       // $query .= 'categoria_suministro="'.$_GET['ACAT'].'"';
    }
    else if ($aDirc=="TODOS" && $aEstd==3 && $aCatg=="Estatal"){
        if ($MdAso=='C Medidor'){
            $query .= 'categoria_suministro ="'.$_GET['ACAT'].'" AND   tiene_medidor ="'.'1'.'"';
        }else if ($MdAso=="Todos"){
            $query .= 'categoria_suministro ="'.$_GET['ACAT'].'"';
        }else if ($MdAso=='S Medidor'){
            $query .= 'categoria_suministro ="'.$_GET['ACAT'].'" AND   tiene_medidor ="'.'0'.'"';
        }

        //$query .= 'categoria_suministro="'.$_GET['ACAT'].'"';
    }
    else if ($aDirc=="TODOS" && $aEstd==3 && $aCatg=="Industrial"){
        if ($MdAso=='C Medidor'){
            $query .= 'categoria_suministro ="'.$_GET['ACAT'].'" AND   tiene_medidor ="'.'1'.'"';
        }else if ($MdAso=="Todos"){
            $query .= 'categoria_suministro ="'.$_GET['ACAT'].'"';
        }else if ($MdAso=='S Medidor'){
            $query .= 'categoria_suministro ="'.$_GET['ACAT'].'" AND   tiene_medidor ="'.'0'.'"';
        }

      //  $query .= 'categoria_suministro="'.$_GET['ACAT'].'"';
    }

    //-------------------------------------CON MEDIDOR ----------------------------------------------------
    else if ($aDirc=="TODOS" && $aEstd==3 && $aCatg=="Todos" && $MdAso=='Todos' ){
        $query .= ' tiene_medidor ="'.$_GET['MdAsoci'].'" ';
        //$query .=' direccion ="'.$_POST["start_date"]. 'AND tiene_medidor="'."1".'" AND';
    }
    else if ($aDirc=="TODOS" && $aEstd==3 && $aCatg=="Todos" && $MdAso=='S Medidor' ){
        $query .= ' tiene_medidor ="'.'0'.'"';
        //$query .=' direccion ="'.$_POST["start_date"]. 'AND tiene_medidor="'."1".'" AND';
    }
    else if ($aDirc=="TODOS" && $aEstd==3 && $aCatg=="Todos" && $MdAso=='C Medidor' ){
        $query .= ' tiene_medidor ="'.'1'.'"';
        //$query .=' direccion ="'.$_POST["start_date"]. 'AND tiene_medidor="'."1".'" AND';
    }

}

//$query .= 'direccion = "'.$aDirc.'"';
$query .= 'ORDER BY apellido ASC ';
$result = $inst->consultaAsociado( $query );
//Permite incluir los archivos necesarios para las funciones de consulta.

$_POST['urlimg'] = 'img/boletaAGua.jpg';


$IRAS=$_GET['RAS'];



date_default_timezone_set('America/Lima');
$created_date = date("Y-m-d H:i");
session_start(['name'=>'ASUSAP']);
$_SESSION['fecha']=$created_date;
$_SESSION['asDIR']=$aDirc;
//$_SESSION['fechaFinal']=$_GET['finalDate'];
$_SESSION['diatotal']=$td;
$_SESSION['medidor']=$MdAso;

//desNSI=${co}&descSI=${a}&desCcSI=${to}

$ac = count(explode(",", $IRAS));

$array1 = explode(",", $IRAS, $ac );



class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        //$this->Image('images/logo.png', 5, 5, 30 );
        $this->SetFont('Arial','B',15);
        $this->Cell(30);
        $this->Cell(120,10, 'Reporte De Suministro',0,0,'C');
        $this->SetFont('Arial','B',10);
        $this->Cell(10);
        $this->Cell(20,20,'Fecha: '.$_SESSION['fecha'],0,0,'R');
        $this->SetFont('Arial','B',15);
        $this->SetX(50);
        $this->SetY(15);
        $this->Cell(185,20,''.$_SESSION['asDIR']." - ".$_SESSION['medidor'],0,0,'C');
        $this->Ln(20);// Logo
        $this->Image('img/agua.jpg',10,6,45);
        //$this->Image('img/agua.jpg',0,0,10,8);
        // Arial bold 15
        //// Movernos a la derecha
        //$this->Cell(5);


        // Título
        //$this->Cell(30, 12, 'ASUSAP', 0, 0, 'C');
        // Salto de línea
        // $this->Ln(20);
    }

    // Pie de página
    function Footer()
    {

        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        $this->SetFont('Arial','I', 8);
        $this->Cell(0,10, 'Pagina '.$this->PageNo().'/{nb}',0,0,'C' );
        // Número de página
        //  $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF('P', 'mm', 'A4');

//cUANDO NO HAY REGISTRO
$pdf->AddPage();/*
$pdf->SetFont('Arial', 'B', 20);
$pdf->SetXY(5, 7);
$pdf->SetFont('Arial', 'B', 15);
$pdf->SetXY(75, 6);*/
$pdf->SetY(35);
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(10,6,'#',1,0,'C',1);
$pdf->Cell(30,6,'SUMINISTRO',1,0,'C',1);
$pdf->Cell(90,6,'APELLIDO Y NOMBRE',1,0,'C',1);
$pdf->Cell(25,6,'DNI',1,0,'C',1);
$pdf->Cell(30,6,'T. SMT',1,0,'C',1);
$pdf->Cell(10,6,'Med.',1,1,'C',1);
//$pdf->Cell(20,6,'C. Smt',1,1,'C',1);


$pdf->SetFont('Arial','',10);
//PARA LOS SERVICIOS
/*$textypos+=25;
$off = $textypos+25;

$pdf->SetFont('Arial','',12);*/
$textypos+=35;
//$pdf->setX(2);
//$pdf->Cell(5,$textypos,'Nombre del Servicio / Descripcion          PRECIO ');

$off = $textypos+25;
$o=1;
$y=0;
//$query = "SELECT s.cod_suministro,s.direccion, s.tiene_medidor,a.nombre,a.apellido,s.asociado_dni FROM suministro s INNER JOIN asociado a ON a.dni = s.asociado_dni WHERE ";
while($row = $result->fetch()) {

    $pdf->SetFillColor(232,232,232);
    $pdf->Cell(10,6,$o++,1,0,'C');
    $pdf->Cell(30,6,utf8_decode($row['cod_suministro']),1,0,'C');
    $pdf->Cell(90,6,utf8_decode($row['apellido']." ".$row['nombre']),1,0,'L');
    $pdf->Cell(25,6,utf8_decode($row['asociado_dni']),1,0,'C');
   //$pdf->Cell(5,6,$row['tiene_medidor'],1,0,'C');
    $pdf->Cell(30,6,utf8_decode($row['categoria_suministro']),1,0,'C');
    if ($row['tiene_medidor'] == "1"){
       // $sub_array[] = "CM";
        $pdf->Cell(10,6,utf8_decode("CM"),1,1,'C');
    }else{

        $pdf->Cell(10,6,utf8_decode("SM"),1,1,'C');
    }
    //$pdf->Cell(10,6,utf8_decode($row['tiene_medidor']),1,1,'C');
  //  $y=$y+$row['contador_deuda'];
    //$pdf->Cell(20,6,utf8_decode($y=($y+$row['total_pago'])),1,1,'C');

    /* $pdf->Cell(11,$off,2,".","," ,0,0,"R");
     $off+=12;*/


}
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetX(158);
//$pdf->Cell(10, 10,'TOTAL:  '. 'S/ '.$y, 0, 0, 'L');

$pdf->Output();

?>