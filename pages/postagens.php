<?php
include 'funcoes_postagem.php';

// Verifica se o usuário está logado
// Coloque aqui a lógica para verificar a autenticação do usuário e obter o ID do usuário logado

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Postagens</title>
</head>

<body>
    <?php

    // Restante do código PHP
    $username = "exemplo"; // Substitua "exemplo" pelo username desejado
    // Consulta as postagens do banco de dados do usuário atual
    $sql = "SELECT usuario_id FROM usuarios WHERE username = '$username'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userId = $row["usuario_id"];
    }

    $sql = "SELECT postagens.*, usuarios.username 
           FROM postagens 
           LEFT JOIN usuarios ON postagens.usuario_id = usuarios.usuario_id 
           WHERE postagens.usuario_id = $userId
           ORDER BY postagens.data_publicacao DESC";

    $result = $conn->query($sql);
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- Cabeçalho HTML -->
    </head>

    <body>
        <header>
            <h2>Postagens</h2>
            <div class="sair">
                <form action="../php/logout.php" method="POST">
                    <button type="submit">
                </form>
            </div>

        </header>

        <?php
        // Verifica se existem postagens
        if ($result->num_rows > 0) {
            // Exibe as postagens
            while ($row = $result->fetch_assoc()) {
                // Exibir cada postagem individualmente
                echo "<section>";
                echo "<h3>" . $row["titulo"] . "</h3>";
                echo "<p>Autor: " . ($row["username"] ? $row["username"] : "Desconhecido") . "</p>";
                echo "<p>" . $row["conteudo"] . "</p>";

                // Verifica se a postagem possui imagem
                if ($row["caminho_imagem"]) {
                    echo "<img class='img_post' src='" . $row["caminho_imagem"] . "' alt='Imagem da Postagem'>";
                }

                echo "<p>Data de publicação: " . $row["data_publicacao"] . "</p>";
                echo "<div class='actions'>";
                echo "<a href='../php/editar_postagem.php?id=" . $row["id_postagem"] . "'><img class='pub_icon' src='../img/lapis.png'></a>";
                echo " | ";
                echo "<a href='postagens.php?excluir_id=" . $row["id_postagem"] . "'><img class='pub_icon' src='../img/lixeira.png'></a>";
                echo "</div>";
                echo "<hr>";
                echo "</section>";

            }
        } else {
            echo "<p>Nenhuma postagem encontrada.</p>";
        }

        // Restante do código HTML
        ?>
        <section>
            <h3>Nova postagem</h3>
            <form action="../php/salvar_postagem.php" method="POST" enctype="multipart/form-data">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required><br><br>

                <label for="conteudo">Conteúdo:</label><br>
                <textarea id="conteudo" name="conteudo" required></textarea><br><br>

                <label for="imagem">Imagem:</label>
                <input type="file" id="imagem" name="imagem"><br><br>

                <input type="submit" value="Salvar">
            </form>
        </section>
    </body>

    </html>