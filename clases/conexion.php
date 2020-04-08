<?php


    class conectar{
        public function conexion(){
            $servername = "localhost";
            $database = "dxn_mex";
            $username = "dxn_user";
            $password = "pericocampanitA11";
            $conexion = mysqli_connect($servername,$username,$password,$database);

            if (!$conexion) {
                die("Connection failed: ".mysqli_connect_error());
            }
            return $conexion;
        }
    }
