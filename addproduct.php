<?php
require_once('codes/conexion.inc'); 
session_start();


if ($_SESSION["autenticado"] != "SI") {
    header("Location: login.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') { //esto son datos que pide northwind
    // Obtener los datos del formulario
    $productName = $_POST['txtNombre'];
    $supplierId = $_POST['supplierId']; // ID del proveedor
    $quantityPerUnit = $_POST['txtCantidadPorUnidad']; // Cantidad por unidad
    $unitPrice = $_POST['txtPrecioUnitario']; // Precio por unidad
    $unitsInStock = $_POST['txtUnidadesEnStock']; // Unidades en stock
    $unitsOnOrder = $_POST['txtUnidadesEnPedido']; // Unidades en pedido
    $reorderLevel = $_POST['txtNivelDeReorden']; // Nivel de reorden
    $discontinued = isset($_POST['chkDescontinuado']) ? 1 : 0; // Descontinuado (1 = sí, 0 = no)
    $categoryId = $_POST['categoryId']; // ID de la categoría

    // Preparar la consulta SQL para insertar el producto
    $insertSql = sprintf(
        "INSERT INTO products (ProductName, SupplierID, QuantityPerUnit, UnitPrice, UnitsInStock, UnitsOnOrder, ReorderLevel, Discontinued, CategoryID) 
        VALUES ('%s', '%d', '%s', '%f', '%d', '%d', '%d', '%d', '%d')",
        mysqli_real_escape_string($conex, $productName),
        mysqli_real_escape_string($conex, $supplierId),
        mysqli_real_escape_string($conex, $quantityPerUnit),
        mysqli_real_escape_string($conex, $unitPrice),
        mysqli_real_escape_string($conex, $unitsInStock),
        mysqli_real_escape_string($conex, $unitsOnOrder),
        mysqli_real_escape_string($conex, $reorderLevel),
        mysqli_real_escape_string($conex, $discontinued),
        mysqli_real_escape_string($conex, $categoryId)
    );

    // Ejecutar la consulta SQL
    if (mysqli_query($conex, $insertSql)) {
        header("Location: lstproductos.php?cod=" . $categoryId); // Redirigir a la lista de productos
        exit();
    } else {
        echo "Error: " . mysqli_error($conex); // Mostrar error en caso de falla
    }
}
?>

<!doctype html>
<html lang="es">
<head>
    <title>Agregar Producto</title>
    <?php include_once('sections/head.inc'); ?>
    <style>
        /* Estilo adicional para centrar el formulario */
        .centered-form {
            max-width: 600px; /* Ancho máximo del formulario */
            margin: auto; /* Centrar horizontalmente */
        }
    </style>
</head>
<body class="container mt-5">
    <h2 class="mb-4 text-center">Agregar Producto</h2>
    <div class="centered-form">
        <form method="POST" action="" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="txtNombre" class="form-label">Nombre del Producto:</label>
                <input type="text" class="form-control" name="txtNombre" required>
                <div class="invalid-feedback">Por favor, introduce el nombre del producto.</div>
            </div>

            <div class="mb-3">
                <label for="supplierId" class="form-label">ID del Proveedor:</label>
                <input type="number" class="form-control" name="supplierId" required>
                <div class="invalid-feedback">Por favor, introduce el ID del proveedor.</div>
            </div>

            <div class="mb-3">
                <label for="txtCantidadPorUnidad" class="form-label">Cantidad por Unidad:</label>
                <input type="text" class="form-control" name="txtCantidadPorUnidad" required>
                <div class="invalid-feedback">Por favor, introduce la cantidad por unidad.</div>
            </div>

            <div class="mb-3">
                <label for="txtPrecioUnitario" class="form-label">Precio Unitario:</label>
                <input type="number" step="0.01" class="form-control" name="txtPrecioUnitario" required>
                <div class="invalid-feedback">Por favor, introduce el precio unitario.</div>
            </div>

            <div class="mb-3">
                <label for="txtUnidadesEnStock" class="form-label">Unidades en Stock:</label>
                <input type="number" class="form-control" name="txtUnidadesEnStock" required>
                <div class="invalid-feedback">Por favor, introduce las unidades en stock.</div>
            </div>

            <div class="mb-3">
                <label for="txtUnidadesEnPedido" class="form-label">Unidades en Pedido:</label>
                <input type="number" class="form-control" name="txtUnidadesEnPedido">
            </div>

            <div class="mb-3">
                <label for="txtNivelDeReorden" class="form-label">Nivel de Reorden:</label>
                <input type="number" class="form-control" name="txtNivelDeReorden">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="chkDescontinuado" id="chkDescontinuado">
                <label class="form-check-label" for="chkDescontinuado">Descontinuado</label>
            </div>

            <input type="hidden" name="categoryId" value="<?php echo $_GET['cod']; ?>">

            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
    </div>

    <!-- Bootstrap JS (Opcional para validación y otros componentes) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Ejemplo de validación del formulario
        (function () {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>
