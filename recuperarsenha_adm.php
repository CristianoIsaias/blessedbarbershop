<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylerecuperar.css">
    <title>Recuperação de Senha</title>
</head>

<body>


   <?php
include_once('config.php');
$email_valido = false;

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $sql = "SELECT * FROM cadastro WHERE email = '$email'";
    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $email_valido = true;
    } else {
        $mensagem = "E-mail não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <style>
        .form-senha {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div id="container-form">
        <?php if (!$email_valido): ?>
            <form method="POST">
                <h6>Por favor, insira o e-mail cadastrado</h6>
                <input type="email" name="email" placeholder="Informe o e-mail cadastrado" required>
                <input type="submit" value="Enviar" class="botao-rec">
            </form>
            <?php if (isset($mensagem)) echo "<p style='color:red;'>$mensagem</p>"; ?>
        <?php else: ?>
            <form method="POST" action="salvar_nova_senha_adm.php" class="form-senha">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <input type="password" name="nova_senha" placeholder="Digite a nova senha" required>                
                <input type="submit" value="Salvar nova senha" class="botao-rec">
            </form>
        <?php endif; ?>
    </div>
</body>

</html>