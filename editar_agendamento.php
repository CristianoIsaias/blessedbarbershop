<?php
include_once('config.php');

if (!isset($_GET['codigo'])) {
    echo "ID do agendamento não informado!";
    exit;
}

$codigo = $_GET['codigo'];

// Busca os dados do agendamento com cliente
$sql = "SELECT 
            finalidade.codigo,
            finalidade.penteado,
            finalidade.data,
            finalidade.time,
            cadastro.codigo_id,
            cadastro.nome,
            cadastro.email,
            cadastro.telefone
        FROM finalidade
        INNER JOIN cadastro ON finalidade.usuario_id = cadastro.codigo_id
        WHERE finalidade.codigo = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $codigo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Agendamento não encontrado!";
    exit;
}

$dados = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/styleeditar.css">
    <title>Editar Agendamento</title>
</head>
<body>
    <div class="caixa-form">
    <h2>Editar Agendamento</h2>
    <form action="atualizar_agendamento.php" method="POST">
        <!-- IDs ocultos -->
        <input type="hidden" name="codigo" value="<?= $dados['codigo'] ?>">
        <input type="hidden" name="codigo_id" value="<?= $dados['codigo_id'] ?>">

        <!-- Dados do Cliente -->
        
        <input type="text" placeholder="Nome" name="nome" value="<?= htmlspecialchars($dados['nome']) ?>" required><br><br>
        <input type="email" placeholder="E-mail"name="email" value="<?= htmlspecialchars($dados['email']) ?>" required><br><br>
        <input type="text" placeholder="Telefone" name="telefone" value="<?= htmlspecialchars($dados['telefone']) ?>" required><br><br>
        <!-- Dados do Agendamento -->
        <input type="text" placeholder="penteado"name="penteado" value="<?= htmlspecialchars($dados['penteado']) ?>" required><br><br>
        <input type="date"placeholder="data" name="data" value="<?= $dados['data'] ?>" required><br><br>
        <input type="time" placeholder="time"name="time" value="<?= $dados['time'] ?>" required><br><br>
        <input type="submit"value="Salvar"id="botao-agendamento">
        <!-- <a href="listar.php">Cancelar</a> -->
    </form>
    </div>
</body>
</html>
