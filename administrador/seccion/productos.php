<?php include("../template/cabecera.php") ?>

    <div class="col-md-5">

        <div class="card">
            <div class="card-header">
                Dato de libro
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="textID">ID: </label>
                        <input id="textID" type="text" class="form-control" name="txtID" placeholder="ID" required>
                    </div>

                    <div class="form-group">
                        <label for="txtNombre">Nombre: </label>
                        <input id="txtNombre" type="text" class="form-control" name="txtNombre" placeholder="Nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="txtImagen">Imagen: </label>
                        <input id="txtImagen" type="file" class="form-control" name="txtNombre" placeholder="Imagen" required>
                    </div>

                    <div class="btn-group" role="group" aria-label="">
                        <button type="button" class="btn btn-success">Agregar</button>
                        <button type="button" class="btn btn-warning">Modificar</button>
                        <button type="button" class="btn btn-info">Cancelar</button>
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
            <tr>
                <td>2</td>
                <td>APRENDE PHP</td>
                <td>IMAGEN.JPG</td>
                <td>SELECCIONAR / BORRAR</td>
            </tr>
            </tbody>
        </table>
    </div>

<?php include("../template/pie.php") ?>