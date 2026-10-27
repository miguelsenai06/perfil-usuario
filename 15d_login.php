ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$senha = "SUA_SENHA_MYSQL";
$banco = "desafio15d";

$erro = "";

try {
    $conn = new mysqli($servidor, $usuario, $senha, $banco);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Erro ao conectar com o banco de dados.");
}

// Configuração inicial da senha do usuário já cadastrado.
// Acesse uma única vez com ?configurar=1.
// REMOVA este bloco após configurar.
if (isset($_GET["configurar"]) && $_GET["configurar"] === "1") {
    $email = "miguel@teste.com";
    $novaSenha = password_hash("Teste@123", PASSWORD_DEFAULT);

    $sql = $conn->prepare(
        "UPDATE usuarios SET senha = ? WHERE email = ?"
    );

    $sql->bind_param("ss", $novaSenha, $email);
    $sql->execute();

    if ($sql->affected_rows > 0) {
        exit("Senha configurada com sucesso!");
    }

    exit("Usuário não encontrado ou senha já configurada.");
}

// Verifica se o usuário já está logado
if (isset($_SESSION["usuario_id"])) {
    header("Location: 15d_perfil.php");
    exit();
}

// Processa o login
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $senhaDigitada = $_POST["senha"] ?? "";

    $sql = $conn->prepare(
        "SELECT id, nome, senha FROM usuarios WHERE email = ?"
    );

    $sql->bind_param("s", $email);
    $sql->execute();

    $resultado = $sql->get_result();
    $dados = $resultado->fetch_assoc();

    if ($dados && password_verify($senhaDigitada, $dados["senha"])) {
        session_regenerate_id(true);

        $_SESSION["usuario_id"] = $dados["id"];
        $_SESSION["usuario_nome"] = $dados["nome"];

        header("Location: 15d_perfil.php");
        exit();
    }

    $erro = "E-mail ou senha incorretos!";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Desafio 3</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eaf0f8;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login {
            background: white;
            padding: 35px;
            width: 320px;
            border-radius: 12px;
            box-shadow: 0 4px 20px #0002;
        }

        h1 {
            text-align: center;
            color: #1e293b;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input, button {
            box-sizing: border-box;
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border-radius: 6px;
        }

        input {
            border: 1px solid #ccc;
        }

        button {
            background: #2563eb;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background: #1d4ed8;
        }

        .erro {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="login">
        <h1>Login do Sistema</h1>

        <?php if ($erro !== ""): ?>
            <p class="erro">
                <?php echo htmlspecialchars($erro); ?>
            </p>
        <?php endif; ?>

        <form method="POST">
            <label>E-mail:</label>
            <input type="email" name="email" required>

            <label>Senha:</label>
            <input type="password" name="senha" required>

            <button type="submit">Entrar</button>
        </form>
    </div>

</body>
</html>
