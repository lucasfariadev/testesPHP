
<?php
    // Verifica se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtém os valores dos campos do formulário
        $nome = $_POST["nome"];
        $email = $_POST["email"];

        // Faça o que quiser com os dados do formulário
        // Por exemplo, exiba os valores:
        echo "Nome: " . $nome . "<br>";
        echo "Email: " . $email;
    }
    ?>