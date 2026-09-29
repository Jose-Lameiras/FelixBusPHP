<?php
session_start();

// Verifica se o utilizador está autenticado e é funcionário
if ($_SESSION["tipoUtilizador"] != 4) {
    header("Location: logout.php");
}

if (isset($_POST['logout'])) {
  session_destroy();
  header("Location: Logout.php");
} else if (isset($_POST['gerir_perfil'])) {
  header("Location: FuncionarioGerirPerfil.php");
} else if (isset($_POST['gerir_carteiras'])) {
  header("Location: FuncionarioGerirCarteiras.php");
}elseif (isset($_POST['gerir_bilhetes'])) {
  header("Location: FuncionarioGerirBilhetes.php");
} else if (isset($_POST['gerir_rotas'])) {
  header("Location: FuncionarioGerirRotas.php");
}

?>
<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <title>Página Inicial Funcionario</title>
  <style>
    /* 1) Reset básico para evitar offsets inesperados */
    *,
    *::before,
    *::after {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* 2) Corpo da página como flex container, centrando tudo */
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 100px;
      /* espaço para a navbar fixa */
      min-height: 100vh;
    }

    /* 3) Navbar fixa no topo */
    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background-color: hsl(122, 39.40%, 49.20%);
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
      z-index: 1000;
    }

    .navbar a {
      color: white;
      text-decoration: none;
      margin-left: 20px;
      font-weight: bold;
    }

    .navbar a:hover {
      text-decoration: underline;
    }

    /* 4) Título principal */
    h1 {
      color: #333;
      margin-bottom: 40px;
      text-align: center;
    }

    /* 5) Container dos botões */
    .button-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 15px;
      width: 100%;
      max-width: 350px;
    }

    /* 6) Estilo dos botões */
    .admin-button,
    .logout-button {
      width: 100%;
      padding: 12px 24px;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      color: white;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .admin-button {
      background-color: hsl(122, 39.40%, 49.20%);
    }

    .admin-button:hover {
      background-color: #0056b3;
    }

    .logout-button {
      background-color: #dc3545;
    }

    .logout-button:hover {
      background-color: #a71d2a;
    }
  </style>
</head>

<body>

    <div class="navbar">
        <div class="nav-left">Página Inicial Funcionario</div>
        <div class="nav-right">
            <a href="Index.php">Voltar</a>
            <a href="logout.php">Log Out</a>
        </div>
    </div>

    <h1>Página Inicial Funcionario</h1>

    <form method="post">
        <div class="button-container">
            <button type="submit" class="admin-button" name="gerir_carteiras">Gerir Carteiras</button>
            <button type="submit" class="admin-button" name="gerir_perfil">Gerir Perfil</button>

            <button type="submit" class="admin-button" name="gerir_bilhetes">Gerir Bilhetes</button>
        </div>
    </form>
</body>

</html>