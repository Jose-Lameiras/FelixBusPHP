<?php
session_start();
$_SESSION = array();
session_destroy();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Logout Bem-Sucedido</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .logout-container {
      background: #ffffff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      text-align: center;
    }

    h1 {
      color: #333;
      margin-bottom: 20px;
    }

    .back-button {
      padding: 12px 24px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
    }

    .back-button:hover {
      background-color: #43a047;
    }
  </style>
</head>
<body>

  <div class="logout-container">
    <h1>Logout efetuado com sucesso!</h1>
    <a href="index.php" class="back-button">Voltar à Página Inicial</a>
  </div>

</body>
</html>
