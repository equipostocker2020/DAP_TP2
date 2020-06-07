<?php  
//CONECTAMOS CON LA BBDD


$conexion = new mysqli("localhost", "root", "", "discografica");
if ($conexion->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
}
$sql="SELECT idartistas,nombre from artistas";
$result = $conexion->query($sql);

if ($result->num_rows > 0) //si la variable tiene al menos 1 fila entonces seguimos con el codigo
{
    $combobit="";
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
    {
        $combobit .=" <option value='".$row['nombre']."'>".$row['idartistas']."</option>"; 
    }
}
else
{
    echo "No hubo resultados";
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
    <div class="container">

      <form method="post" role="form" action="insertarcancion.php" >
        <div class="form-group row" action="insertarcancion.php">

                <label for="nombre" class="col-sm-2 form-control-label">artista</label>
                <input    class="form-control" id="artista" placeholder="Escribe tu nombre" type="text" name="nombre">
                <select name="estado">
                    <?php echo $combobit; ?>

                </select>
            </div>
        <div class="form-group row" action="insertarartista.php">
            <label for="nombre" class="col-sm-2 form-control-label">Nombre</label>
                <div class="col-sm-10">
                <input class="form-control" id="nombre" placeholder="Escribe tu nombre" type="text" name="nombre">
                </div>
        </div>

        </div>
        <center>
        <div class="form-group">
          <button type="submit" class="btn btn-primary offset-2">Enviar</button>
        </div>
        </center>
      </form>
    </div>
   
  </body>
<footer class="page-footer font-small blue">
            <div class="footer-copyright text-center py-3">© 2020 Copyright:
                <p class="decorado">Figueras Gonzalo, Galarza Agustin, Gutierrez Marcelo</p>
            </div>

</footer>
</html>
