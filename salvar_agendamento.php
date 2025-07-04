<?php
include_once('config.php');
session_start();

// Verifica se está logado
if (!isset($_SESSION['codigo_id'])) {
    echo "Usuário não está logado!";
    exit();
}

// Verifica se os dados foram enviados
if (isset($_POST['penteado']) && isset($_POST['data']) && isset($_POST['time'])) {
    $penteado = $_POST['penteado'];
    $data = $_POST['data'];
    $time = $_POST['time'];
    $usuario_id = $_SESSION['codigo_id'];

    // Insere no banco de dados
    $sql = "INSERT INTO finalidade (penteado, data, time, usuario_id) VALUES (?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssi", $penteado, $data, $time, $usuario_id);

    if ($stmt->execute()) {
        echo "Agendamento salvo com sucesso!";
    } else {
        echo "Erro ao salvar: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Dados incompletos para salvar o agendamento.";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento</title>
</head>
<body></body>
<form method="POST" action="salvar_agendamento.php">
    <label>Tipo de Penteado:</label>
    <input type="text" name="penteado" required>

    <label>Data:</label>
    <input type="date" name="data" required>

    <label>Hora:</label>
    <input type="time" name="time" required>

    <input type="submit" value="Salvar Agendamento">
</form>


    
</body>
</html>