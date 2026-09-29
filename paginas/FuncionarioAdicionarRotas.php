<?php
session_start();
include('../basedados/basedados.h');


if ($_SESSION["tipoUtilizador"] != 4) {
  header("Location: Logout.php");
  exit();
}

// Buscar todas as cidades
$cidade_sql = "SELECT * FROM cidades";
$cidade_result = mysqli_query($conn, $cidade_sql);
$cidades = [];
while ($cidade = mysqli_fetch_assoc($cidade_result)) {
  $cidades[] = $cidade;
}

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $novaOrigem = intval($_POST['id_origem']);
  $novoDestino = intval($_POST['id_destino']);
  $novoPreco = floatval($_POST['preco']);
  $data = $_POST['data'];
  $hora_partida = $_POST['hora_partida'];
  $hora_chegada = $_POST['hora_chegada'];
  $lugares_disponiveis = intval($_POST['lugares_disponiveis']);

  if ($novaOrigem == $novoDestino) {
    echo "<script>alert('A origem e o destino não podem ser iguais.');</script>";
  } else {
    // Inserir nova rota
    $insert_rota_sql = "INSERT INTO rotas (id_origem, id_destino, preco) VALUES (?, ?, ?)";
    $stmt_rota = mysqli_prepare($conn, $insert_rota_sql);
    mysqli_stmt_bind_param($stmt_rota, "iid", $novaOrigem, $novoDestino, $novoPreco);

    if (mysqli_stmt_execute($stmt_rota)) {
      $nova_rota_id = mysqli_insert_id($conn);

      // Inserir novo horário para a nova rota
      $insert_horario_sql = "INSERT INTO horarios (id_rota, data, hora_partida, hora_chegada, lugares_disponiveis) VALUES (?, ?, ?, ?, ?)";
      $stmt_horario = mysqli_prepare($conn, $insert_horario_sql);
      mysqli_stmt_bind_param($stmt_horario, "isssi", $nova_rota_id, $data, $hora_partida, $hora_chegada, $lugares_disponiveis);

      if (mysqli_stmt_execute($stmt_horario)) {
        echo "<script>alert('Rota e horário adicionados com sucesso!'); window.location.href='FuncionarioGerirRotas.php';</script>";
        exit();
      } else {
        echo "<script>alert('Erro ao adicionar horário: " . mysqli_error($conn) . "');</script>";
      }
    } else {
      echo "<script>alert('Erro ao adicionar rota: " . mysqli_error($conn) . "');</script>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <title>Adicionar Nova Rota e Horário</title>
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
          padding-top: 100px;   /* espaço para a navbar fixa */
          min-height: 100vh;
        }
    body {
      font-family: Arial, sans-serif;
      padding-top: 100px;
      background-color: #f4f4f4;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

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

    form {
      width: 100%;
      max-width: 500px;
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    label {
      margin-top: 15px;
      display: block;
      font-weight: bold;
    }

    input,
    select {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border-radius: 4px;
      border: 1px solid #ccc;
    }

    .btn {
      margin-top: 20px;
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      border-radius: 4px;
    }

    .save-btn {
      background-color: #4CAF50;
      color: white;
    }

    .back-btn {
      background-color: #ccc;
      color: black;
      margin-left: 10px;
    }
  </style>
</head>

<body>
  <div class="navbar">
    <div class="nav-left">Adicionar Nova Rota e Horário - Funcionario</div>
    <div class="nav-right">
      <a href="FuncionarioGerirRotas.php">Voltar</a>
      <a href="logout.php">Log Out</a>
    </div>
  </div>

  <form method="POST">
    <label>Origem</label>
    <select name="id_origem" required>
      <?php foreach ($cidades as $cidade): ?>
        <option value="<?= $cidade['id_cidade'] ?>">
          <?= $cidade['nome_cidade'] ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label>Destino</label>
    <select name="id_destino" required>
      <?php foreach ($cidades as $cidade): ?>
        <option value="<?= $cidade['id_cidade'] ?>">
          <?= $cidade['nome_cidade'] ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label>Preço</label>
    <input type="number" step="0.01" name="preco" required>

    <hr>
    <label>Data do horário</label>
    <input type="date" name="data" required>

    <label>Hora de partida</label>
    <input type="time" name="hora_partida" required>

    <label>Hora de chegada</label>
    <input type="time" name="hora_chegada" required>

    <label>Lugares disponíveis</label>
    <input type="number" name="lugares_disponiveis" min="1" max="100" required>

    <button class="btn save-btn" type="submit">Adicionar Rota e Horário</button>
  </form>

</body>

</html>