<?php
 
require 'db/conexao.php'; // Conexão com o banco de dados

require 'classes/Veiculo.php'; // Inclusão da classe de veículos

require 'classes/Marca.php'; // Inclusão da classe de marcas

// Lista todas as marcas para preencher o <select> do formulário
$marcas = Marca::listar($pdo);

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     
    $v = new Veiculo($_POST['placa'], $_POST['marca'], $_POST['descricao']); // Cria um novo veículo com os dados do formulário
   
    $v->inserir($pdo); // Insere o novo veículo no banco de dados
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Veículo</title>
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>

    <h1>Cadastro de Veículo</h1>

    <!-- Formulário de cadastro de veículo -->
    <form action="" method="POST">
        <!-- Campo para a placa -->
        <label for="placa">Placa:</label>
        <input type="text" id="placa" name="placa" required placeholder="Digite a Placa">

        <!-- Select para a marca do veículo -->
        <label for="marca">Marca:</label>
        <select id="marca" name="marca" required>
            <option value="">Selecione</option>
            <!-- Preenche o select com as marcas existentes -->
            <?php foreach($marcas as $m): ?>
                <option value="<?= $m['marca_codigo'] ?>"><?= $m['marca_descricao'] ?></option>
            <?php endforeach; ?>
        </select>

       
        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" placeholder="Digite a Descrição">

      
        <input type="submit" class="btn" value="Cadastrar">
    </form>

    <!-- Iframe para exibir veículos cadastrados -->
    <h2>Veículos Cadastrados</h2>
    <iframe src="listar_veiculos.php"></iframe>

</body>
</html>

