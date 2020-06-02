<?php
// Chequea que exista el parametro id.
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    // Sentencia Select
    $sql = "SELECT * FROM TAREAS WHERE ID_TAREA = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind de variables para setearlas como parámetros
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Setea parámetros
        $param_id = trim($_GET["id"]);
        
        // Intento de ejecución
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* El resultado lo arma como un array. Como el resultado tiene una sola columna
                no se necesita un loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Recupera el valor de cada campo
                $fecha = $row["FECHA_ASIGNACION"];
                $descripcion = $row["DESCRIPCION"];
                $tiempo = $row["TIEMPO_ASIGNADO"];
                $observaciones = $row["OBSERVACIONES"];
            } else{
                // Si la URL no encuentra el ID redirecciona a la página de error.
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Algo salió mal.";
        }
    }
     
    // Se cierra elk statement
    mysqli_stmt_close($stmt);
    
    // Se cierra la conexión
    mysqli_close($link);
} else{
    // Si la URL no encuentra el ID redirecciona a la página de error.
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ver Empleado</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="styles.css">
    <style type="text/css">
    
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1 class="titulo text-center">Ver Tarea</h1>
                    </div>
                    <div class="form-group">
                        <label>Fecha de asignación</label>
                        <p class="form-control-static"><?php echo $row["FECHA_ASIGNACION"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Descripción de la tarea<./label>
                        <p class="form-control-static"><?php echo $row["DESCRIPCION"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Tiempo asignado a la tarea.</label>
                        <p class="form-control-static"><?php echo $row["TIEMPO_ASIGNADO"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Observaciones.</label>
                        <p class="form-control-static"><?php echo $row["OBSERVACIONES"]; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Volver</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
<footer class="page-footer font-small blue">
            <div class="footer-copyright text-center py-3">© 2020 Copyright:
                <p class="decorado">Figueras Gonzalo, Galarza Agustin, Gutierrez Marcelo</p>
            </div>

</footer>
</html>