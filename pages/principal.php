<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>Bem-vindo à Página Principal</h2>
    <?php
    session_start();

    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
        // Redirecionar para a página de login ou exibir mensagem de erro
        header("Location: ../index.php");
        exit;
    }

    ?>
    <?php
    // Verifica se o nome de usuário está definido na URL
    if (isset($_GET["username"])) {
        $username = $_GET["username"];
        echo "<p>Você fez login com sucesso, " . $username . "!</p>";
    } else {
        echo "<p>Você fez login com sucesso!</p>";
    }
    ?>
    <a href="postagens.php"><button>Ver Postagens</button></a>
    
    <form action="../php/logout.php" method="POST">
        <input class='sair' type="submit" value="Logout">
    </form>

</body>

</html>