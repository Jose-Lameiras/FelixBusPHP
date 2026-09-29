<?php
session_start();
include('../basedados/basedados.h');


if ($_SESSION["tipoUtilizador"]!=1){
    header("Location: Logout.php");
}


$id_utilizador = 100;

// Buscar saldo atual
$sql = "SELECT saldo FROM carteira WHERE id_utilizador = $id_utilizador";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);
$saldo = $row ? $row['saldo'] : 0;


?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Carteira Felixbus</title>
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

        .carteira-container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
            min-width: 320px;
        }

        .carteira-container h2 {
            margin-bottom: 20px;
        }

        .carteira-container p {
            margin-bottom: 25px;
            font-size: 18px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 18px;
        }

        label {
            font-weight: bold;
        }

        input[type="number"] {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        button {
            padding: 10px;
            border: none;
            border-radius: 6px;
            background-color: hsl(122, 39.40%, 49.20%);
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="nav-left">Bilhetes</div>
        <div class="nav-right">
            <a href="PagIniAdmin.php">Voltar</a>
            <a href="logout.php">Log Out</a>
        </div>
    </div>

    <h1>Carteira</h1>
    <div class="carteira-container">
        <h2>Carteira Felixbus</h2>
        <p><strong>Saldo atual:</strong> <?php echo number_format($saldo, 2); ?> €</p>


        
    </div>
</body>

</html>