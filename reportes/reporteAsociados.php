<?php
//Permite incluir los archivos necesarios para las funciones de consulta.
$AjaxRequest=true;

require_once "../core/configSite.php";

require_once "../controllers/adminController.php";

$inst = new adminController();

require "fpdf/fpdf.php";

//$idate=$_GET['inicioDate'];
$idate=$_GET['ADIR'];

//$query = "SELECT * FROM suministro WHERE ";
if ($idate=="TODOS"){

    $query = "SELECT s.cod_suministro,s.direccion, s.tiene_medidor,a.nombre,a.apellido,s.asociado_dni,s.categoria_suministro FROM (suministro s INNER JOIN asociado a ON a.dni = s.asociado_dni)";
    //$query .= 'direccion = "'.$idate.'"';

}else{

    $query = "SELECT s.cod_suministro,s.direccion, s.tiene_medidor,a.nombre,a.apellido,s.asociado_dni,s.categoria_suministro FROM suministro s INNER JOIN asociado a ON a.dni = s.asociado_dni WHERE ";
    $query .= 'direccion = "'.$idate.'"';
}

//$query .= 'direccion = "'.$idate.'"';
$query .= 'ORDER BY apellido ASC ';
$result = $inst->consultaAsociado( $query );
//Permite incluir los archivos necesarios para las funciones de consulta.

$_POST['urlimg'] = 'img/boletaAGua.jpg';
//anRSI=${anIRS}&codSI=${codsuI}&desNSI=${co},
//$codSRSI=$_POST['CodRS']  tto;
//window.open(`../reportes/reportesAmortizar.php?inicioDate=${start_date}&finalDate=${end_date}`,'_blank')

$IRAS=$_GET['RAS'];
//$idate=$_GET['inicioDate'];
//$fdate=$_GET['finalDate'];


//session_start(['name'=>'ASUSAP']);
//$_SESSION['cost']=$_GET['cosTSI'];


date_default_timezone_set('America/Lima');
$created_date = date("Y-m-d H:i");
session_start(['name'=>'ASUSAP']);
$_SESSION['fecha']=$created_date;
$_SESSION['asDIR']=$idate;
//$_SESSION['fechaFinal']=$_GET['finalDate'];
$_SESSION['diatotal']=$td;

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
        $this->Cell(185,20,''.$_SESSION['asDIR'],0,0,'C');
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
$pdf->Cell(100,6,'NOMBRE Y APELLIDO',1,0,'C',1);
$pdf->Cell(25,6,'DNI',1,0,'C',1);
$pdf->Cell(5,6,'M',1,0,'C',1);
$pdf->Cell(20,6,'C. Smt',1,1,'C',1);


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
    $pdf->Cell(100,6,utf8_decode($row['apellido']." ".$row['nombre']),1,0,'L');
    $pdf->Cell(25,6,utf8_decode($row['asociado_dni']),1,0,'C');
    $pdf->Cell(5,6,$row['tiene_medidor'],1,0,'C');
    $pdf->Cell(20,6,utf8_decode($row['categoria_suministro']),1,1,'C');
  //  $y=$y+$row['contador_deuda'];
    //$pdf->Cell(20,6,utf8_decode($y=($y+$row['total_pago'])),1,1,'C');

    /* $pdf->Cell(11,$off,2,".","," ,0,0,"R");
     $off+=12;*/


}
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetX(158);
//$pdf->Cell(10, 10,'TOTAL:  '. 'S/ '.$y, 0, 0, 'L');

$pdf->Output();

