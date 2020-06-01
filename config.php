<?php
// seteando valores para la conexion.
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tp2_desa_app_web');
 
// ejectuando la conexion con los valores ya seteados.
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
//  validando error en conexion. 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>