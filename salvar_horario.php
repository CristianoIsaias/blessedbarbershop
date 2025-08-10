<?php
$conn = new mysqli("localhost", "usuario", "senha", "seubanco");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $horario = $_POST['horario'];
    $acao = $_POST['acao']; // "ativar" ou "desativar"

    if ($acao === 'desativar') {
        $stmt = $conn->prepare("INSERT IGNORE INTO horarios_desativados (horario) VALUES (?)");
        $stmt->bind_param("s", $horario);
        $stmt->execute();
    } elseif ($acao === 'ativar') {
        $stmt = $conn->prepare("DELETE FROM horarios_desativados WHERE horario = ?");
        $stmt->bind_param("s", $horario);
        $stmt->execute();
    }

    echo json_encode(['success' => true]);
}
