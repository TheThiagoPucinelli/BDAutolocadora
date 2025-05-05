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
    <style>
        /* Estilo para o botão de Voltar */
        .voltar-btn {
            background-color: #4CAF50; /* Cor de fundo */
            color: white; /* Cor do texto */
            padding: 10px 20px; /* Padding do botão */
            font-size: 16px; /* Tamanho da fonte */
            border: none; /* Remove bordas */
            border-radius: 5px; /* Bordas arredondadas */
            cursor: pointer; /* Cursor de mão ao passar o mouse */
            margin: 20px 0; /* Margem superior e inferior */
            transition: background-color 0.3s; /* Animação suave na troca de cor */
        }

        .voltar-btn:hover {
            background-color: #45a049; /* Cor de fundo ao passar o mouse */
        }
    </style>
</head>
<body>

<h1>Cadastro de Marca</h1>

<!-- Formulário para cadastro de nova marca -->
<form action="" method="POST">
    <label for="descricao">Descrição:</label>
    <input type="text" id="descricao" name="descricao" required placeholder="Digite a Marca">
    <input type="submit" class="btn" value="Cadastrar">
</form>

<!-- Botão de voltar -->
<center>
    <form action="index.html" method="get">
        <button type="submit" class="voltar-btn">Voltar para o Início</button>
    </form>
</center>

<!-- Iframe para exibir marcas já cadastradas -->

<iframe src="listar_marcas.php"></iframe>

</body>
</html>
