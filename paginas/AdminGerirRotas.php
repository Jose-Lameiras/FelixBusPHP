<?php
session_start();
include('../basedados/basedados.h');

// Verifica se é administrador
if ($_SESSION["tipoUtilizador"] != 1) {
  header("Location: Logout.php");
  exit();
}


$sql = "SELECT r.id_rota, 
          o.nome_cidade AS origem,
          d.nome_cidade AS destino,
          h.data,
          h.lugares_disponiveis,
          h.hora_partida,
          h.hora_chegada,
          r.preco
FROM rotas r
JOIN cidades o ON r.id_origem = o.id_cidade
JOIN cidades d ON r.id_destino = d.id_cidade
LEFT JOIN horarios h ON r.id_rota = h.id_rota";



$result = mysqli_query($conn, $sql);



if (isset($_GET['delete'])) {
    $idToDelete = intval($_GET['delete']);

    // Eliminar horários associados à rota
    $stmtH = mysqli_prepare($conn, "DELETE FROM horarios WHERE id_rota = ?");
    mysqli_stmt_bind_param($stmtH, "i", $idToDelete);
    mysqli_stmt_execute($stmtH);

    // Eliminar a rota
    $stmt = mysqli_prepare($conn, "DELETE FROM rotas WHERE id_rota = ?");
    mysqli_stmt_bind_param($stmt, "i", $idToDelete);
    mysqli_stmt_execute($stmt);

    header("Location: AdminGerirRotas.php");
    exit;
}


// Obter nomes das cidades pelos ids 
$cidade_sql = "SELECT * FROM cidades";
$cidade_result = mysqli_query($conn, $cidade_sql);

$cidades = [];
while ($cidade = mysqli_fetch_assoc($cidade_result)) {
  $cidades[] = $cidade;
}



?>


<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <title>Página Inicial Admin</title>
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

    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .top-footer {
      background-color: #333;
      color: white;
      padding: 15px;
      text-align: center;
      position: fixed;
      top: 0;
      width: 100%;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
      z-index: 1000;
    }

    .content {
      padding: 80px 20px;
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
      text-align: left;
    }

    th {
      background-color: #f4f4f4;
    }

    .btn {
      padding: 5px 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .edit-btn {
      background-color: #4CAF50;
      color: white;
    }

    .delete-btn {
      background-color: #f44336;
      color: white;
    }

    .add-btn {
      background-color: rgb(54, 92, 244);
      color: white;
    }
  </style>
</head>

<body>
  <a href="AdminAdicionarRota.php" class="btn add-btn">Adicionar uma Rota</a>

  <table>
    <tr>
      <th>Numero da Rota</th>
      <th>Origem</th>
      <th>Destino</th>
      <th>Data</th>
      <th>Lugares</th>
      <th>Numero de Passageiros</th>
      <th>Hora Partida</th>
      <th>Hora Chegada</th>
      <th>Preco</th>
    </tr>
    <?php
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $rota = urlencode($row["id_rota"]);
        echo "<td>" . $row["id_rota"] . "</td>";
        echo "<td>" . $row["origem"] . "</td>";
        echo "<td>" . $row["destino"] . "</td>";
        echo "<td>" . $row["data"] . "</td>";
        echo "<td>" . $row["lugares_disponiveis"] . "</td>";
        echo "<td>" . substr($row["hora_partida"], 0, 5) . "</td>";
        echo "<td>" . substr($row["hora_chegada"], 0, 5) . "</td>";
        echo "<td>" . $row["preco"] . " €</td>";




        echo "<td><a class='btn edit-btn' href='AdminEditarRota.php?rota=$rota'>Editar</a></td>";
        echo "<td><a class='btn delete-btn' href='?delete=$rota' onclick=\"return confirm('Tens a certeza que queres eliminar esta rota?');\">Eliminar</a></td>";

        echo "</tr>";
      }
    }
    ?>

  </table>





  <div class="navbar">
    <div class="nav-left">Gerir Rotas - Admin</div>
    <div class="nav-right">
      <a href="PagIniAdmin.php">Voltar</a>
      <a href="logout.php">Log Out</a>
    </div>
  </div>
</body>

</html>