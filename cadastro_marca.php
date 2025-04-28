<?php
require 'db/conexao.php';
require 'classes/Marca.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $m = new Marca($_POST['descricao']);
    $m->inserir($pdo);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Marca</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>


    <h1>Cadastro de Marca</h1>
    <form action="" method="POST">
        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" required placeholder="Digite a Marca">

        <input type="submit" class="btn" value="Cadastrar">
    </form>

    <h2>Marcas Cadastradas</h2>
    <iframe src="listar_marcas.php"></iframe>
</body>
</html>
