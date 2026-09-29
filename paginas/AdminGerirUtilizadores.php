<?php
session_start();
include('../basedados/basedados.h');

// Verifica se é administrador (tipo 1)
if ($_SESSION["tipoUtilizador"] != 1) {
    header("Location: Logout.php");
    
}


 $sql = "SELECT u.id_utilizador, u.nomeUtilizador, u.mail, u.pass, u.telemovel, t.descricao 
        FROM utilizador u
        JOIN tipoutilizador t ON u.tipoUtilizador = t.id_Tipo";


$result = mysqli_query($conn, $sql);

if (isset($_GET['delete'])) {
    $mailToDelete = $_GET['delete'];

    $stmt = mysqli_prepare($conn, "DELETE FROM utilizador WHERE mail = ?");
    mysqli_stmt_bind_param($stmt, "s", $mailToDelete);
    mysqli_stmt_execute($stmt);
    header("Location: AdminGerirUtilizadores.php");
    exit;
}




?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Admin - Gerir Utilizadores</title>
  <style>
    body { margin: 0; font-family: Arial, sans-serif; }
    .top-footer {
      background-color: #333; color: white; padding: 15px;
      text-align: center; position: fixed; top: 0;
      width: 100%; box-shadow: 0 2px 4px rgba(0,0,0,0.3); z-index: 1000;
    }
    .content { padding: 80px 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
    th { background-color: #f4f4f4; }
    .btn { padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; }
    .edit-btn { background-color: #4CAF50; color: white; }
    .delete-btn { background-color: #f44336; color: white; }

    .btn {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    font-size: 16px;
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

 
  </style>
</head>
<body>


  <table>
        <tr>
            <th>Nome Utilizador</th>
            <th>Email</th>
            <th>Password</th>
            <th>Telemóvel</th>
            <th>Tipo de Utilizador</th>
            <th>Editar</th>
            <th>Eliminar Utilizador</th>
        </tr>
            <?php
            if (mysqli_num_rows($result) > 0) { 
                while ($row = mysqli_fetch_assoc($result)) {
                    $mail = urlencode($row["mail"]);
                    echo "<tr>";
                    echo "<td>" . $row["nomeUtilizador"] . "</td>";
                    echo "<td>" . $row["mail"] . "</td>";
                    echo "<td>" . $row["pass"] . "</td>";
                    echo "<td>" . $row["telemovel"] . "</td>";
                    echo "<td>" . $row["descricao"] . "</td>";


                    echo "<td><a class='btn edit-btn' href='AdminEditarUtilizador.php?mail=$mail'>Editar</a></td>";
                    echo "<td><a class='btn delete-btn' href='?delete=$mail' onclick=\"return confirm('Tens a certeza que queres eliminar este utilizador?');\">Eliminar</a></td>";
                    echo "</tr>";
                }
            }if (isset($_POST['btn delete-btn'])){
                $sql1="DELETE FROM utilizador WHERE $mail";
                $result1 = mysqli_query($conn, $sql1);

            }
            ?>
  </table>
</div>

    <div class="navbar">
      <div class="nav-left">Gerir Utilizadores - Admin</div>
      <div class="nav-right">
        <a href="PagIniAdmin.php">Voltar</a>
        <a href="logout.php">Log Out</a>
      </div>
    </div>
</body>
</html>
