<?php
$dataSelecionada = $_GET['data'];

$conn = new mysqli("localhost", "usuario", "senha", "banco");

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

$sqlOcupados = "SELECT horario FROM agendamentos WHERE data = ?";
$stmtO = $conn->prepare($sqlOcupados);
$stmtO->bind_param("s", $dataSelecionada);
$stmtO->execute();
$resultO = $stmtO->get_result();

$ocupados = [];
while ($row = $resultO->fetch_assoc()) {
    $ocupados[] = $row['horario'];
}

$sqlDesativados = "SELECT horario FROM horarios_desativados WHERE data = ?";
$stmtD = $conn->prepare($sqlDesativados);
$stmtD->bind_param("s", $dataSelecionada);
$stmtD->execute();
$resultD = $stmtD->get_result();

$desativados = [];
while ($row = $resultD->fetch_assoc()) {
    $desativados[] = $row['horario'];
}

echo json_encode([
    "ocupados" => $ocupados,
    "desativados" => $desativados
]);
?>
