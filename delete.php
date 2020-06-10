<?php
// Procesando el delte
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include config file
    require_once "config.php";
    // Preparando la query para eliminar
    $sql = "DELETE FROM TAREAS WHERE ID_TAREA = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind a la variable.
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        // Seteando parametros
        $param_id = trim($_POST["id"]);
        // Intenta ejecutar
        if(mysqli_stmt_execute($stmt)){
            // Proceso OK, redirecciona
            header("location: index.php");
            exit();
        } else{
            echo "Error, tuvimos un inconveniente al procesar la peticion, intente mas tarde.";
        }
    }
    // cerrando statment
    mysqli_stmt_close($stmt);
    // cerrando conexion
    mysqli_close($link);
} else{
    // chequeando el parametro "id" exista
    if(empty(trim($_GET["id"]))){
        // la URL no encuentra el id, redireccionando a la page del error.
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrar</title>
    <link rel="stylesheet" href="styles.css">
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
                        <h1>Borrar Registro</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Está seguro que deseas borrar el registro</p><br>
                            <p>
                                <input type="submit" value="Si" class="btn btn-danger">
                                <a href="index.php" class="btn btn-default">No</a>
                            </p>
                        </div>
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