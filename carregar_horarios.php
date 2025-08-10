<?php

session_start();
include_once "config.php";

$dataSelecionada = $_GET['data'];



// Horários ocupados (ex: agendamentos existentes)
$sqlOcupados = "SELECT horario FROM agendamentos WHERE data = ?";
$stmtO = $conn->prepare($sqlOcupados);
$stmtO->bind_param("s", $dataSelecionada);
$stmtO->execute();
$resultO = $stmtO->get_result();

$ocupados = [];
while ($row = $resultO->fetch_assoc()) {
    $ocupados[] = $row['horario'];
}

// Horários desativados manualmente
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
