<?php
session_start();
include('../basedados/basedados.h');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $NOME = $_SESSION["nome"] = $_POST["nome"];
  $EMAIL = $_SESSION["email"] = $_POST["email"];
  $TELEFONE = $_SESSION["telefone"] = $_POST["telefone"];
  $PASSWORD = $_SESSION["senha"] = $_POST["senha"];

  // Hashear a palavra-passe antes de guardar na base de dados
  $HASHED_PASSWORD = md5($PASSWORD);


  // Query com password já encriptada
  $sql = "INSERT INTO utilizador (nomeUtilizador, mail, pass, telemovel, tipoUtilizador)
          VALUES ('$NOME', '$EMAIL', '$HASHED_PASSWORD', '$TELEFONE', 3)";

  try {
    mysqli_query($conn, $sql);
    header("Location: registado.php");
  } catch (mysqli_sql_exception) {
    echo "Não foi possível registar";
  }
}
?>


<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Registo</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f4f8;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .register-container {
      background: #ffffff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      width: 400px;
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

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="tel"] {
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
  <div class="register-container">
    <h2>Formulário de Registo</h2>
      <form action="registo.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" placeholder="Ex: 912345678" required pattern="[0-9]{9}">

        <label for="senha">Palavra-passe:</label>
        <input type="password" id="senha" name="senha" required>

        <button type="submit">Registar</button>
      </form>
  </div>
</body>
</html>


