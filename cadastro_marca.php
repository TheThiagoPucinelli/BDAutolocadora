<?php
// Importa a conexão com o banco de dados
require 'db/conexao.php';
// Importa a classe Marca
require 'classes/Marca.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica se o formulário foi enviado via método POST
    
    $m = new Marca($_POST['descricao']); // Cria um objeto Marca com a descrição enviada pelo formulário
   
    $m->inserir($pdo);   // Insere a marca no banco de dados
}
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Marca</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Arquivo CSS para estilização -->
</head>
<body>

    <h1>Cadastro de Marca</h1>

    <!-- Formulário para cadastro de nova marca -->
    <form action="" method="POST">
        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" required placeholder="Digite a Marca">
        <input type="submit" class="btn" value="Cadastrar">
    </form>

    <!-- Iframe para exibir marcas já cadastradas -->
    <h2>Marcas Cadastradas</h2>
    <iframe src="listar_marcas.php"></iframe>

</body>
</html>
