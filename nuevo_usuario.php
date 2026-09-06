<?php
require_once 'db.php';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres   = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $dni       = trim($_POST['dni']);
    $celular   = trim($_POST['celular']);

    if (!empty($nombres) && !empty($apellidos) && !empty($dni)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombres, apellidos, dni, celular) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nombres, $apellidos, $dni, $celular]);
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $mensaje = "Error al registrar: DNI duplicado o datos inválidos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width: 500px;">
        <div class="card-body p-4">
            <h4 class="card-title text-center mb-3">Registrar Nuevo Huésped</h4>
            <?php if ($mensaje): ?>
                <div class="alert alert-danger"><?= $mensaje ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-2">
                    <label class="form-label">Nombres:</label>
                    <input type="text" name="nombres" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Apellidos:</label>
                    <input type="text" name="apellidos" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">DNI:</label>
                    <input type="text" name="dni" maxlength="8" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Celular:</label>
                    <input type="text" name="celular" class="form-control" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Completar Registro</button>
                    <a href="index.php" class="btn btn-link text-secondary">Volver</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>