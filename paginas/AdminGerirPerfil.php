<?php
session_start();
include('../basedados/basedados.h');

if ($_SESSION["tipoUtilizador"] != 1) {
    header("Location: Logout.php");
    exit();
}

$id_utilizador = $_SESSION["id_utilizador"];

// Buscar dados do utilizador
$sql = "SELECT nomeUtilizador, mail, telemovel FROM utilizador WHERE id_utilizador = $id_utilizador";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Perfil Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 100px;
            min-height: 100vh;
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

        h1 {
            color: #333;
            margin-bottom: 40px;
            text-align: center;
        }

        .perfil-container {
            background: #fff;
            padding: 32px 48px;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.10);
            margin-top: 30px;
            min-width: 340px;
            max-width: 400px;
        }

        .perfil-container h2 {
            color: #2e7d32;
            margin-bottom: 24px;
            text-align: center;
        }

        .perfil-dados {
            margin-bottom: 18px;
        }

        .perfil-dados p {
            margin-bottom: 10px;
        }

        .editar-btn {
            padding: 12px 32px;
            background: hsl(122, 39.40%, 49.20%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .editar-btn:hover {
            background: #0056b3;
        }

        form {
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="nav-left">Perfil</div>
        <div class="nav-right">
            <a href="PagIniAdmin.php">Voltar</a>
            <a href="logout.php">Log Out</a>
        </div>
    </div>

    <h1>Perfil do Admin</h1>

    <div class="perfil-container">
        <h2>Meus Dados</h2>
        <div class="perfil-dados">
            <p><strong>Nome:</strong> <?php echo $row['nomeUtilizador']; ?></p>
            <p><strong>Email:</strong> <?php echo $row['mail']; ?></p>
            <p><strong>Telemóvel:</strong> <?php echo $row['telemovel']; ?></p>
        </div>
        <form action="AdminEditarPerfil.php" method="get">
            <button class="editar-btn" type="submit">Editar Dados</button>
        </form>
    </div>
</body>

</html>