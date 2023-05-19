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

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os valores enviados pelo formulário
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Consulta SQL para buscar o usuário no banco de dados
    $sql = "SELECT * FROM usuarios WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    // Verifica se a consulta retornou um resultado
    if ($result->num_rows == 1) {
        // Login bem-sucedido
        // Após verificar as credenciais e validar o login
        session_start();
        $_SESSION['logged_in'] = true;

        header("Location: ../pages/principal.php?username=" . urlencode($username));

        // Redireciona para a página principal ou realiza outras ações
        // header("Location: principal.php");
    } else {
        // Login inválido
        echo "Nome de usuário ou senha inválidos.";
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>