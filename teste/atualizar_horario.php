<?php
$conn = new mysqli("localhost", "usuario", "senha", "banco");

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

$data = $_POST['data'];
$horario = $_POST['horario'];
$acao = $_POST['acao'];

$sqlCheck = "SELECT * FROM horarios_desativados WHERE data = ? AND horario = ?";
$stmt = $conn->prepare($sqlCheck);
$stmt->bind_param("ss", $data, $horario);
$stmt->execute();
$result = $stmt->get_result();

if ($acao === 'desativar' && $result->num_rows === 0) {
    $sql = "INSERT INTO horarios_desativados (data, horario) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $data, $horario);
    $stmt->execute();
} elseif ($acao === 'ativar' && $result->num_rows > 0) {
    $sql = "DELETE FROM horarios_desativados WHERE data = ? AND horario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $data, $horario);
    $stmt->execute();
}

$conn->close();
?>
