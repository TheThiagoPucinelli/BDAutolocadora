<?php
require 'db/conexao.php';
require 'classes/Cliente.php';
require 'classes/Locacao.php';
require 'classes/Veiculo.php';
require 'classes/Marca.php';

// --- EXCLUIR LOCAÇÃO ---
if (isset($_GET['deletar'])) {
    $codigo = $_GET['deletar'];
    $stmt = $pdo->prepare("DELETE FROM tblocacao WHERE locacao_codigo = ?");
    $stmt->execute([$codigo]);
    header("Location: listar_locacoes.php");
    exit;
}

// --- EDITAR LOCAÇÃO ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $codigo = $_POST['locacao_codigo'];
    $data_inicio = $_POST['locacao_data_inicio'];
    $data_fim = $_POST['locacao_data_fim'];

    $stmt = $pdo->prepare("UPDATE tblocacao SET locacao_data_inicio = ?, locacao_data_fim = ? WHERE locacao_codigo = ?");
    $stmt->execute([$data_inicio, $data_fim, $codigo]);
    header("Location: listar_locacoes.php");
    exit;
}

// --- CONSULTAR LOCAÇÕES ---
$sql_locacao = "SELECT l.locacao_codigo, l.locacao_data_inicio, l.locacao_data_fim, 
                       c.cliente_nome, v.veiculo_placa, v.veiculo_descricao, m.marca_descricao
                FROM tblocacao l
                JOIN tbcliente c ON l.locacao_cliente = c.cliente_cpf
                JOIN tbveiculo v ON l.locacao_veiculo = v.veiculo_placa
                JOIN tbmarca m ON v.veiculo_marca = m.marca_codigo";
$stmt_locacao = $pdo->query($sql_locacao);
$locacoes = $stmt_locacao->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Locações Cadastradas</title>
    <link rel="stylesheet" href="css/Style.css">
    <style>
        table {
            width: 95%;
            margin: 30px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: center;
        }
        input[type="date"] {
            width: 90%;
        }
        .btn-delete {
            color: red;
            text-decoration: none;
        }
        .voltar-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 20px 0;
        }
    </style>
</head>
<body>

<h1 style="text-align:center;">Locações Cadastradas</h1>

<center>
    <form action="index.html" method="get">
        <button type="submit" class="voltar-btn">Voltar para o Início</button>
    </form>
</center>

<table>
    <tr>
        <th>Código</th>
        <th>Cliente</th>
        <th>Veículo</th>
        <th>Marca</th>
        <th>Descrição</th>
        <th>Início</th>
        <th>Fim</th>
        <th>Editar</th>
        <th>Excluir</th>
    </tr>

    <?php foreach ($locacoes as $l): ?>
        <tr>
            <form method="post">
                <td>
                    <?= $l['locacao_codigo'] ?>
                    <input type="hidden" name="locacao_codigo" value="<?= $l['locacao_codigo'] ?>">
                </td>
                <td><?= htmlspecialchars($l['cliente_nome']) ?></td>
                <td><?= htmlspecialchars($l['veiculo_placa']) ?></td>
                <td><?= htmlspecialchars($l['marca_descricao']) ?></td>
                <td><?= htmlspecialchars($l['veiculo_descricao']) ?></td>
                <td>
                    <input type="date" name="locacao_data_inicio" value="<?= $l['locacao_data_inicio'] ?>">
                </td>
                <td>
                    <input type="date" name="locacao_data_fim" value="<?= $l['locacao_data_fim'] ?>">
                </td>
                <td>
                    <button type="submit" name="editar">Salvar</button>
                </td>
                <td>
                    <a href="?deletar=<?= $l['locacao_codigo'] ?>" class="btn-delete"
                       onclick="return confirm('Deseja deletar esta locação?')">Excluir</a>
                </td>
            </form>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
