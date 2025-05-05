<?php
// Importa a conexão com o banco e as classes necessárias
require 'db/conexao.php';
require 'classes/Locacao.php';
require 'classes/Cliente.php';
require 'classes/Veiculo.php';

// Lista todos os clientes e veículos para o formulário
$clientes = Cliente::listar($pdo);
$veiculos = Veiculo::listar($pdo);

// Verifica se o formulário foi enviado por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['veiculo'], $_POST['cliente'], $_POST['data_inicio'], $_POST['data_fim'])) { // Verifica se todos os campos necessários estão definidos

        // Captura os dados do formulário
        $veiculo = $_POST['veiculo'];
        $cliente = $_POST['cliente'];
        $data_inicio = $_POST['data_inicio'];
        $data_fim = $_POST['data_fim'];

        
        if (empty($veiculo) || empty($cliente) || empty($data_inicio) || empty($data_fim)) { // Valida se os campos não estão vazios
            $erro = "Todos os campos devem ser preenchidos.";
        } else {
            
            $locacao = new Locacao($veiculo, $cliente, $data_inicio, $data_fim); // Cria o objeto Locacao e tenta inserir no banco
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

<h1>Cadastro de Locação</h1>

<!-- Exibe mensagens de erro ou sucesso, se existirem -->
<?php if (isset($erro)): ?>
    <div class="alert alert-danger"><?= $erro ?></div>
<?php elseif (isset($sucesso)): ?>
    <div class="alert alert-success"><?= $sucesso ?></div>
<?php endif; ?>

<!-- Formulário para cadastro de locações -->
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

<!-- Botão de voltar -->
<center>
    <form action="index.html" method="get">
        <button type="submit" class="voltar-btn">Voltar para o Início</button>
    </form>
</center>

<!-- Seção para exibir locações já cadastradas -->

<iframe src="listar_locacoes.php"></iframe>

</body>
</html>
