<?php
require 'db/conexao.php';
require 'classes/Locacao.php';
require 'classes/Cliente.php';
require 'classes/Veiculo.php';


$clientes = Cliente::listar($pdo);
$veiculos = Veiculo::listar($pdo);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (isset($_POST['veiculo'], $_POST['cliente'], $_POST['data_inicio'], $_POST['data_fim'])) {
       
        $veiculo = $_POST['veiculo'];
        $cliente = $_POST['cliente'];
        $data_inicio = $_POST['data_inicio'];
        $data_fim = $_POST['data_fim'];

        
        if (empty($veiculo) || empty($cliente) || empty($data_inicio) || empty($data_fim)) {
            $erro = "Todos os campos devem ser preenchidos.";
        } else {
            
            $locacao = new Locacao($veiculo, $cliente, $data_inicio, $data_fim);

            
            try {
                $locacao->inserir($pdo);
                $sucesso = "Locação cadastrada com sucesso!";
            } catch (Exception $e) {
                $erro = "Erro ao cadastrar a locação: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Locação</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <h1>Cadastro de Locação</h1>

   
    <?php if (isset($erro)): ?>
        <div class="alert alert-danger"><?= $erro ?></div>
    <?php elseif (isset($sucesso)): ?>
        <div class="alert alert-success"><?= $sucesso ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="veiculo">Veículo:</label>
        <select id="veiculo" name="veiculo" required>
            <option value="">Selecione</option>
            <?php foreach ($veiculos as $v): ?>
                <option value="<?= $v['veiculo_placa'] ?>"><?= $v['veiculo_placa'] ?> - <?= $v['marca_descricao'] ?></option>
            <?php endforeach; ?>
        </select>

        <label for="cliente">Cliente:</label>
        <select id="cliente" name="cliente" required>
            <option value="">Selecione</option>
            <?php foreach ($clientes as $c): ?>
                <option value="<?= $c['cliente_cpf'] ?>"><?= $c['cliente_nome'] ?></option>
            <?php endforeach; ?>
        </select>

        <label for="data_inicio">Data de Início:</label>
        <input type="date" id="data_inicio" name="data_inicio" required>

        <label for="data_fim">Data de Fim:</label>
        <input type="date" id="data_fim" name="data_fim" required>

        <input type="submit" class="btn" value="Cadastrar Locação">
    </form>

    <h2>Locações Cadastradas</h2>
    <iframe src="listar_locacoes.php"></iframe>

</body>
</html>
