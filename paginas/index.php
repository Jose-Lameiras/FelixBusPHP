<?php
include('../basedados/basedados.h');
session_start();

// Verifica se o utilizador já está autenticado
if (isset($_SESSION['id_utilizador']) > 0) {
  header("Location: Logout.php");
  exit;
}

// Buscar cidades
$cidades = [];
$cidade_sql = "SELECT * FROM cidades";
$cidade_result = mysqli_query($conn, $cidade_sql);
while ($cidade = mysqli_fetch_assoc($cidade_result)) {
  $cidades[] = $cidade;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_origem = intval($_POST["id_origem"]);
  $id_destino = intval($_POST["id_destino"]);

  //  Adiciona esta verificação aqui
  if ($id_origem === $id_destino) {
    echo "<script>alert('A origem e o destino não podem ser iguais.');</script>";
    exit;
  }

  $sql = "
        SELECT h.id_horario
        FROM horarios h
        JOIN rotas r ON h.id_rota = r.id_rota
        WHERE r.id_origem = $id_origem
          AND r.id_destino = $id_destino
          AND h.lugares_disponiveis > 0
    ";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    header("Location: MostrarRotas.php?id_origem=$id_origem&id_destino=$id_destino");
    exit;
  } else {
    echo "<script>alert('Não encontrámos nenhum horário disponível para essa rota.');</script>";
  }
}

?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <title>Sistema de Reservas</title>
  <style>
    /* ... (mantém o seu CSS) ... */
    * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background: #e3eaf2;
      margin: 0;
      padding: 0;
    }

    .navbar {
      position: fixed;
      top: 0;
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

    .nav-left {
      font-size: 18px;
      font-weight: bold;
    }

    .container {
      background: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      width: 350px;
      margin: 120px auto;
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
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      background-color: hsl(122, 39.40%, 49.20%);
      color: white;
    }

    .form-section {
      margin-top: 20px;
    }

    label {
      display: block;
      margin-top: 15px;
      margin-bottom: 5px;
    }

    select {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
  </style>
</head>

<body>

  <!-- NAVBAR -->
  <div class="navbar">
    <div class="nav-left">Sistema de Reservas</div>
    <div class="nav-right">
      <a href="login.php">Login</a>
      <a href="registo.php">Registar</a>
      <a href="contactos.php">Contactos</a>
    </div>
  </div>

  <!-- CONTEÚDO -->
  <div class="container">
    <h2>Bem-vindo</h2>
    <form method="POST" action="">
      <label>Origem</label>
      <select name="id_origem" required>
        <?php foreach ($cidades as $cidade): ?>
          <option value="<?php echo $cidade['id_cidade']; ?>">
            <?php echo $cidade['nome_cidade']; ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label>Destino</label>
      <select name="id_destino" required>
        <?php foreach ($cidades as $cidade): ?>
          <option value="<?php echo $cidade['id_cidade']; ?>">
            <?php echo $cidade['nome_cidade']; ?>
          </option>
        <?php endforeach; ?>
      </select>

      <button class="reserve-btn" type="submit">Procurar Horários</button>
    </form>
  </div>
</body>

</html>