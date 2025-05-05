<?php
require 'db/conexao.php';
require 'classes/Cliente.php';

// --- EXCLUIR CLIENTE ---
if (isset($_GET['deletar'])) {
    $cpf = $_GET['deletar'];
    $stmt = $pdo->prepare("DELETE FROM tbcliente WHERE cliente_cpf = ?");
    $stmt->execute([$cpf]);
    header("Location: listar_clientes.php");
    exit;
}

// --- EDITAR CLIENTE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $cpf = $_POST['cliente_cpf'];
    $nome = $_POST['cliente_nome'];
    $endereco = $_POST['cliente_endereco'];

    $stmt = $pdo->prepare("UPDATE tbcliente SET cliente_nome = ?, cliente_endereco = ? WHERE cliente_cpf = ?");
    $stmt->execute([$nome, $endereco, $cpf]);
    header("Location: listar_clientes.php");
    exit;
}

// --- LISTAR CLIENTES ---
$clientes = Cliente::listar($pdo);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
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

        input[type="text"] {
            width: 100%;
            box-sizing: border-box;
        }

        button {
            padding: 5px 10px;
            margin: 0;
        }

        .btn-delete {
            color: red;
            text-decoration: none;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Clientes Cadastrados</h2>

<table>
    <tr>
        <th>CPF</th>
        <th>Nome</th>
        <th>Endereço</th>
        <th>Editar</th>
        <th>Excluir</th>
    </tr>
    <?php foreach($clientes as $c): ?>
        <tr>
            <form method="post">
                <td><?= htmlspecialchars($c['cliente_cpf']) ?>
                    <input type="hidden" name="cliente_cpf" value="<?= $c['cliente_cpf'] ?>">
                </td>
                <td>
                    <input type="text" name="cliente_nome" value="<?= htmlspecialchars($c['cliente_nome']) ?>">
                </td>
                <td>
                    <input type="text" name="cliente_endereco" value="<?= htmlspecialchars($c['cliente_endereco']) ?>">
                </td>
                <td>
                    <button type="submit" name="editar">Salvar</button>
                </td>
                <td>
                    <a href="?deletar=<?= $c['cliente_cpf'] ?>" class="btn-delete"
                       onclick="return confirm('Deseja realmente excluir este cliente?')">Excluir</a>
                </td>
            </form>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
