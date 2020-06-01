<?php
// Include config file
require_once "config.php";
 
// Define variables e inicializa todas vacías
$fecha = date("Y-d-m");
$descripcion = $tiempo  = $observaciones = "";
$fecha_err = $descripcion_err = $tiempo_err = $observaciones_err = "";
 
// Procesa datos cuando se envia el formulario
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Valida fecha
    $input_fecha = trim($_POST["fecha"]);
    if(empty($input_fecha)){
        $fecha_err = "Por favor ingrese la fecha.";
    } else{
        $fecha = $input_fecha;
    }
    
    // Valida descripcion
    $input_descripcion= trim($_POST["descripcion"]);
    if(empty($input_descripcion)){
        $descripcion_err = "Por favor ingrese una descripción.";     
    } else{
        $descripcion = $input_descripcion;
    }
    
    // Valida tiempo
    $input_tiempo = trim($_POST["tiempo"]);
    if(empty($input_tiempo)){
        $tiempo_err = "Por favor ingrese la cantidad de tiempo asignado.";     
    } else{
        $tiempo = $input_tiempo;
    }

    // Valida observaciones
    $input_observaciones = trim($_POST["observaciones"]);
    if(empty($input_observaciones)){
        $observaciones_err = "Por favor ingrese una observación.";     
    }else{
        $observaciones = $input_observaciones;
    }
    
    // Valida ninguna variable vacia para preparar la query
    if(empty($fecha_err) && empty($descripcion_err) && empty($tiempo_err) && empty($observaciones_err)){
        // ejecuta query
        $sql = "INSERT INTO TAREAS (FECHA_ASIGNACION, DESCRIPCION, TIEMPO_ASIGNADO, OBSERVACIONES) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables preparandolas como parametros
            mysqli_stmt_bind_param($stmt, "ssss", $param_fecha, $param_descripcion, $param_tiempo, $param_observaciones);
            
            // Set parametros
            $param_fecha = $fecha;
            $param_descripcion = $descripcion;
            $param_tiempo= $tiempo;
            $param_observaciones = $observaciones;
            
            // valida la ejecucion 
            if(mysqli_stmt_execute($stmt)){
                // se ejecutó y redirecciona al index.
                header("location: index.php");
                exit();
            } else{
                echo "Algo salio mal.";
            }
        }
         
        // cierra statment
        mysqli_stmt_close($stmt);
    }
    
    // cierra conexion
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cargar Tarea</title>
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
                        <h2 class="titulo text-center">Agregar Tarea</h2>
                    </div>
                    <p>Complete los siguientes datos para agregar una nueva tarea.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($fecha_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha de asignación de la tarea.</label>
                            <input type="text" name="fecha" class="form-control" value="<?php echo $fecha; ?>" placeholder="Fecha">
                            <span class="help-block"><?php echo $fecha_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($descripcion_err)) ? 'has-error' : ''; ?>">
                            <label>Descripcion de la tarea.</label>
                            <textarea name="descripcion" class="form-control" placeholder="Descripcion"><?php echo $descripcion; ?></textarea>
                            <span class="help-block"><?php echo $descripcion_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tiempo_err)) ? 'has-error' : ''; ?>">
                            <label>Tiempo asignado para la tarea(en HS).</label>
                            <input type="text" name="tiempo" class="form-control" value="<?php echo $tiempo; ?>"placeholder="Tiempo Asignado">
                            <span class="help-block"><?php echo $tiempo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($observaciones_err)) ? 'has-error' : ''; ?>">
                            <label>Observaciones.</label>
                            <textarea name="observaciones" class="form-control" placeholder="Observaciones"><?php echo $observaciones; ?></textarea>
                            <span class="help-block"><?php echo $observaciones_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
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