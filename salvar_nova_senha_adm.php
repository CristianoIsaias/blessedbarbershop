<?php
include_once('config.php');

if (isset($_POST['email']) && isset($_POST['nova_senha'])) {
    $email = $_POST['email'];
    $novaSenha = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT); // segura

    $sql = "UPDATE cadastro SET senha = '$novaSenha' WHERE email = '$email'";
    if (mysqli_query($conexao, $sql)) {
        echo "<h2>Senha atualizada com sucesso!</h2>";
        
    } else {
        echo "Erro ao atualizar a senha.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylerecuperar.css">
    <title>Salvar nova senha</title>
</head>
<body>
    <a href="controle.php" style="color=red">Voltar</a>

    
</body>
</html>
