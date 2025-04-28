# Sistema Autolocadora

Este é um sistema simples de uma **Autolocadora** desenvolvido em PHP, que permite realizar o cadastro de clientes, veículos e locações, além de exibir a lista de veículos disponíveis e locados.

## Instruções para Rodar o Projeto

### 1. Banco de Dados

Para rodar o sistema corretamente, você deve importar o arquivo **`bdautolocadora (1).sql`** para o seu banco de dados MySQL.

- **Passo 1:** Crie um banco de dados no MySQL chamado `bdautolocadora`.
- **Passo 2:** Importe o arquivo **`bdautolocadora (1).sql`** para esse banco de dados. O arquivo SQL contém a estrutura das tabelas necessárias para o funcionamento do sistema.

### 2. Configuração do Banco de Dados

No arquivo `db/conexao.php`, você encontrará as configurações de conexão com o banco de dados. Certifique-se de que as credenciais estão corretas para o seu ambiente:

```php
<?php
$host = 'localhost'; // Host do banco de dados
$dbname = 'bdautolocadora'; // Nome do banco de dados
$username = 'root'; // Usuário do banco de dados
$password = ''; // Senha do banco de dados

// Conexão PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>
