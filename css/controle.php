 <?php
session_start();
$mensagem_erro = "";

if (isset($_SESSION['erro_login'])) {
    $mensagem_erro = $_SESSION['erro_login'];
    unset($_SESSION['erro_login']);
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

    <div class="banner">
        <!-- <img src="img/logo2.png" alt=""> -->
    </div>

    <div class="container-login">
        <form action="valida_login.php" method="POST" onsubmit="return logar();">
            <header>Login</header>

            <?php if (!empty($mensagem_erro)) { ?>
                <p style="color: red; font-weight: bold;"><?php echo $mensagem_erro; ?></p>
            <?php } ?>

            <input type="text" name="email" placeholder="Informe o seu email" id="lognome">
            <input type="password" name="senha" placeholder="Digite a senha" id="logsenha">
            <input type="submit" name="submit" value="Entrar"id="submit"class="botao-login">
            

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

    <script src="js/scripts.js"></script>
</body>
</html>