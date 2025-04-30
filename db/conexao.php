<?php
// Configurações do banco de dados
$host = 'localhost';     // Endereço do servidor MySQL
$db   = 'bdautolocadora'; // Nome do banco de dados
$user = 'root';          // Usuário do banco
$pass = '';              // Senha do banco (vazia para localhost)



// Bloco try/catch para tratar possíveis erros de conexão
try {
    // Cria uma nova conexão PDO com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=latin1", $user, $pass);

    // Define que os erros do PDO serão tratados como exceções
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Se ocorrer um erro, exibe uma mensagem e encerra o script
    die("Erro de conexão: " . $e->getMessage());
}
