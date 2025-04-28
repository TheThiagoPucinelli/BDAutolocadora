<?php
require 'db/conexao.php';
require 'classes/Marca.php';
$marcas = Marca::listar($pdo);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/Style.css">
</head>
<body>


    <table>
        <tr><th>Código</th><th>Descrição</th></tr>
        <?php foreach($marcas as $m): ?>
            <tr>
                <td><?= $m['marca_codigo'] ?></td>
                <td><?= $m['marca_descricao'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
