<?php
$host     = '127.0.0.1';
$port     = '5432';
$db       = 'hotel';
$user     = 'postgres'; // O tu usuario de Postgres configurado
$password = '';         // Tu contraseña de Postgres (o vacía si usas ident/trust)

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Error al conectar a PostgreSQL: " . $e->getMessage());
}