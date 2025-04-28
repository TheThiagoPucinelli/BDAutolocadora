<?php
require 'db/conexao.php';
require 'classes/Cliente.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $c = new Cliente($_POST['cpf'], $_POST['nome'], $_POST['endereco']);
    $c->inserir($pdo);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>
    <link rel="stylesheet" href="css/Style.css">

</head>
<body>
    

    <h1>Cadastro de Cliente</h1>
    <form action="" method="POST">
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required placeholder="Digite o CPF">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required placeholder="Digite o Nome">

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" placeholder="Digite o Endereço">

        <input type="submit" class="btn" value="Cadastrar">
    </form>

    <h2>Clientes Cadastrados</h2>
    <iframe src="listar_clientes.php"></iframe>
</body>
</html>
