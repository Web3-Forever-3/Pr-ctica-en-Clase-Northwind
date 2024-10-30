<?php
require_once('codes/conexion.inc');
session_start();

if ($_SESSION["autenticado"] != "SI") {
    header("Location:login.php");
    exit();
}

if ((isset($_POST["OC_insertar"])) && ($_POST["OC_insertar"] == "formita")) {
    // Insertar datos de la categoría
    $auxSql = sprintf("INSERT INTO categories(CategoryName, Description) VALUES('%s', '%s')",
        $_POST['txtNombre'],
        $_POST['txtDescrip']);

    $Regis = mysqli_query($conex, $auxSql) or die(mysqli_error($conex));

    // Obtener el ID de la categoría recién insertada
    $categoryId = mysqli_insert_id($conex);

    // Manejo de la imagen
    $archivo = $_FILES["txtArchi"]["tmp_name"];
    $tamanio = $_FILES["txtArchi"]["size"];
    $tipo = $_FILES["txtArchi"]["type"]; //mime
    $nombre = $_FILES["txtArchi"]["name"];

    if ($archivo != "none" && $tamanio > 0) {
        $archi = fopen($archivo, "rb");
        $contenido = fread($archi, $tamanio); // toma los datos/metadata de esa img, ya que en Northwind se piden esos datos para realizar la inserccion
        $contenido = addslashes($contenido);
        fclose($archi);

        // Actualizar la imagen en la base de datos
        $AuxSql = "UPDATE categories SET Imagen='$contenido', Mime='$tipo' WHERE CategoryID = $categoryId";
        $regis = mysqli_query($conex, $AuxSql) or die(mysqli_error($conex));
    } else {
        print "No se puede subir el archivo " . $nombre . " al servidor";
    }

    header("Location: categories.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <?php include_once ('sections/head.inc'); ?>
    <meta http-equiv="refresh" content="180;url=codes/salir.php">
    <title>Create Category</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        function iniImage() {
            $('#txtArchi').change(function (e) {
                addImage(e);
            });
        }

        function addImage(e) {
            var file = e.target.files[0];
            var imageType = /image.*/;

            if (!file.type.match(imageType))
                return;
            var reader = new FileReader();
            reader.onload = function (e) {
                var result = e.target.result;
                $('#imgSalida').attr("src", result);
            }
            reader.readAsDataURL(file);
        }
    </script>
</head>
<body class="container-fluid" onLoad="iniImage()">
<header class="row">
    <?php include_once ('sections/header.inc'); ?>
</header>

<main class="row contenido">
    <div class="card tarjeta">
        <div class="card-header">
            <h4 class="card-title">Insertar Categoría</h4>
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data" name="formita" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <table class="table table-bordered">
                    <tr>
                        <td><strong>Nombre</strong></td>
                        <td><input type="text" name="txtNombre" size="15" maxlength="15" required></td>
                    </tr>
                    <tr>
                        <td><strong>Descripción</strong></td>
                        <td><input type="text" name="txtDescrip" size="50" maxlength="50" required></td>
                    </tr>
                    <tr>
                        <td><strong>Imagen</strong></td>
                        <td><input type="file" name="txtArchi" id="txtArchi" required></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <img id="imgSalida" src="" alt="Imagen Previa" style="max-width: 200px; max-height: 200px; display: none;">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" value="Aceptar">
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="OC_insertar" value="formita">
            </form>
        </div>
    </div>
</main>

<footer class="row pie">
    <?php include_once ('sections/foot.inc'); ?>
</footer>
</body>
</html>
