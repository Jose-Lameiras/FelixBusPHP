<?php
session_start();
include('../basedados/basedados.h');

// Verifica se é administrador (tipo 1)
if ($_SESSION["tipoUtilizador"] != 1) {
    header("Location: Logout.php");
    
}

?>



<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Utilizador Editado</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }
    .message-box {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
      text-align: center;
    }
    h1 {
      color: #4CAF50;
    }
    .btn {
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      display: inline-block;
    }
    .btn:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>

<div class="message-box">
  <h1>Utilizador editado com sucesso!</h1>
  <a href="AdminGerirUtilizadores.php" class="btn">Voltar à gestão</a>
</div>

</body>
</html>
