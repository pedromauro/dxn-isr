<!DOCTYPE html>
<html>

<head>
    <title>DXN MEXICO</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <h2>Calculo ISR</h2>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Resultados de archivo de Excel.</h3>
            </div>
            <div class="panel-body">
                <div class="col-lg-12">



                    <?php



error_reporting(0);
require_once 'PHPExcel/Classes/PHPExcel.php';
require_once 'functions.php';
require_once 'scripts.php';


$archivo = $_FILES["archivo"];
$url = $archivo["tmp_name"];
$dataArray = array();

$conn = conexion();
$table_isr = tableIsr($conn);

$inputFileType = PHPExcel_IOFactory::identify($url);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($url);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();?>




                    <?php
//lee el documento y lo almacena en un array
$num=0;
for ($row = 1; $row <= $highestRow; $row++){ $num++;
       
          
           $dataArray["MIEMBRO"][$row] = $sheet->getCell("A".$row)->getValue(); 
           $dataArray["NOMBRE"][$row] = $sheet->getCell("B".$row)->getValue(); 
           $dataArray["IMPORTE"][$row] = $sheet->getCell("C".$row)->getValue();
          

}
// Calcula todos los datos del Array
  for($row = 1; $row <=$highestRow; $row++){

    //var_dump($dataArray["NOMBRE"][1]);
    if (isset($_POST['isr'])){
     $dataArray[$row] = calcularIsr($dataArray["MIEMBRO"][$row],$dataArray["NOMBRE"][$row],$dataArray["IMPORTE"][$row],$table_isr);
  }elseif (isset($_POST['isrI'])){
    $dataArray[$row] = inversoIsr($dataArray["MIEMBRO"][$row],$dataArray["NOMBRE"][$row],$dataArray["IMPORTE"][$row],$table_isr);
  }
}

?>
                    <div>
                        <table class="table table-hover table-condensed" id="iddataTable">
                            <thead style="background-color: #82A5B3;color:white;font-weight:bold;">
                                <tr>
                                    <td>#</td>
                                    <td>MIEMBRO</td>
                                    <td>NOMBRE</td>
                                    <td>IMPORTE</td>
                                    <td>BASE MENSUAL</td>
                                    <td>LIMITE INFERIOR</td>
                                    <td>BASE</td>
                                    <td>% </td>
                                    <td>IMPUESTO MARGINAL </td>
                                    <td>CUOTA FIJA </td>
                                    <td>ISR </td>
                                    <td>NETO </td>
                                </tr>
                            </thead>
                            <tfoot style="background-color: #ccc;color:white;font-weight:bold;">
                                <tr>
                                    <td>#</td>
                                    <td>MIEMBRO</td>
                                    <td>NOMBRE</td>
                                    <td>IMPORTE</td>
                                    <td>BASE MENSUAL</td>
                                    <td>LIMITE INFERIOR</td>
                                    <td>BASE</td>
                                    <td>% </td>
                                    <td> IMPUESTO MARGINAL </td>
                                    <td> CUOTA FIJA </td>
                                    <td> ISR </td>
                                    <td> NETO </td>
                                </tr>
                            </tfoot>
                            <tbody>


                                <?php
//lee el documento y lo almacena en un array
$num=0;
$importeTotal = 0;
$isrTotal =0;
$netoTotal=0;
for ($row = 1; $row <= $highestRow; $row++){ $num++;?>
                                <tr>
                                    <th scope='row'><?php echo $num;?></th>
                                    <?php $dataArray["MIEMBRO"][$row] = $sheet->getCell("A".$row)->getValue(); ?>
                                    <?php $dataArray["NOMBRE"][$row] = $sheet->getCell("B".$row)->getValue(); ?>
                                    <?php $dataArray["IMPORTE"][$row] = $sheet->getCell("C".$row)->getValue(); ?>

                                    <?php $importeTotal=$importeTotal+$dataArray[$row]["IMPORTE"] ?>
                                    <?php $isrTotal=$isrTotal+$dataArray[$row]["ISR A RETENER"] ?>
                                    <?php $netoTotal=$netoTotal+$dataArray[$row]["NETO"] ?>

                                    <td><?php echo $dataArray[$row]["MIEMBRO"];?></td>
                                    <td><?php echo $dataArray[$row]["NOMBRE"];?></td>
                                    <td><?php echo $dataArray[$row]["IMPORTE"];?></td>
                                    <td><?php echo $dataArray[$row]["BASE MENSUAL"];?></td>
                                    <td><?php echo $dataArray[$row]["LIMITE INFERIOR"];?></td>
                                    <td><?php echo $dataArray[$row]["BASE"];?></td>
                                    <td><?php echo $dataArray[$row]["% SOBRE IMPUESTO"];?></td>
                                    <td><?php echo $dataArray[$row]["IMPUESTO MARGINAL"];?></td>
                                    <td><?php echo $dataArray[$row]["CUOTA FIJA"];?></td>
                                    <td><?php echo $dataArray[$row]["ISR A RETENER"];?></td>
                                    <td><?php echo $dataArray[$row]["NETO"];?></td>


                                </tr>

                                <?php	
}

echo " <br> IMPORTE TOTAL:".number_format($importeTotal, 2, '.', '');
echo " <br> ISR TOTAL:".number_format($isrTotal, 2, '.', '');
echo " <br> NETO TOTAL:".number_format($netoTotal, 2, '.', '');

?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
            $(document).ready(function() {
                $('#iddataTable').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            });
            </script>
</body>




















</html>