<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    session_start();

    if (isset($_SESSION['logged_in'])) {
        // Redirecionar para a página de login ou exibir mensagem de erro
        header("Location: pages/principal.php");
    }

    ?>
   
    <h2>Tela de Login</h2>
    <form action="php/login.php" method="POST">
        <label for="username">Usuário:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Entrar">
    </form>
    
    <br>
    <p>Ainda não possui uma conta?</p>
    <a href="pages/cadastro.html"><button>Cadastrar</button></a>

</body>
</html>