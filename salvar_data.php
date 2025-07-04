<?php
session_start();
include_once "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['data'])) {
    $data = $_POST['data'];

    // Verifica se a data está no formato correto
    $dataObj = DateTime::createFromFormat('Y-m-d', $data);
    if (!$dataObj || $dataObj->format('Y-m-d') !== $data) {
        echo "<script>alert('Data inválida ou em formato incorreto. Use AAAA-MM-DD'); window.history.back();</script>";
        exit;
    }

    // Salvando no banco (coloque valores padrões para os campos adicionais)
    $time = "00:00"; // Valor temporário se você não tiver ainda
    $penteado = "Não informado"; // Valor temporário

    $stmt = mysqli_prepare($conexao, "INSERT INTO finalidade (data, time, penteado) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $data, $time, $penteado);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Data salva com sucesso!'); window.location.href='horario.php';</script>";
    } else {
        echo "<script>alert('Erro ao salvar data.'); window.history.back();</script>";
    }
}



$datasSalvas = [];
$result = mysqli_query($conexao, "SELECT data FROM finalidade");

while ($row = mysqli_fetch_assoc($result)) {
    $datasSalvas[] = $row['data']; // formato Y-m-d
}
?>
