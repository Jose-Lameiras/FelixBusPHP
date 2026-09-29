<?php
session_start();
include('../basedados/basedados.h');

if ($_SESSION["tipoUtilizador"] != 1) {
    header("Location: Logout.php");
    exit();
}

$sql = "SELECT c.id_carteira, c.saldo, u.nomeUtilizador 
        FROM carteira c 
        JOIN utilizador u ON c.id_utilizador = u.id_utilizador";


$result = mysqli_query($conn, $sql);


//selecionar nome apartir do id

$nomes = [];
$nomes_sql = "SELECT * FROM utilizador";
$nomes_result = mysqli_query($conn, $nomes_sql);
while ($nome = mysqli_fetch_assoc($nomes_result)) {
    $nomes[] = $nome;
}


if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];

    $stmt = mysqli_prepare($conn, "DELETE FROM carteira WHERE id_carteira = ?");
    mysqli_stmt_bind_param($stmt, "s", $idToDelete);
    mysqli_stmt_execute($stmt);
    header("Location: AdminGerirCarteiras.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gerir Carteiras</title>
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
          background-color: #007BFF;
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
        body { font-family: Arial, sans-serif; padding: 20px; }
        form { max-width: 400px; margin: auto; }
        label { display: block; margin-top: 15px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; }
        .btn { margin-top: 20px; padding: 10px 20px; border: none; cursor: pointer; border-radius: 4px; }
        .save-btn { background-color: #4CAF50; color: white; }
        .back-btn { background-color: #ccc; color: black; margin-left: 10px; }
                .content { padding: 80px 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn { padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; }
        .edit-btn { background-color: #4CAF50; color: white; }
        .delete-btn { background-color: #f44336; color: white; }
        .add-btn { background-color:rgb(54, 92, 244); color: white; }
    </style>
</head>
<body>
<div class="navbar">
  <div class="nav-left">Gerir carteiras - Admin</div>
  <div class="nav-right">
    <a href="PagIniAdmin.php">Voltar</a>
    <a href="logout.php">Log Out</a>
  </div>
</div>
  <table>
        <tr>
            <th>Id Carteira</th>
            <th>Nome do Utilizador </th>
            <th>Saldo</th>
        </tr>
        
        <br></br>
        <br></br>
        <br></br>
        <br></br>
        
            <?php
            if (mysqli_num_rows($result) > 0) { 
                while ($row = mysqli_fetch_assoc($result)) {
                    $id_carteira= urlencode($row["id_carteira"]);

                    echo "<tr>";
                    echo "<td>" . $row["id_carteira"] . "</td>";
                    echo "<td>" . $row["nomeUtilizador"] . "</td>";
                    echo "<td>" . $row["saldo"] . "€" . "</td>";

                    echo "<td><a class='btn edit-btn' href='AdminEditarCarteira.php?id_carteira=$id_carteira'>Editar</a></td>";

                    echo "<td><a class='btn delete-btn' href='?delete=$id_carteira' onclick=\"return confirm('Tens a certeza que queres eliminar esta carteira?');\">Eliminar</a></td>";

                    


                    


                    echo "</tr>";
                }
            }
            ?>
  </table>