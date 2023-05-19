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
$username = $_POST["username"];
$password = $_POST["password"];

$stmt = $conn->prepare("SELECT username FROM usuarios WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo "<h3>O nome de usuário já está em uso. Por favor, escolha outro.</h3><br>redirecionando...";
    echo "<script>setTimeout(function(){ window.location.href = '../pages/cadastro.html'; }, 2000);</script>";

    
} else {
    // Insere os dados na tabela de usuários
    $sql = "INSERT INTO usuarios (username, password) VALUES ('$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<h3>Usuário cadastrado com sucesso!</h3><br>redirecionando...";
        // Atraso de 2 segundos
        // Redireciona para a página index.php usando JavaScript
        echo "<script>setTimeout(function(){ window.location.href = '../index.php'; }, 2000);</script>";
        exit;
    } else {
        echo "Erro ao cadastrar o usuário: " . $conn->error;
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
