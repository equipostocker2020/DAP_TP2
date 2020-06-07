<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
    <h2 class="titulo text-center">DESARROLLO DE APLICACIONES WEB SEGUNDO TP</h2>
    <hr>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left ">Visualizador de Tareas.</h2>
                        <a href="create.php" class="btn btn-success pull-right">Agregar nueva tarea</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // query para traer todas las tareas
                    $sql = "SELECT * FROM TAREAS";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Fecha</th>";
                                        echo "<th>Descripcion</th>";
                                        echo "<th>Tiempo Asignado(hs)</th>";
                                        echo "<th>Observaciones</th>";
                                        echo "<th>Integrante</th>";
                                        echo "<th>Acción</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['ID_TAREA'] . "</td>";
                                        echo "<td>" . $row['FECHA_ASIGNACION'] . "</td>";
                                        echo "<td>" . $row['DESCRIPCION'] . "</td>";
                                        echo "<td>" . $row['TIEMPO_ASIGNADO'] . "</td>";
                                        echo "<td>" . $row['OBSERVACIONES'] . "</td>";
                                        echo "<td>" . $row['INTEGRANTE'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='read.php?id=". $row['ID_TAREA'] ."' title='Ver' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='update.php?id=". $row['ID_TAREA'] ."' title='Actualizar' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete.php?id=". $row['ID_TAREA'] ."' title='Borrar' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // seteando free_result
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // cerrando conexion
                    mysqli_close($link);
                    ?>
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