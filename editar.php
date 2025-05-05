<?php
require 'db/conexao.php';
require 'classes/Cliente.php';
require 'classes/Locacao.php';
require 'classes/Veiculo.php';
require 'classes/Marca.php';

// Deletar locação e dados relacionados se parâmetro 'deletar' estiver presente
if (isset($_GET['deletar'])) {
    $codigo = $_GET['deletar'];

    try {
        // Inicia uma transação
        $pdo->beginTransaction();

        // 1. Buscar o CPF do cliente e a placa do veículo relacionados à locação
        echo "Buscando dados relacionados à locação... <br>";  // Debug
        $stmt = $pdo->prepare("SELECT locacao_cliente, locacao_veiculo FROM tblocacao WHERE locacao_codigo = ?");
        $stmt->execute([$codigo]);
        $dados_locacao = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dados_locacao) {
            echo "Nenhuma locação encontrada com o código $codigo <br>";  // Debug
            exit;
        }

        $cliente_cpf = $dados_locacao['locacao_cliente'];
        $veiculo_placa = $dados_locacao['locacao_veiculo'];

        // 2. Deletar da tabela de locação (tblocacao)
        echo "Deletando locação com código: $codigo <br>";  // Debug
        $stmt_locacao = $pdo->prepare("DELETE FROM tblocacao WHERE locacao_codigo = ?");
        $stmt_locacao->execute([$codigo]);

        // 3. Deletar o cliente, se não houver mais locações associadas a ele
        echo "Deletando cliente com CPF: $cliente_cpf <br>";  // Debug
        $stmt_cliente = $pdo->prepare("DELETE FROM tbcliente WHERE cliente_cpf = ?");
        $stmt_cliente->execute([$cliente_cpf]);

        // 4. Deletar o veículo, se não houver mais locações associadas a ele
        echo "Deletando veículo com placa: $veiculo_placa <br>";  // Debug
        $stmt_veiculo = $pdo->prepare("DELETE FROM tbveiculo WHERE veiculo_placa = ?");
        $stmt_veiculo->execute([$veiculo_placa]);

        // 5. Deletar a marca, se o veículo foi deletado
        $stmt_veiculo_info = $pdo->prepare("SELECT veiculo_marca FROM tbveiculo WHERE veiculo_placa = ?");
        $stmt_veiculo_info->execute([$veiculo_placa]);
        $veiculo_info = $stmt_veiculo_info->fetch(PDO::FETCH_ASSOC);

        if ($veiculo_info) {
            $marca_codigo = $veiculo_info['veiculo_marca'];
            echo "Deletando marca com código: $marca_codigo <br>";  // Debug
            $stmt_marca = $pdo->prepare("DELETE FROM tbmarca WHERE marca_codigo = ?");
            $stmt_marca->execute([$marca_codigo]);
        }

        // Commit da transação
        $pdo->commit();

        // Redireciona após a exclusão com mensagem de sucesso
        echo "Deleção bem-sucedida! <br>";  // Debug
        header("Location: listar_locacoes.php?msg=apagado");
        exit;

    } catch (Exception $e) {
        // Se ocorrer algum erro, rollback a transação
        $pdo->rollBack();
        echo "Erro ao deletar: " . $e->getMessage();  // Exibe erro para debug
        exit;
    }
}

// Consulta para listar as locações
$sql_locacao = "SELECT l.locacao_codigo, l.locacao_data_inicio, l.locacao_data_fim, 
                       c.cliente_nome, v.veiculo_placa, v.veiculo_descricao, m.marca_descricao
                FROM tblocacao l
                JOIN tbcliente c ON l.locacao_cliente = c.cliente_cpf
                JOIN tbveiculo v ON l.locacao_veiculo = v.veiculo_placa
                JOIN tbmarca m ON v.veiculo_marca = m.marca_codigo";
$stmt_locacao = $pdo->query($sql_locacao);
$locacoes = $stmt_locacao->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Locações</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Locações Cadastradas</h1>
    <table>
        <tr>
            <th>Código</th>
            <th>Cliente</th>
            <th>Veículo</th>
            <th>Marca</th>
            <th>Descrição</th>
            <th>Início</th>
            <th>Fim</th>
            <th>Editar</th>
            <th>Deletar</th>
        </tr>
        <?php foreach ($locacoes as $l): ?>
            <tr>
                <td><?= $l['locacao_codigo'] ?></td>
                <td><?= htmlspecialchars($l['cliente_nome']) ?></td>
                <td><?= htmlspecialchars($l['veiculo_placa']) ?></td>
                <td><?= htmlspecialchars($l['marca_descricao']) ?></td>
                <td><?= htmlspecialchars($l['veiculo_descricao']) ?></td>
                <td><?= htmlspecialchars($l['locacao_data_inicio']) ?></td>
                <td><?= htmlspecialchars($l['locacao_data_fim']) ?></td>
                <td>
                    <a href="editar.php?codigo=<?= $l['locacao_codigo'] ?>">Editar</a>
                </td>
                <td>
                    <!-- Formulário para deletar locação -->
                    <a href="?deletar=<?= $l['locacao_codigo'] ?>" 
                       onclick="return confirm('Deseja deletar esta locação e todos os dados relacionados?')">Deletar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
