<?php
require 'db/conexao.php';
require 'classes/Marca.php';

// --- EXCLUIR MARCA ---
if (isset($_GET['deletar'])) {
    $codigo = $_GET['deletar'];
    $stmt = $pdo->prepare("DELETE FROM tbmarca WHERE marca_codigo = ?");
    $stmt->execute([$codigo]);
    header("Location: listar_marcas.php");
    exit;
}

// --- EDITAR MARCA ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $codigo = $_POST['marca_codigo'];
    $descricao = $_POST['marca_descricao'];

    $stmt = $pdo->prepare("UPDATE tbmarca SET marca_descricao = ? WHERE marca_codigo = ?");
    $stmt->execute([$descricao, $codigo]);
    header("Location: listar_marcas.php");
    exit;
}

// --- LISTAR MARCAS ---
$marcas = Marca::listar($pdo);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
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

<h2 style="text-align:center;">Marcas Cadastradas</h2>

<table>
    <tr>
        <th>Código</th>
        <th>Descrição</th>
        <th>Editar</th>
        <th>Excluir</th>
    </tr>

    <?php foreach($marcas as $m): ?>
        <tr>
            <form method="post">
                <td><?= $m['marca_codigo'] ?>
                    <input type="hidden" name="marca_codigo" value="<?= $m['marca_codigo'] ?>">
                </td>
                <td>
                    <input type="text" name="marca_descricao" value="<?= htmlspecialchars($m['marca_descricao']) ?>">
                </td>
                <td>
                    <button type="submit" name="editar">Salvar</button>
                </td>
                <td>
                    <a href="?deletar=<?= $m['marca_codigo'] ?>" class="btn-delete"
                       onclick="return confirm('Deseja realmente excluir esta marca?')">Excluir</a>
                </td>
            </form>
        </tr>
    <?php endforeach; ?>

</table>

</body>
</html>
