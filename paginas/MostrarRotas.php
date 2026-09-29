<?php
session_start();
include('../basedados/basedados.h');

// Verifica se os parâmetros existem
if (!isset($_GET['id_origem']) || !isset($_GET['id_destino'])) {
  echo "Parâmetros de origem e destino em falta.";
  exit;
}

$id_origem = intval($_GET['id_origem']);
$id_destino = intval($_GET['id_destino']);

// Buscar nome da origem
$sql_origem = "SELECT nome_cidade FROM cidades WHERE id_cidade = $id_origem";
$result_origem = mysqli_query($conn, $sql_origem);
$nome_origem = "Desconhecida";
if ($row = mysqli_fetch_assoc($result_origem)) {
  $nome_origem = $row['nome_cidade'];
}

// Buscar nome do destino
$sql_destino = "SELECT nome_cidade FROM cidades WHERE id_cidade = $id_destino";
$result_destino = mysqli_query($conn, $sql_destino);
$nome_destino = "Desconhecida";
if ($row = mysqli_fetch_assoc($result_destino)) {
  $nome_destino = $row['nome_cidade'];
}

// Buscar horários disponíveis para a rota
$sql = "
  SELECT h.data, h.hora_partida, h.hora_chegada, h.lugares_disponiveis, 
         r.preco, r.id_rota 
  FROM horarios h
  JOIN rotas r ON h.id_rota = r.id_rota
  WHERE r.id_origem = $id_origem
    AND r.id_destino = $id_destino
  ORDER BY h.data, h.hora_partida
";
$result = mysqli_query($conn, $sql);


?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <title>Horários Disponíveis</title>
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
    body {
      font-family: Arial, sans-serif;
      background: #eef2f7;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
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

    .container {
      margin: 100px auto;
      width: 90%;
      max-width: 900px;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: center;
    }

    th {
      background-color: hsl(122, 39.40%, 49.20%);
      color: white;
    }

    h2 {
      text-align: center;
      color: #333;
    }

    .comprar-btn {
            padding: 6px 18px;
            background: hsl(122, 39.40%, 49.20%);
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .comprar-btn:hover {
            background: #0056b3;
        }

    .no-data {
      text-align: center;
      color: red;
    }
  </style>
</head>

<body>

  <div class="navbar">
    <div class="nav-left">Sistema de Reservas</div>
    <div class="nav-right">
      <a href="index.php">Início</a>
      <a href="login.php">Login</a>
      <a href="registo.php">Registar</a>
    </div>
  </div>

  <div class="container">
    <h2>Horários de <strong><?php echo $nome_origem; ?></strong> para <strong><?php echo $nome_destino; ?></strong></h2>

    <table>
      <tr>
        <th>Data</th>
        <th>Partida</th>
        <th>Chegada</th>
        <th>Lugares Disponíveis</th>
        <th>Preço</th>
      </tr>
      
      <?php while ($horario = mysqli_fetch_assoc($result)) { ?>
  <tr>
    <form method="post">
      <td><?php echo $horario['data']; ?></td>
      <td><?php echo $horario['hora_partida']; ?></td>
      <td><?php echo $horario['hora_chegada']; ?></td>
      <td><?php echo $horario['lugares_disponiveis']; ?></td>
      <td><?php echo $horario['preco']; ?> €</td>

    </form>
  </tr>
<?php } ?>

      
    </table>
  </div>

</body>

</html>