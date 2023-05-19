<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "usuarios";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se o ID da postagem foi fornecido
if (isset($_GET["id"])) {
    $postagemId = $_GET["id"];

    // Consulta a postagem específica com base no ID no banco de dados
    $sql = "SELECT * FROM postagens WHERE id_postagem = $postagemId";
    $result = $conn->query($sql);

    // Verifica se a consulta foi executada com sucesso
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tituloAtual = $row["titulo"];
        $conteudoAtual = $row["conteudo"];
        $caminhoImagem = $row["caminho_imagem"];

        // Exibe um formulário preenchido com o título e conteúdo atual da postagem para permitir a edição
        echo "<form action='atualizar_postagem.php' method='POST' enctype='multipart/form-data'>";
        echo "<input type='hidden' name='id_postagem' value='" . $postagemId . "'>";
        echo "<label for='titulo'>Título:</label><br>";
        echo "<input type='text' id='titulo' name='titulo' value='" . $tituloAtual . "' required><br><br>";
        echo "<label for='conteudo'>Conteúdo:</label><br>";
        echo "<textarea id='conteudo' name='conteudo' required>" . $conteudoAtual . "</textarea><br><br>";
        echo "<label for='imagem'>Imagem:</label><br>";
        echo "<img src='" . $caminhoImagem . "' alt='Imagem atual'><br><br>";
        echo "<input type='file' id='imagem' name='imagem'><br><br>";
        echo "<input type='submit' value='Atualizar'>";
        echo "</form>";
    } else {
        echo "Postagem não encontrada.";
    }
}
$conn->close();
?>
