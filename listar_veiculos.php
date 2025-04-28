<?php
require 'db/conexao.php';
require 'classes/Veiculo.php';
$veiculos = Veiculo::listar($pdo);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/Style.css">
</head>
<body>


    <table>
        <tr><th>Placa</th><th>Marca</th><th>Descrição</th></tr>
        <?php foreach($veiculos as $v): ?>
            <tr>
                <td><?= $v['veiculo_placa'] ?></td>
                <td><?= $v['marca_descricao'] ?></td>
                <td><?= $v['veiculo_descricao'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
