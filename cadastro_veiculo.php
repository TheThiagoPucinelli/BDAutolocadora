<?php
require 'db/conexao.php';
require 'classes/Veiculo.php';
require 'classes/Marca.php';
$marcas = Marca::listar($pdo);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $v = new Veiculo($_POST['placa'], $_POST['marca'], $_POST['descricao']);
    $v->inserir($pdo);
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
    <form action="" method="POST">
        <label for="placa">Placa:</label>
        <input type="text" id="placa" name="placa" required placeholder="Digite a Placa">

        <label for="marca">Marca:</label>
        <select id="marca" name="marca" required>
            <option value="">Selecione</option>
            <?php foreach($marcas as $m): ?>
                <option value="<?= $m['marca_codigo'] ?>"><?= $m['marca_descricao'] ?></option>
            <?php endforeach; ?>
        </select>

        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" placeholder="Digite a Descrição">

        <input type="submit" class="btn" value="Cadastrar">
    </form>

    <h2>Veículos Cadastrados</h2>
    <iframe src="listar_veiculos.php"></iframe>
</body>
</html>
