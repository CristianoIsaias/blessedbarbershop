<?php



session_start();
include_once("config.php");

if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    // Verifica tentativas
    $sqlTent = $conexao->prepare("SELECT tentativas, ultimo_erro FROM tentativas_login WHERE email = ?");
    $sqlTent->bind_param("s", $email);
    $sqlTent->execute();
    $resTent = $sqlTent->get_result();

    if ($resTent->num_rows > 0) {
        $tentativa = $resTent->fetch_assoc();
        if ($tentativa['tentativas'] >= 3) {
            $agora = new DateTime();
            $ultimo = new DateTime($tentativa['ultimo_erro']);
            if ($agora->getTimestamp() - $ultimo->getTimestamp() < 900) {
                die("<p style='color:red;'>Muitas tentativas. Tente novamente em 15 minutos.</p>");
            }
        }
    }

    $stmt = $conexao->prepare("SELECT * FROM cadastro WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        if (password_verify($senha, $usuario['senha'])) {
            // Login OK
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['nome'] = $usuario['nome'];

            // Zera tentativas
            $del = $conexao->prepare("DELETE FROM tentativas_login WHERE email = ?");
            
            $del->bind_param("s", $email);
            $del->execute();

            // Salva login
            $ip = $_SERVER['REMOTE_ADDR'];
            $nav = $_SERVER['HTTP_USER_AGENT'];
            $log = $conexao->prepare("INSERT INTO reg_login (usuario_id, ip, navegador) VALUES (?, ?, ?)");
            $log->bind_param("iss", $usuario['id'], $ip, $nav);
            $log->execute();

            header("Location: dashboard.php");
            exit;
        } else {
            // Senha errada
            if ($resTent->num_rows > 0) {
                $upd = $conexao->prepare("UPDATE tentativas_login SET tentativas = tentativas + 1, ultimo_erro = NOW() WHERE email = ?");
            } else {
                $upd = $conexao->prepare("INSERT INTO tentativas_login (email, tentativas, ultimo_erro) VALUES (?, 1, NOW())");
            }
            $upd->bind_param("s", $email);
            $upd->execute();
            echo "<p style='color:red;'>Senha incorreta.</p>";
        }
    } else {
        echo "<p style='color:red;'>Usuário não encontrado.</p>";
    }
}
?>

<h1>Login</h1>
<form method="POST">
    <input type="email" name="email" placeholder="Seu email" required><br>
    <input type="password" name="senha" placeholder="Sua senha" required><br>
    <input type="submit" name="submit" value="Entrar">
</form>
