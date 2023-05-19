<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "usuarios";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Define o fuso horário desejado
date_default_timezone_set('America/Sao_Paulo');

// Verifica se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postagemId = $_POST["id_postagem"];
    $novoTitulo = $_POST["titulo"];
    $novoConteudo = $_POST["conteudo"];
    $dataAtualizacao = date("Y-m-d H:i:s"); // Obtém a data e hora atual no fuso horário definido

    // Verifica se foi fornecida uma nova imagem
    if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] === 0) {
        $novoNomeImagem = $_FILES["imagem"]["name"];
        $novoCaminhoImagem = "../bancoImagens" . $novoNomeImagem;

        // Move a nova imagem para o diretório de destino
        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $novoCaminhoImagem)) {
            // Remove a imagem antiga se existir
            $sql = "SELECT caminho_imagem FROM postagens WHERE id_postagem = $postagemId";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $caminhoImagemAntiga = $row["caminho_imagem"];

                if (!empty($caminhoImagemAntiga)) {
                    if (unlink($caminhoImagemAntiga)) {
                        echo "Imagem antiga excluída com sucesso.";
                    } else {
                        echo "Erro ao excluir a imagem antiga.";
                    }
                }
            }

            // Atualiza as informações da postagem no banco de dados
            $sql = "UPDATE postagens SET titulo = ?, conteudo = ?, caminho_imagem = ?, data_publicacao = ? WHERE id_postagem = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $novoTitulo, $novoConteudo, $novoCaminhoImagem, $dataAtualizacao, $postagemId);

            if ($stmt->execute()) {
                echo "Postagem atualizada com sucesso.";
            } else {
                echo "Erro ao atualizar a postagem: " . $stmt->error;
            }
        } else {
            echo "Erro ao fazer upload da nova imagem.";
        }
    } else {
        // Nenhuma nova imagem foi fornecida, atualiza apenas o título e conteúdo da postagem
        $sql = "UPDATE postagens SET titulo = ?, conteudo = ?, data_publicacao = ? WHERE id_postagem = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $novoTitulo, $novoConteudo, $dataAtualizacao, $postagemId);

        if ($stmt->execute()) {
            echo "Postagem atualizada com sucesso.\n redirecionando...";
            echo "<script>setTimeout(function(){ window.location.href = '../pages/postagens.php'; }, 2000);</script>";

        } else {
            echo "Erro ao atualizar a postagem: " . $stmt->error;
        }
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
