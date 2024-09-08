<?php
// Conexão com o banco de dados
require_once 'conexao.php';

// Função para cadastrar usuário
function cadastrarUsuario($dadosUsuario) {
  global $pdo;

  try {
    // Verificar se os dados estão corretos
    if (!filter_var($dadosUsuario['email'], FILTER_VALIDATE_EMAIL)) {
      throw new Exception('E-mail inválido');
    }
    if (empty($dadosUsuario['NomeCompleto']) || empty($dadosUsuario['Telefone']) || empty($dadosUsuario['Senha'])) {
      throw new Exception('Preencha todos os campos');
    }

    // Hash a senha
    $senhaHash = password_hash($dadosUsuario['Senha'], PASSWORD_DEFAULT);

    // Preparar a consulta
    $query = $pdo->prepare("INSERT INTO `users-irriga`(Email, NomeCompleto, Telefone, Senha) VALUES (:Email, :NomeCompleto, :Telefone, :Senha)");
    $query->bindParam(':Email', $dadosUsuario['email']);
    $query->bindParam(':NomeCompleto', $dadosUsuario['NomeCompleto']);
    $query->bindParam(':Telefone', $dadosUsuario['Telefone']);
    $query->bindParam(':Senha', $senhaHash);

    // Executar a consulta
    if (!$query->execute()) {
      throw new Exception('Erro ao cadastrar usuário: ' . $query->errorInfo()[2]);
    }

    return json_encode(array('success' => true, 'message' => 'Cadastro realizado com sucesso'));
  } catch (Exception $e) {
    return json_encode(array('success' => false, 'message' => 'Erro ao cadastrar usuário: ' . $e->getMessage()));
  }
}

// Verificar se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Obter os dados da requisição
  $dadosUsuario = json_decode(file_get_contents('php://input'), true);

  // Chamar a função para cadastrar usuário
  echo cadastrarUsuario($dadosUsuario);
} else {
  echo json_encode(array('success' => false, 'message' => 'Método de requisição inválido'));
}
?>