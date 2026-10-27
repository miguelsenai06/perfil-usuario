
<?php
session_start();

// Remove as informações da sessão
$_SESSION = [];

// Remove o cookie da sessão
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        "",
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Encerra a sessão
session_destroy();

// Volta para o login
header("Location: 15d_login.php");
exit();
?>
