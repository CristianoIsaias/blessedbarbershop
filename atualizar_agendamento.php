<?php
include_once('config.php');

if (
    isset($_POST['codigo']) &&
    isset($_POST['codigo_id']) &&
    isset($_POST['nome']) &&
    isset($_POST['email']) &&
    isset($_POST['telefone']) &&
    isset($_POST['penteado']) &&
    isset($_POST['data']) &&
    isset($_POST['time'])
) {
    $codigo = $_POST['codigo'];
    $codigo_id = $_POST['codigo_id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $penteado = $_POST['penteado'];
    $data = $_POST['data'];
    $time = $_POST['time'];

    // Atualiza tabela "cadastro"
    $sql1 = "UPDATE cadastro SET nome = ?, email = ?, telefone = ? WHERE codigo_id = ?";
    $stmt1 = $conexao->prepare($sql1);

    // Atualiza tabela "finalidade"
    $sql2 = "UPDATE finalidade SET penteado = ?, data = ?, time = ? WHERE codigo = ?";
    $stmt2 = $conexao->prepare($sql2);

    if ($stmt1 && $stmt2) {
        $stmt1->bind_param("sssi", $nome, $email, $telefone, $codigo_id);
        $stmt2->bind_param("sssi", $penteado, $data, $time, $codigo);

        $ok1 = $stmt1->execute();
        $ok2 = $stmt2->execute();

        if ($ok1 && $ok2) {
            echo "<script>alert('✅ Dados atualizados com sucesso!'); window.location.href = 'lista.php';</script>";
        } else {
            echo "<script>alert('❌ Erro ao atualizar: " . $stmt1->error . " / " . $stmt2->error . "'); window.history.back();</script>";
        }

        $stmt1->close();
        $stmt2->close();
    } else {
        echo "Erro ao preparar uma das consultas.";
    }

    $conexao->close();
} else {
    echo "<script>alert('❌ Dados incompletos.'); window.history.back();</script>";
}
