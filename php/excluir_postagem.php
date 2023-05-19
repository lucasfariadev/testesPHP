<?php
// Verifica se o ID da postagem foi fornecido
if (isset($_GET["id"])) {
    $postagemId = $_GET["id"];
    
    // Executa a exclusão da postagem no banco de dados
    // Aqui você precisará adicionar o código para executar a exclusão na tabela 'postagens' com base no ID fornecido
    
    // Após excluir a postagem, redirecione de volta para a página "postagens.php" ou exiba uma mensagem de confirmação
    header("Location: postagens.php");
    exit();
}
?>
