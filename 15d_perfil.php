
<?php
session_start();

// Protege a página
if (!isset($_SESSION["usuario_id"])) {
    header("Location: 15d_login.php");
    exit();
}

$servidor = "localhost";
$usuario = "root";
$senha = "SUA_SENHA_MYSQL";
$banco = "desafio15d";

try {
    $conn = new mysqli($servidor, $usuario, $senha, $banco);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Erro ao conectar com o banco de dados.");
}

$id = (int) $_SESSION["usuario_id"];

// Salva a cor escolhida
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cor = $_POST["cor"] ?? "";

    if (preg_match('/^#[0-9a-fA-F]{6}$/', $cor)) {
        $sql = $conn->prepare(
            "UPDATE usuarios SET cor_fundo = ? WHERE id = ?"
        );

        $sql->bind_param("si", $cor, $id);
        $sql->execute();
    }

    header("Location: 15d_perfil.php");
    exit();
}

// Busca os dados do usuário
$sql = $conn->prepare(
    "SELECT nome, email, cor_fundo FROM usuarios WHERE id = ?"
);

$sql->bind_param("i", $id);
$sql->execute();

$resultado = $sql->get_result();
$dados = $resultado->fetch_assoc();

if (!$dados) {
    header("Location: 15d_logout.php");
    exit();
}

$cor = $dados["cor_fundo"] ?: "#eaf0f8";

if (!preg_match('/^#[0-9a-fA-F]{6}$/', $cor)) {
    $cor = "#eaf0f8";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil</title>

    <style>
        body {
            background-color: <?php echo $cor; ?>;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .perfil {
            background: white;
            padding: 40px;
            border-radius: 15px;
            width: 350px;
            text-align: center;
            box-shadow: 0 5px 20px #0002;
        }

        h1 {
            color: #2563eb;
        }

        button {
            background: #2563eb;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        input[type="color"] {
            width: 100px;
            height: 50px;
            cursor: pointer;
        }

        .sair {
            display: inline-block;
            margin-top: 25px;
            color: red;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="perfil">
        <h1>Meu Perfil</h1>

        <h2>
            Bem-vindo,
            <?php echo htmlspecialchars($dados["nome"]); ?>!
        </h2>

        <p>
            <strong>E-mail:</strong>
            <?php echo htmlspecialchars($dados["email"]); ?>
        </p>

        <h3>Personalizar cor de fundo</h3>

        <form method="POST">
            <input
                type="color"
                name="cor"
                value="<?php echo htmlspecialchars($cor); ?>"
            >

            <br><br>

            <button type="submit">Salvar Cor</button>
        </form>

        <a class="sair" href="15d_logout.php">
            Sair do Sistema
        </a>
    </div>

</body>
</html>
