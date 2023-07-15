<?php include("../template/cabecera.php") ?>
<?php include("../config/bbdd.php") ?>

<?php
    $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
    $txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
    $txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
    $accion=(isset($_POST['accion']))?$_POST['accion']:"";

    switch ($accion){
        case "Agregar":
            $sentenciaSQL = $conexion->prepare("INSERT INTO libros(nombre, imagen) VALUES(:nombre,:imagen);");
            $sentenciaSQL->bindParam(':nombre',$txtNombre);
            $sentenciaSQL->bindParam(':imagen',$txtImagen);
            $sentenciaSQL->execute();
            break;

        case "Modificar":
            echo"Presionado botón Modificar";
            break;

        case "Cancelar":
            echo"Presionado botón Cancelar";
            break;

        case "Seleccionar":
            echo"Presionado botón Seleccionar";
            break;

        case "Eliminar":
            $sentenciaSQL = $conexion->prepare("DELETE FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            break;
    }
    $sentenciaSQL = $conexion->prepare("SELECT * FROM libros");
    $sentenciaSQL->execute();
    $listaLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

    <div class="col-md-5">

        <div class="card">
            <div class="card-header">
                Dato de libro
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="$txtID">ID: </label>
                        <input id="$txtID" type="text" class="form-control" name="txtID" placeholder="ID" required>
                    </div>

                    <div class="form-group">
                        <label for="txtNombre">Nombre: </label>
                        <input id="txtNombre" type="text" class="form-control" name="txtNombre" placeholder="Nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="txtImagen">Imagen: </label>
                        <input id="txtImagen" type="file" class="form-control" name="txtImagen" placeholder="Imagen" required>
                    </div>

                    <div class="btn-group" role="group" aria-label="">
                        <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                        <button type="submit" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
                        <button type="submit" name="accion" value="Cancelar" class="btn btn-info">Cancelar</button>
                    </div>
                </form>
            </div>

        </div>

    </div>

    <div class="col-md-7">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>IMAGEN</th>
                <th>ACCIONES</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($listaLibros as $libro){?>
            <tr>
                <td><?php echo $libro['id'];?></td>
                <td><?php echo $libro['nombre'];?></td>
                <td><?php echo $libro['imagen'];?></td>
                <td>SELECCIONAR / BORRAR

                    <form method="post">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id'];?>" />
                        <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />
                        <input type="submit" name="accion" value="Eliminar" class="btn btn-danger" />
                    </form>

                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

<?php include("../template/pie.php") ?>