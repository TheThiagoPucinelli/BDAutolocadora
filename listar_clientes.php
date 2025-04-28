<?php
require 'db/conexao.php';
require 'classes/Cliente.php';
$clientes = Cliente::listar($pdo);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        table {
            width:90%;
            margin:20px auto;
            border-collapse:collapse;
        }
        th, td {
            padding:8px;
            border:1px solid #ccc;
            text-align:left;
        }
        th {
            background:#f8b500;
            color:#fff;
        }
    </style>
</head>
<body>

    <table>
        <tr><th>CPF</th><th>Nome</th><th>Endereço</th></tr>
        <?php foreach($clientes as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['cliente_cpf']) ?></td>
                <td><?= htmlspecialchars($c['cliente_nome']) ?></td>
                <td><?= htmlspecialchars($c['cliente_endereco']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
