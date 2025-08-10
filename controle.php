<?php
session_start();
include_once "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitiza e valida os dados de entrada
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $senha = trim($_POST['senha']);

    if (empty($email) || empty($senha)) {
        echo "❌ Preencha todos os campos!";
        exit;
    }

    // Verifica se o e-mail é válido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "❌ E-mail inválido!";
        exit;
    }

    // Prepara a consulta com segurança
    $sql = "SELECT * FROM cadastro WHERE email = ?";
    $stmt = $conexao->prepare($sql);

    if (!$stmt) {
        echo "Erro na preparação da consulta.";
        exit;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

       if (password_verify($senha, $usuario['senha'])) {
    // Preenche a sessão com dados do usuário
    $_SESSION['codigo_id'] = $usuario['codigo_id']; // corrigido
    $_SESSION['email'] = $usuario['email'];
    $_SESSION['nome'] = $usuario['nome'] ?? '';
    $_SESSION['telefone'] = $usuario['telefone'] ?? '';
    $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'] ?? '';

    // Verificação de tipo
    if ($_SESSION['tipo_usuario'] === 'admin') {
        header("Location: paineldecontrole.php");
        exit;
    } else {
        header("Location: controle.php");
        exit;
    }
}
 else {
            echo "❌ Senha incorreta!";
        }
    } else {
        echo "❌ E-mail não encontrado!";
    }

    $stmt->close();
    $conexao->close();
}
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="css/styleportal.css"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Savate:ital,wght@0,200..900;1,200..900&display=swap"
        rel="stylesheet">
    <title>Blessed Barber Shop - Controle</title>
</head>

<body>



    <div class="container-login">
        <form action="valida_login_adm.php" method="POST" onsubmit="return logar();">
            <header>Login</header>

            <?php if (!empty($mensagem_erro)) { ?>
                <p style="color: red; font-weight: bold;"><?php echo $mensagem_erro; ?></p>
            <?php } ?>

            <input type="text" name="email" placeholder="Informe o seu email" id="lognome">
            <input type="password" name="senha" placeholder="Digite a senha" id="logsenha">
            
            

            <input type="submit" name="submit" value="Entrar" id="submit" class="botao-login">


            <p><a href="recuperarsenha.php">Esqueci a minha senha.</a></p>
        </form>

        <script>
            function logar() {
                const email = document.getElementById('lognome').value.trim();
                const senha = document.getElementById('logsenha').value.trim();

                if (email === "" || senha === "") {
                    alert("⚠️ Preencha todos os campos.");
                    return false;
                }
                return true;
            }
        </script>


    </div>

    <script>
        const tipo_usuario = "<?php echo $tipo_usuario; ?>";
    </script>

    <script src="js/scripts.js"></script>
</body>

</html>