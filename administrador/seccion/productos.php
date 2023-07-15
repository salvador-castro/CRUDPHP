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

            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

            $tmpImagen = $_FILES["txtImagen"]["tmp_name"];

            if($tmpImagen!=""){
                move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
            }

            $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
            $sentenciaSQL->execute();
            break;

        case "Modificar":
            $sentenciaSQL = $conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id=:id");
            $sentenciaSQL->bindParam(':nombre',$txtNombre);
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();

            if($txtImagen!=""){
                $sentenciaSQL = $conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
                $sentenciaSQL->bindParam(':imagen',$txtImagen);
                $sentenciaSQL->bindParam(':id',$txtID);
                $sentenciaSQL->execute();
            }

            break;

        case "Cancelar":
            echo"Presionado botón Cancelar";
            break;

        case "Seleccionar":
            $sentenciaSQL = $conexion->prepare("SELECT * FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
            $txtNombre = $libro['nombre'];
            $txtImagen = $libro['imagen'];
            break;

        case "Eliminar":

            $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if(isset($libro["imagen"]) && ($libro["imagen"]!="imagen.jpg")){
                if(file_exists("../../img/".$libro["imagen"])){
                    unlink("../../img/".$libro["imagen"]);
                }
            }

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
                        <input id="$txtID" type="text" class="form-control" name="txtID" placeholder="ID" value="<?php echo $txtID;?>" />
                    </div>

                    <div class="form-group">
                        <label for="txtNombre">Nombre: </label>
                        <input id="txtNombre" type="text" class="form-control" name="txtNombre" placeholder="Nombre" value="<?php echo $txtNombre;?>" />
                    </div>

                    <div class="form-group">
                        <label for="txtImagen">Imagen: </label>
                        <?php echo $txtImagen;?>
                        <input id="txtImagen" type="file" class="form-control" name="txtImagen" placeholder="Imagen" />
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
                <td>

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