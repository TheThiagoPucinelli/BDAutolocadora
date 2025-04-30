<?php
// Conecta ao banco de dados
require 'db/conexao.php';


require 'classes/Veiculo.php'; // Inclui a classe Veiculo, que contém métodos para interagir com o banco de dados


$veiculos = Veiculo::listar($pdo); // Chama o método 'listar' da classe Veiculo para obter todos os veículos cadastrados
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

        <!-- Loop PHP para percorrer todos os veículos e exibir seus dados na tabela -->
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
