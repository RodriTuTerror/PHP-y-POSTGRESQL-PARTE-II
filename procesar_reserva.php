<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$usuario_id   = (int)$_POST['usuario_id'];
$habitacion   = $_POST['habitacion'];
$huespedes    = (int)$_POST['huespedes'];
$fechaingreso = $_POST['fechaingreso'];
$noches       = (int)$_POST['noches'];

// 1. Insertar la reserva asegurando la integridad referencial con PostgreSQL
$stmt = $pdo->prepare("INSERT INTO reservas (usuario_id, habitacion, huespedes, fechaingreso, noches) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$usuario_id, $habitacion, $huespedes, $fechaingreso, $noches]);

// 2. Traer los datos combinados con un INNER JOIN
$stmtDetalle = $pdo->prepare("
    SELECT r.*, u.nombres, u.apellidos, u.dni, u.celular 
    FROM reservas r 
    INNER JOIN usuarios u ON r.usuario_id = u.id 
    WHERE r.id = (SELECT MAX(id) FROM reservas WHERE usuario_id = ?)
");
$stmtDetalle->execute([$usuario_id]);
$reserva = $stmtDetalle->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de Reserva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width: 500px;">
        <div class="card-header bg-primary text-white text-center">
            <h5 class="mb-0">Datos de la Reserva</h5>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item"><strong>Habitación:</strong> <?= htmlspecialchars($reserva['habitacion']) ?></li>
                <li class="list-group-item"><strong>Nombres:</strong> <?= htmlspecialchars($reserva['nombres']) ?></li>
                <li class="list-group-item"><strong>Apellidos:</strong> <?= htmlspecialchars($reserva['apellidos']) ?></li>
                <li class="list-group-item"><strong>DNI:</strong> <?= htmlspecialchars($reserva['dni']) ?></li>
                <li class="list-group-item"><strong>Celular:</strong> <?= htmlspecialchars($reserva['celular']) ?></li>
                <li class="list-group-item"><strong>Fecha de Entrada:</strong> <?= htmlspecialchars($reserva['fechaingreso']) ?></li>
                <li class="list-group-item"><strong>Noches:</strong> <?= htmlspecialchars($reserva['noches']) ?></li>
                <li class="list-group-item"><strong>Huéspedes:</strong> <?= htmlspecialchars($reserva['huespedes']) ?></li>
            </ul>
            <div class="d-grid">
                <a href="index.php" class="btn btn-success">Completar Reserva</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>