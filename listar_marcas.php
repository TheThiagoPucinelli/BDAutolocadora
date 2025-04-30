<?php
// Conecta ao banco de dados
require 'db/conexao.php';


require 'classes/Marca.php'; // Inclui a classe Marca, que contém métodos para interagir com o banco de dados


$marcas = Marca::listar($pdo); // Chama o método 'listar' da classe Marca para obter todas as marcas cadastradas
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

        <!-- Loop PHP para percorrer todas as marcas e exibir seus dados na tabela -->
        <?php foreach($marcas as $m): ?>
            <tr>
               
                <td><?= $m['marca_codigo'] ?></td>  <!-- Exibe o código da marca na primeira coluna -->
                
                <td><?= $m['marca_descricao'] ?></td> <!-- Exibe a descrição da marca na segunda coluna -->
            </tr>
        <?php endforeach; ?>

    </table>

</body>
</html>
