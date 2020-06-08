<?php
// Include del archivo config 
require_once "config.php";
 
// Defino variables
$fechaAsignacion = date ("Y-m-d");
$descripcion = $tiempoAsignado = $observaciones = $integrantes = "";
$descripcion_err = $tiempoAsignado_err = $fechaAsignacion_err = $integrantes_err = "";
 

$conexion = new mysqli("localhost", "root", "", "tp2_desa_app_web");
if ($conexion->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
}
$sql="SELECT ID_INTEGRANTE,NOMBRE from INTEGRANTES";
$result = $conexion->query($sql);

if ($result->num_rows > 0) //si la variable tiene al menos 1 fila entonces seguimos con el codigo
{
    $combobit="";
    $nombre ="";
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
    {
        $combobit .=" <option value='".$row['ID_INTEGRANTE']."'>".$row['NOMBRE']."</option>"; 
    }
}
else
{
    echo "No hubo resultados";
}

// Verifica que no se repita el id para poder hacer un post
if(isset($_POST["id"]) && !empty($_POST["id"])){
    //toma el id
    $id = $_POST["id"];
    

    // Validate descripcion
    $input_descripcion = trim($_POST["descripcion"]);
    if(empty($input_descripcion)){
        $descripcion_err = "Por favor ingrese una descripcion de la tarea.";     
    } else{
        $descripcion = $input_descripcion;
    }
       
    // Validate iempoAsignado
    $input_tiempoAsignado = trim($_POST["tiempoAsignado"]);
    if(empty($input_tiempoAsignado)){
        $tiempoAsignado_err = "Por favor ingrese el tiempo asignado (hs).";
    } else{
        $tiempoAsignado = $input_tiempoAsignado;
    }
    
    // Validate fechaAsignacion
    $input_fechaAsignacion = trim($_POST["fechaAsignacion"]);
    if(empty($input_fechaAsignacion)){
        $fechaAsignacion_err = "Por favor ingrese la fecha de asignacion.";     
    } else{
        $fechaAsignacion = $input_fechaAsignacion;
    }
    
    // Validate observaciones
    $input_observaciones = trim($_POST["observaciones"]);
    if(empty($input_descripcion)){
        $observaciones = " ";
    }else{  
        $observaciones = $input_observaciones;
    }

    $input_integrantes = trim($_POST["integrantes"]);
    if(empty($input_integrantes)){
        $integrantes_err = "Por favor ingrese un integrante.";     
    }else{
        $integrantes = $input_integrantes;
    }


    // chequea si los errores estan basios para seguir
    if(empty($descripcion_err) && empty($tiempoAsignado_err) && empty($fechaAsignacion_err)&& empty($integrantes_err)){
        // prepara un update statement
        $sql = "UPDATE TAREAS SET FECHA_ASIGNACION=?, DESCRIPCION=?, TIEMPO_ASIGNADO=?, INTEGRANTE=?,OBSERVACIONES=? WHERE ID_TAREA=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // brinda variables al prepared statement porparametros
            mysqli_stmt_bind_param($stmt, "sssssi", $param_fechaAsignacion, $param_descripcion, 
            $param_tiempoAsignado, $param_integrante , $param_observaciones, $param_id);
            
            // Set parametros
            $param_fechaAsignacion = $fechaAsignacion;
            $param_descripcion = $descripcion;
            $param_tiempoAsignado = $tiempoAsignado;
            $param_observaciones = $observaciones;
            $param_integrante = $integrantes;
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                // hace el update y redirecciona a la sieguiente pagina
                header("location: index.php");
                exit();
            } else{
                echo "Algo salió mal. Por favor, inténtelo de nuevo más tarde.";
            }
        }
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_close($stmt);
        } else {
            echo "Algo está mal con la consulta:" . mysqli_error($link);
        }
    }
    
    // Cierra la conexion
    mysqli_close($link);


} else{
    // Chequea la existencia de los datos para hacer un get
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // un Get de el id de la tabla
        $id =  trim($_GET["id"]);
        
        // Crea el Query select de tipo statement
        $sql = "SELECT * FROM TAREAS WHERE ID_TAREA = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // brinda bariables al prepared statement por parametros
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /*Obtener la fila de resultados como una matriz asociativa. Desde el conjunto de resultados
                      contiene solo una fila, no necesitamos usar while loop*/
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Recupera valores
                    $fechaAsignacion = $row["FECHA_ASIGNACION"];
                    $descripcion = $row["DESCRIPCION"];
                    $tiempoAsignado = $row["TIEMPO_ASIGNADO"];
                    $observaciones = $row["OBSERVACIONES"];
                    $integrantes = $row["INTEGRANTE"];
                   
            
                } else{
                    //Si no valida el id redirecciona a la pagina error
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "¡Uy! Algo salió mal. Por favor, inténtelo de nuevo más tarde.";
            }
        }
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_close($stmt);
        } else {
            echo "Algo está mal con la consulta:" . mysqli_error($link);
        }
        
        // Cierra connection
        mysqli_close($link);
    }  else{
        //Si no valida el id redirecciona a la pagina error
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Registro</title>
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
                        <h2 class="titulo text-center">Actualizar Registro</h2>
                    </div>
                    <p>Edite los valores de entrada y envíe para actualizar el registro.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($fechaAsignacion_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha Asiganación</label>
                            <input type="date" name="fechaAsignacion" class="form-control" value="<?php echo $fechaAsignacion; ?>">
                            <span class="help-block"><?php echo $fechaAsignacion_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($descripcion_err)) ? 'has-error' : ''; ?>">
                            <label>Descripción</label>
                            <textarea name="descripcion" class="form-control"><?php echo $descripcion; ?></textarea>
                            <span class="help-block"><?php echo $descripcion_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tiempoAsignado_err)) ? 'has-error' : ''; ?>">
                            <label>Tiempo Asignado</label>
                            <input type="text" name="tiempoAsignado" class="form-control" value="<?php echo $tiempoAsignado; ?>">
                            <span class="help-block"><?php echo $tiempoAsignado_err;?></span>
                        </div>
                        <div class="form-group ">
                            <label>Observaciones</label>
                            <input type="text" name="observaciones" class="form-control" value="<?php echo $observaciones; ?>">
                        </div>
                        <div class="form-group">
                        <label>Integrantes</label>
                        <select name="integrantes" class="form-control" placeholder="integrantes">
                        <option selected="selected" disabled="disabled">Seleccione integrante...</option>
                            <?php echo $combobit; ?>
                        </select>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
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

