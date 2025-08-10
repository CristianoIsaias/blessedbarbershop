<?php
// Conexão com o banco de dados
session_start();
include_once "config.php";

$data = $_POST['data'];      // Ex: 2025-07-30
$horario = $_POST['horario']; // Ex: 15:00
$acao = $_POST['acao'];      // "ativar" ou "desativar"

// Verifica se já existe
$sqlCheck = "SELECT * FROM horarios_desativados WHERE data = ? AND horario = ?";
$stmt = $conn->prepare($sqlCheck);
$stmt->bind_param("ss", $data, $horario);
$stmt->execute();
$result = $stmt->get_result();

if ($acao === 'desativar' && $result->num_rows === 0) {
    // Inserir novo horário desativado
    $sql = "INSERT INTO horarios_desativados (data, horario) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $data, $horario);
    $stmt->execute();
} elseif ($acao === 'ativar' && $result->num_rows > 0) {
    // Remover horário desativado
    $sql = "DELETE FROM horarios_desativados WHERE data = ? AND horario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $data, $horario);
    $stmt->execute();
}

$conn->close();
?>
