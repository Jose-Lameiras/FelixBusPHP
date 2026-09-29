<?php
session_start();
include('../basedados/basedados.h');

if ($_SESSION["tipoUtilizador"] != 1) {
    header("Location: Logout.php");
    exit();
}

$id_utilizador = $_SESSION["id_utilizador"];

// Atualizar dados 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nomeUtilizador'];
    $mail = $_POST['mail'];
    $telemovel = $_POST['telemovel'];
    $pass = $_POST['pass'];

    if ($pass != "") {
        $sql = "UPDATE utilizador SET nomeUtilizador='$nome', mail='$mail', telemovel='$telemovel', pass='$pass' WHERE id_utilizador=$id_utilizador";
    } else {
        $sql = "UPDATE utilizador SET nomeUtilizador='$nome', mail='$mail', telemovel='$telemovel' WHERE id_utilizador=$id_utilizador";
    }
    mysqli_query($conn, $sql);
    header("Location: AdminGerirPerfil.php");
    exit();
}

// Buscar dados atuais 
$sql = "SELECT nomeUtilizador, mail, telemovel FROM utilizador WHERE id_utilizador = $id_utilizador";
$res = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
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

        .perfil-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .perfil-form label {
            font-weight: bold;
        }

        .perfil-form input {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
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
    </style>
</head>

<body>
    <div class="navbar">
        <div class="nav-left">Editar Perfil</div>
        <div class="nav-right">
            <a href="PagIniAdmin.php">Voltar</a>
            <a href="logout.php">Log Out</a>
        </div>
    </div>

    <h1>Editar Perfil</h1>

    <div class="perfil-container">
        <h2>Alterar Dados</h2>
        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
            <form class="perfil-form" method="post">
                <label>Nome:</label>
                <input type="text" name="nomeUtilizador" value="<?php echo $row['nomeUtilizador']; ?>" required>
                <label>Email:</label>
                <input type="email" name="mail" value="<?php echo $row['mail']; ?>" required>
                <label>Telemóvel:</label>
                <input type="text" name="telemovel" value="<?php echo $row['telemovel']; ?>" required>
                <label>Nova Password (opcional):</label>
                <input type="password" name="pass" placeholder="Deixe em branco para não alterar">
                <button class="editar-btn" type="submit">Guardar Alterações</button>
                <button type="button" class="editar-btn" onclick="window.location.href='AdminGerirPerfil.php'">
                    Voltar para o Perfil
                </button>

            </form>
        <?php } ?>
    </div>
</body>

</html>