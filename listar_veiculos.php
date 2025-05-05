<?php
require 'db/conexao.php';
require 'classes/Veiculo.php';
require 'classes/Marca.php';

// --- EXCLUIR VEÍCULO ---
if (isset($_GET['deletar'])) {
    $placa = $_GET['deletar'];
    $stmt = $pdo->prepare("DELETE FROM tbveiculo WHERE veiculo_placa = ?");
    $stmt->execute([$placa]);
    header("Location: listar_veiculos.php");
    exit;
}

// --- EDITAR VEÍCULO ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $placa = $_POST['veiculo_placa'];
    $descricao = $_POST['veiculo_descricao'];
    $marca = $_POST['veiculo_marca'];

    $stmt = $pdo->prepare("UPDATE tbveiculo SET veiculo_descricao = ?, veiculo_marca = ? WHERE veiculo_placa = ?");
    $stmt->execute([$descricao, $marca, $placa]);
    header("Location: listar_veiculos.php");
    exit;
}

// --- LISTAR VEÍCULOS ---
$veiculos = Veiculo::listar($pdo); // Deve retornar veiculo_placa, veiculo_descricao, veiculo_marca, marca_descricao
$marcas = Marca::listar($pdo);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Veículos</title>
    <link rel="stylesheet" href="css/Style.css">
    <style>
        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        input[type="text"], select {
            width: 100%;
            box-sizing: border-box;
        }
        button {
            padding: 5px 10px;
        }
        .btn-delete {
            color: red;
            text-decoration: none;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Veículos Cadastrados</h2>

<table>
    <tr>
        <th>Placa</th>
        <th>Marca</th>
        <th>Descrição</th>
        <th>Editar</th>
        <th>Excluir</th>
    </tr>

    <?php foreach($veiculos as $v): ?>
        <tr>
            <form method="post">
                <td>
                    <?= htmlspecialchars($v['veiculo_placa']) ?>
                    <input type="hidden" name="veiculo_placa" value="<?= htmlspecialchars($v['veiculo_placa']) ?>">
                </td>
                <td>
                    <select name="veiculo_marca" required>
                        <?php foreach($marcas as $m): ?>
                            <option value="<?= $m['marca_codigo'] ?>" <?= isset($v['veiculo_marca']) && $m['marca_codigo'] == $v['veiculo_marca'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($m['marca_descricao']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <input type="text" name="veiculo_descricao" value="<?= htmlspecialchars($v['veiculo_descricao']) ?>" required>
                </td>
                <td>
                    <button type="submit" name="editar">Salvar</button>
                </td>
                <td>
                    <a href="?deletar=<?= $v['veiculo_placa'] ?>" class="btn-delete"
                       onclick="return confirm('Deseja realmente excluir este veículo?')">Excluir</a>
                </td>
            </form>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
