<?php

    set_time_limit(600);
    function conexion()
    {
        $servername = "localhost";
        $database = "dxn_mex";
        $username = "root";
        $password = "";
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $database);
        // Check connection
        if (!$conn) {
            die("Connection failed: ".mysqli_connect_error());
        }
        return $conn;
    }

function tableIsr($conn)
{
    if ($result = $conn->query("SELECT * FROM table_isr")) {
        return $result;
    }else { return 0;}
}

function calcularIsr($miembro,$nombre,$importe,$tableIsr){

    foreach ($tableIsr as $row) {
        // Imprime datos de MySQL
        if($row['lower_limit']<= $importe && $importe <= $row['upper_limit']){
        $base = $importe - $row['lower_limit'];
        $tasa = $row['percent'];  
        $resul = $base * ($tasa/100) ;
        $cuota = $row['monthly_fee'];
        $isr = $resul + $cuota;
        $neto = $importe - $isr;
        $json = createObject($miembro,$nombre,$importe,$row['lower_limit'],$base,$tasa,$resul,$cuota,$isr,$neto);
        return $json;
     }
    }
    return 0;
}

function inversoIsr($miembro,$nombre,$neto,$tableIsr){
    $lower_limit = 0;
    $importe =0;
    $netoArray['NETO'] = 0;
     foreach($tableIsr as $row){
        if($row['lower_limit']<= $neto && $neto <= $row['upper_limit']){
            $lower_limit = number_format($row['lower_limit'],2,'.','');
        }
    }

        foreach($tableIsr as $row){
            if($row['lower_limit']== $lower_limit){
                $tasa = $row['percent'];
                $cuota = $row['monthly_fee'];
                $Nimporte = $neto + $cuota;
            }
        }

      $Nimporte = rangoNimporte($neto,$Nimporte,$cuota);

      if($neto >= 10738.10){
            for($i=0;$neto > $netoArray['NETO'];$i++){
                $netoArray = calcularIsr($miembro,$nombre,$Nimporte,$tableIsr);
                $Nimporte =$Nimporte + 0.01;
            }
      }else{
        for($i=0;$netoArray['NETO'] < $neto;$i++){
            $netoArray = calcularIsr($miembro,$nombre,$Nimporte,$tableIsr);
            $Nimporte = $Nimporte + 0.01;
      }
    }
        return $netoArray;     
}

function createObject($miembro,$nombre,$importe,$limite_inferior,$base,$porcen_impuesto,$impuesto,$cuota,$isr,$neto){
    $array = array();
    $array["MIEMBRO"] = $miembro;
    $array["NOMBRE"] = $nombre;
    $array["IMPORTE"] = number_format($importe, 2, '.', '');
    $array["BASE MENSUAL"] = number_format($importe, 2, '.', '');
    $array["LIMITE INFERIOR"] = number_format($limite_inferior, 2, '.', '');
    $array["BASE"] = number_format($base, 2, '.', '');
    $array["% SOBRE IMPUESTO"] = number_format($porcen_impuesto, 2, '.', '');;
    $array["IMPUESTO MARGINAL"] = number_format($impuesto, 2, '.', '');
    $array["CUOTA FIJA"] = number_format($cuota, 2, '.', '');
    $array["ISR A RETENER"] = number_format($isr, 2, '.', '');;
    $array["NETO"] = number_format($neto, 2, '.', '');;
    
    return $array;
 }


 function rangoNimporte($neto,$Nimporte,$cuota){

    if($neto >=15000 && $neto <=15999.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 100;  
    }
    if($neto >=16000 && $neto <=24222.31){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 1300;
        //echo "importe:".$Nimporte;  
    }
    if($neto >=24222.32 && $neto <=28000.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 1100;
        //echo "importe:".$Nimporte;  
    }
    if($neto >=28001 && $neto <=30000){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 2330;
        //echo "importe:".$Nimporte;  
    }
    if($neto >= 30000.01 && $neto <= 32000.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 2900;
    }
    if($neto >= 32001.00 && $neto <= 35050.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 3430;
       
    }
    if($neto >= 35051.00 && $neto <= 38177.69){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 4920;
    }
    if($neto >= 38177.70 && $neto <= 39999.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 3060;
        // echo "valor:".$Nimporte;
    }

    if($neto >= 40000 && $neto <= 44999.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 3850;
    }
    if($neto >= 45000 && $neto <= 54999.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 5990;
    }
    if($neto >= 55000 && $neto <= 56000.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 10090;
        // echo "entor";
        // echo $Nimporte;
    }  
    if($neto >= 56001 && $neto <= 57000.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 10730;
        // echo "entor";
        // echo $Nimporte;
    } 
    if($neto >= 57001 && $neto <= 58000.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 11207;
        // echo "entor";
        // echo $Nimporte;
    }  
    if($neto >= 58001 && $neto <= 63000.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 11675;
        //echo "entor";
        //echo $Nimporte;
    }   
    if($neto >= 63001 && $neto <= 67000.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 14030;
        //echo "valor:".$Nimporte;
    }
    if($neto >= 67001 && $neto <= 70000.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 15887;
        //echo "valor:".$Nimporte;
    }
    if($neto >= 70001 && $neto <= 72887.50){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 17300;
        //echo "valor:".$Nimporte;
    }
    if($neto >= 72887.51 && $neto <= 77000.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 8300;
        //echo "valor:".$Nimporte;
    }
    if($neto >= 77001 && $neto <= 80000.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 10430;
        ///echo "valor:".$Nimporte;
    }
    if($neto >= 80001 && $neto <= 83000.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 11930;
        //echo "valor:".$Nimporte;
    }
    if($neto >= 83001 && $neto <= 86000.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 13524;
        //echo "valor:".$Nimporte;
    }
    if($neto >= 86001 && $neto <= 89000.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 15070;
        //echo "valor:".$Nimporte;
    }
    if($neto >= 89001 && $neto <= 92000.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 16614;
        //echo "valor:".$Nimporte;
    }
    if($neto >= 92001 && $neto <= 95000.99){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 18163;
        //echo "valor:".$Nimporte;
    }
    if($neto >= 95001 && $neto <= 97183.33){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 19709;
        //echo "valor:".$Nimporte;
    }
    if($neto >= 97183.34 && $neto <= 100000){
        $Nimporte = 0;
        $Nimporte = $neto + $cuota + 13059;
        //echo "valor:".$Nimporte;
    }

    return $Nimporte;
 }

?>