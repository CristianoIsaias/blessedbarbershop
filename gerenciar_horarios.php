<?php
session_start();
include_once "config.php";

header('Content-Type: application/json'); // Garante que a resposta seja JSON

$response = ['success' => false, 'message' => ''];

// Verifica se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // A variável PHP agora é $tipo_usuario
    $tipo_usuario = $_SESSION['usuario_tipo'] ?? 'comum';
    if ($tipo_usuario !== 'admin') {
        $response['message'] = 'Apenas administradores podem gerenciar horários.';
        echo json_encode($response);
        exit;
    }

    // Pega os dados enviados via POST
    $horario = $_POST['horario'] ?? '';
    $data = $_POST['data'] ?? '';
    $acao = $_POST['acao'] ?? ''; // 'desativar' ou 'ativar'

    // Validação básica dos dados
    if (empty($horario) || empty($data) || empty( $acao)) {
        $response['message'] = 'Dados inválidos fornecidos.';
        echo json_encode($response);
        exit;
    }

    $data_formatada_banco = date('Y-m-d', strtotime($data));

    if ($acao === 'desativar') {
        // Tenta inserir o horário como desativado
        $stmt = $conexao->prepare("INSERT INTO horarios_desativados (horario, data) VALUES (?, ?)");
        $stmt->bind_param("ss", $horario, $data_formatada_banco);
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Horário desativado com sucesso.';
        } else {
            // Se houver um erro de chave duplicada (horário já desativado), ainda consideramos sucesso
            if ($conexao->errno == 1062) { // 1062 é o código de erro para entrada duplicada (Duplicate entry)
                $response['success'] = true;
                $response['message'] = 'Horário já estava desativado.';
            } else {
                $response['message'] = 'Erro ao desativar horário: ' . $stmt->error;
            }
        }
        $stmt->close();
    } elseif ($acao === 'ativar') {
        // Tenta remover o horário da lista de desativados
        $stmt = $conexao->prepare("DELETE FROM horarios_desativados WHERE horario = ? AND data = ?");
        $stmt->bind_param("ss", $horario, $data_formatada_banco);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response['success'] = true;
                $response['message'] = 'Horário ativado com sucesso.';
            } else {
                $response['success'] = true; // Já não estava desativado, considera sucesso
                $response['message'] = 'Horário não estava desativado para esta data.';
            }
        } else {
            $response['message'] = 'Erro ao ativar horário: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['message'] = 'Ação solicitada inválida.';
    }
} else {
    $response['message'] = 'Método de requisição não permitido.';
}

$conexao->close();
echo json_encode($response);
?>