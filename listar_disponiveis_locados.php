<?php
require 'db/conexao.php'; 


$sql = "SELECT veiculo_placa, marca_descricao, veiculo_status
        FROM tbveiculo v
        JOIN tbmarca m ON v.veiculo_marca = m.marca_codigo";
$stmt = $pdo->query($sql);
$veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);


function verificarDisponibilidade($veiculo_placa, $data_inicio, $data_fim, $pdo) {
    
    $sql = "SELECT * FROM tblocacao WHERE locacao_veiculo = :veiculo 
            AND (locacao_data_inicio <= :data_fim AND locacao_data_fim >= :data_inicio)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':veiculo', $veiculo_placa);
    $stmt->bindParam(':data_inicio', $data_inicio);
    $stmt->bindParam(':data_fim', $data_fim);
    $stmt->execute();
    
    return $stmt->rowCount() === 0; 
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veículos Disponíveis / Locados</title>
    <link rel="stylesheet" href="css/Style.css">
</head>

<body>
    <h1>Veículos Disponíveis / Locados</h1>
    <center>
    <table class="tabela">
        <thead>
            <tr>
                <th>Placa</th>
                <th>Marca</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($veiculos as $v): ?>
                <?php
                    
                    $data_inicio = '2025-05-01'; 
                    $data_fim = '2025-05-05'; 
                    
                    $disponivel = verificarDisponibilidade($v['veiculo_placa'], $data_inicio, $data_fim, $pdo);
                    $status = $disponivel ? "Disponível" : "Indisponível";
                ?>
                <tr>
                    <td><?= htmlspecialchars($v['veiculo_placa']) ?></td>
                    <td><?= htmlspecialchars($v['marca_descricao']) ?></td>
                    <td><?= htmlspecialchars($status) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </center>
</body>
</html>
