<?php
// Conecta ao banco de dados
require 'db/conexao.php';
// Inclui a classe Cliente
require 'classes/Cliente.php';

// Chama o método 'listar' para obter todos os clientes cadastrados no banco
$clientes = Cliente::listar($pdo);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    </head>

    
<body>

    <!-- Tabela para exibir os clientes cadastrados -->
    <table>
        <tr>
            <th>CPF</th>
            <th>Nome</th>
            <th>Endereço</th>
        </tr>
        <!-- Preenche a tabela com os dados dos clientes -->
        <?php foreach($clientes as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['cliente_cpf']) ?></td>  <!-- Exibe o CPF do cliente -->
                <td><?= htmlspecialchars($c['cliente_nome']) ?></td> <!-- Exibe o nome do cliente -->
                <td><?= htmlspecialchars($c['cliente_endereco']) ?></td> <!-- Exibe o endereço do cliente -->
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
