<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "usuarios";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi estabelecida com sucesso
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Obtém os valores enviados pelo formulário
$titulo = $_POST["titulo"];
$conteudo = $_POST["conteudo"];
$usuario_id = $_SESSION["usuario_id"]; // Obtém o ID do usuário logado na sessão

// Insere a nova postagem no banco de dados
$sql = "INSERT INTO postagens (titulo, conteudo, usuario_id) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $titulo, $conteudo, $usuario_id);

if ($stmt->execute()) {
    echo "Postagem criada com sucesso!";
    // Redireciona para a página de postagens
    header("Location: postagens.php");
    exit;
} else {
    echo "Erro ao criar a postagem: " . $stmt->error;
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
