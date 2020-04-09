<!DOCTYPE html>
<html>

<head>
    <title>DXN MEXICO</title>
    <link rel="icon" type="imagen/ico" href="img/dxn.ico">
    <!-- <html lang="es"> -->

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap-grid.min.css">
        <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap-reboot.min.css">
        <script type="text/javascript" src="librerias/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="librerias/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="librerias/bootstrap/js/jquery-3.4.1.min.js"></script>
    </head>

    <body>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <a href=""><img src="img/dxn.png" height="50px"></a>
            <a class="navbar-brand disabled" href="">DXN-México</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.html">Cargar nuevo archivo</a>
                    </li>
                </ul>
            </div>
        </nav>
    </body>

    <!-- </html> -->

    <link rel="stylesheet" href="css/estilos2.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>



</head>

<body>

    <div>

        <?php 
            if (isset($_POST['isr'])){
                echo '<h2 align="center">Calculo ISR</h2>';
            }else{
                echo '<h2 align="center">Calculo inverso de ISR</h2>';
            }      
        ?>

        <div class="panel panel-dark">
            <div class="panel-heading bg-dark">
                <h3 class="panel-title" style="color:rgb(255, 255, 255); font-weight:bold;">Resultados de archivo de Excel.</h3>
            </div>
            <div class="panel-body ">
                <div>
                    <?php
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
                    $highestColumn = $sheet->getHighestColumn();
                    $num=0;
                    for ($row = 1; $row <= $highestRow; $row++){ 
                        $num++;
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
                    echo '<div>
                    <table class="table table-hover table-condensed" id="iddataTable" style="text-align:center;">
                    <thead style="background-color:#343A40; color:rgb(255, 255, 255);font-weight:bold;">
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
                    </thead>';

                    $num=0;
                    $importeTotal = 0;
                    $isrTotal =0;
                    $netoTotal=0;
                    for ($row = 1; $row <= $highestRow; $row++){ 
                        $num++;
                        echo '<tr>';
                        echo '<th scope=row>';
                        echo $num;
                        echo '</th>';
                        $dataArray["MIEMBRO"][$row] = $sheet->getCell("A".$row)->getValue();
                        $dataArray["NOMBRE"][$row] = $sheet->getCell("B".$row)->getValue();
                        $dataArray["IMPORTE"][$row] = $sheet->getCell("C".$row)->getValue();

                        $importeTotal=$importeTotal+$dataArray[$row]["IMPORTE"];
                        $isrTotal=$isrTotal+$dataArray[$row]["ISR A RETENER"];
                        $netoTotal=$netoTotal+$dataArray[$row]["NETO"];

                        echo '<td>'.$dataArray[$row]["MIEMBRO"].'</td>';
                        echo '<td>'.$dataArray[$row]["NOMBRE"].'</td>';
                        echo '<td>'.$dataArray[$row]["IMPORTE"].'</td>';
                        echo '<td>'.$dataArray[$row]["BASE MENSUAL"].'</td>';
                        echo '<td>'.$dataArray[$row]["LIMITE INFERIOR"].'</td>';
                        echo '<td>'.$dataArray[$row]["BASE"].'</td>';
                        echo '<td>'.$dataArray[$row]["% SOBRE IMPUESTO"].'</td>';
                        echo '<td>'.$dataArray[$row]["IMPUESTO MARGINAL"].'</td>';
                        echo '<td>'.$dataArray[$row]["CUOTA FIJA"].'</td>';
                        echo '<td>'.$dataArray[$row]["ISR A RETENER"].'</td>';
                        echo '<td>'.$dataArray[$row]["NETO"].'</td>';
                        echo '</tr>';
                    }

                    echo "<h4 align='center'><b>IMPORTE TOTAL: ".number_format($importeTotal, 2, '.', '').'&nbsp;&nbsp;&nbsp;';
                    echo "ISR TOTAL: ".number_format($isrTotal, 2, '.', '').'&nbsp;&nbsp;&nbsp;';
                    echo "NETO TOTAL: ".number_format($netoTotal, 2, '.', '')."</b></h4>";

                ?>
                        </tbody>

                        </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#iddataTable').DataTable({
                "scrollY": "250px",
                "scrollCollapse": true,
                "paging": false,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>

</body>
<footer>
    <div>
        <p class="arriba">En caso de dudas o aclaraciones contáctanos. <br>Horarios de atención: <br>10:00 a 15:00 hrs.</p>
        <div class="row">
            <div class="col-6">
                <p>Correo: <br>mauricio.gutierrez.cruz@outlook<br>saidcorona80@gmail.com</p>
            </div>
            <div class="col-6">
                <p>Teléfono: <br>55 4835 0411 <br>56 1078 3531</p>
            </div>
        </div>

        <p class="abajo">©Copyright 2020 - Sistema creado por SoftbotSolutions para DXN-México</p>
    </div>
</footer>

</html>