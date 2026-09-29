<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Registo Bem-Sucedido</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #eaf4fc;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .success-container {
      background: #ffffff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      text-align: center;
    }

    h1 {
      color: #2e7d32;
      margin-bottom: 20px;
    }

    button {
      padding: 12px 24px;
      background-color:hsl(122, 39.40%, 49.20%);
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 20px;
    }

    button:hover {
      background-color:hsl(122, 39.40%, 49.20%);
    }
  </style>
</head>
<body>

  <div class="success-container">
    <h1>Utilizador registado com sucesso!</h1>
    <form action="index.php" method="get">
      <button type="submit">Voltar para o Início</button>
    </form>
  </div>

</body>
</html>
