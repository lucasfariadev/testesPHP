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

// Verifica se foi solicitada a exclusão de uma postagem
if (isset($_GET["excluir_id"])) {
    $excluirId = $_GET["excluir_id"];

    // Consulta o caminho da imagem antes de excluir a postagem
    $sql = "SELECT caminho_imagem FROM postagens WHERE id_postagem = $excluirId";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $caminhoImagem = $row["caminho_imagem"];

        // Exclui a postagem no banco de dados
        $sql = "DELETE FROM postagens WHERE id_postagem = $excluirId";
        if ($conn->query($sql) === TRUE) {
            echo "Postagem excluída com sucesso.";

            // Verifica se a postagem tinha uma imagem associada e a exclui
            if (!empty($caminhoImagem)) {
                if (unlink($caminhoImagem)) {
                    echo "Imagem excluída com sucesso.";
                } else {
                    echo "Erro ao excluir a imagem.";
                }
            }
        } else {
            echo "Erro ao excluir a postagem: " . $conn->error;
        }
        echo "<br>";
    }
}

// Consulta as postagens do banco de dados com o nome do usuário
$sql = "SELECT postagens.*, usuarios.username 
        FROM postagens 
        LEFT JOIN usuarios ON postagens.usuario_id = usuarios.usuario_id 
        ORDER BY postagens.data_publicacao DESC";

$result = $conn->query($sql);
?>
