<?php
session_start();
include('../basedados/basedados.h');

if (isset($_GET['id_rota'])) {
    $_SESSION['id_rota'] = $_GET['id_rota'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $EMAIL = $_POST["email"];
    $PASSWORD = $_POST["password"];

    // Vai buscar o utilizador com esse email
    $sql = "SELECT * FROM utilizador WHERE mail = '$EMAIL'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Verifica a password com MD5
    if (md5($PASSWORD) == $row["pass"]) {

        // Guarda na sessão
        $_SESSION["id_utilizador"] = $row["id_utilizador"];
        $_SESSION["nomeUtilizador"] = $row["nomeUtilizador"];
        $_SESSION["mail"] = $row["mail"];
        $_SESSION["pass"] = $row["pass"];
        $_SESSION["telemovel"] = $row["telemovel"];
        $_SESSION["tipoUtilizador"] = $row["tipoUtilizador"];


            switch ($_SESSION["tipoUtilizador"]) {
                case "1": header("Location: PagIniAdmin.php"); break;
                case "2": header("Location: PagIniCliente.php"); break;
                case "3": header("Location: PagIniClienteNaoValidado.php"); break;
                case "4": header("Location: PagIniFuncionario.php"); break;
                case "5": header("Location: PagIniMotorista.php"); break;
                default:  header("Location: index.php");
            }
            exit;
        }

    } else {
        $error = "Email ou palavra-passe inválidos.";
    }
  }
 
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #eef2f7;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
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
          padding-top: 100px;   /* espaço para a navbar fixa */
          min-height: 100vh;
        }
     /* NAVBAR */
     .navbar {
      position: fixed;
      top: 0;
      width: 100%;
      background-color:hsl(122, 39.40%, 49.20%);
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
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

    .nav-left {
      font-size: 18px;
      font-weight: bold;
    }

    /* CONTAINER */
    .container {
      background: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      width: 350px;
      margin: 120px auto; /* distância da navbar */
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .buttons {
      display: flex;
      justify-content: space-between;
      margin-bottom: 30px;
    }

    button {
      width: 48%;
      padding: 10px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }


    .login-container {
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      width: 350px;
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
    }

    label {
      display: block;
      margin-top: 15px;
      margin-bottom: 5px;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #4CAF50;
      border: none;
      color: white;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 20px;
    }

    button:hover {
      background-color: #43a047;
    }
  </style>
</head>
<body>
  <div class="navbar">
    <div class="nav-left">Sistema de Reservas</div>
    <div class="nav-right">
      <a href="registo.php">Registar</a>
    </div>
  </div>

  <div class="login-container">
    <h2>Login</h2>
    <form action="login.php" method ="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Palavra-passe:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Entrar</button>
    </form>
  </div>
</body>
</html>
