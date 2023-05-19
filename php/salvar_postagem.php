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
$usuario_id = 1; // Obtém o ID do usuário logado na sessão

// Verifica se um novo arquivo de imagem foi enviado
if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {
    $imagem = $_FILES["imagem"]["name"];
    $diretorioDestino = "../bancoImagens" . $imagem;

    // Move o novo arquivo enviado para o diretório de destino
    if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $diretorioDestino)) {
        // O novo arquivo foi enviado com sucesso, agora você pode inserir a postagem no banco de dados
        $sql = "INSERT INTO postagens (titulo, conteudo, usuario_id, caminho_imagem) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssis", $titulo, $conteudo, $usuario_id, $diretorioDestino);

        if ($stmt->execute()) {
            echo "Postagem criada com sucesso!";
            // Redireciona para a página de postagens
            header("Location: ../pages/postagens.php");
            exit;
        } else {
            echo "Erro ao criar a postagem: " . $stmt->error;
        }
    } else {
        // Ocorreu um erro ao mover o novo arquivo para o diretório de destino
        echo "Erro ao fazer upload da imagem.";
    }
} else {
    // Nenhum arquivo de imagem foi enviado
    $sql = "INSERT INTO postagens (titulo, conteudo, usuario_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $titulo, $conteudo, $usuario_id);

    if ($stmt->execute()) {
        echo "Postagem criada com sucesso!";
        // Redireciona para a página de postagens
        header("Location: ../pages/postagens.php");
        exit;
    } else {
        echo "Erro ao criar a postagem: " . $stmt->error;
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
