<?php
require_once 'db.php';

// Consultar usuarios para el <select>
$stmt = $pdo->query("SELECT id, nombres, apellidos FROM usuarios ORDER BY nombres ASC");
$usuarios = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel El Mirador de Cortaderas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width: 650px;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h4 class="fw-bold text-secondary">EL MIRADOR DE CORTADERAS</h4>
                <p class="text-muted small">Módulo de Reservas</p>
            </div>

            <form action="procesar_reserva.php" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Elige usuario:</label>
                    <div class="input-group">
                        <select name="usuario_id" class="form-select" required>
                            <option value="">-- Seleccionar Usuario --</option>
                            <?php foreach ($usuarios as $u): ?>
                                <option value="<?= $u['id'] ?>">
                                    <?= htmlspecialchars($u['nombres'] . ' ' . $u['apellidos']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <a href="nuevo_usuario.php" class="btn btn-outline-secondary">Crear usuario</a>
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Habitación:</label>
                        <select name="habitacion" class="form-select" required>
                            <option value="Simple">Simple</option>
                            <option value="Doble">Doble</option>
                            <option value="Matrimonial">Matrimonial</option>
                            <option value="Suite">Suite</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">N° de Huéspedes:</label>
                        <input type="number" name="huespedes" class="form-control" min="1" value="1" required>
                    </div>
                </div>

                <div class="row g-2 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Fecha de Entrada:</label>
                        <input type="date" name="fechaingreso" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Noches:</label>
                        <input type="number" name="noches" class="form-control" min="1" value="1" required>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Reservar</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>