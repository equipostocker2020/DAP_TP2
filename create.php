<?php
// Include config file
require_once "config.php";
 
// Define variables e inicializa todas vacías
$fecha = $descripcion = $tiempo = $integrante = $observaciones = "";
$fecha_err = $descripcion_err = $tiempo_err = $integrante_err = $observaciones_err = "";
 
// Procesa datos cuando se envia el formulario
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate fecha
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
        $tiempo_err = "Por favor ingrese el monto del salario del empleado.";     
    } elseif(!ctype_digit($input_tiempo)){
        $tiempo_err = "Por favor ingrese un valor correcto y positivo.";
    } else{
        $tiempo = $input_tiempo;
    }

    // Valida observaciones
    $input_observaciones = trim($_POST["observaciones"]);
    if(empty($input_observaciones)){
        $observaciones = $input_observaciones;
    }
    
    // Check input errors before inserting in database
    if(empty($fecha_err) && empty($descripcion_err) && empty($tiempo_err) && empty($observaciones_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (FECHA_ASIGNACION, DESCRIPCION, TIEMPO_ASIGNADO, INTEGRANTE, OBSERVACIONES) VALUES (?, ?, ?, ? , ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_fecha, $param_descripcion, $param_tiempo, $param_itegrante, $param_observaciones);
            
            // Set parameters
            $param_fecha = $fecha;
            $param_descripcion = $descripcion;
            $param_tiempo= $tiempo;
            $param_integrante = $integrante;
            $param_observaciones = $observaciones;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cargar Tarea</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
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
                        <h2>Agregar Tarea</h2>
                    </div>
                    <p>Complete los siguientes datos para agregar una nueva tarea.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($fecha_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha de asignación de la tarea.</label>
                            <input type="text" name="fecha" class="form-control" value="<?php echo $fecha; ?>">
                            <span class="help-block"><?php echo $fecha_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($descripcion_err)) ? 'has-error' : ''; ?>">
                            <label>Descripcion de la tarea.</label>
                            <textarea name="descripcion" class="form-control"><?php echo $descripcion; ?></textarea>
                            <span class="help-block"><?php echo $descripcion_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tiempo_err)) ? 'has-error' : ''; ?>">
                            <label>Tiempo asignado para la tarea.</label>
                            <input type="text" name="tiempo" class="form-control" value="<?php echo $tiempo; ?>">
                            <span class="help-block"><?php echo $tiempo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($integrante_err)) ? 'has-error' : ''; ?>">
                            <label>Integrante asignado para la tarea.</label>
                            <input type="text" name="integrante" class="form-control" value="<?php echo $integrante; ?>">
                            <span class="help-block"><?php echo $integrante_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($observaciones_err)) ? 'has-error' : ''; ?>">
                            <label>Observaciones.</label>
                            <textarea name="observaciones" class="form-control"><?php echo $observaciones; ?></textarea>
                            <span class="help-block"><?php echo $observaciones_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>