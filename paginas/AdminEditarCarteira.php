<?php
session_start();
include('../basedados/basedados.h');

// Verifica se é administrador
if ($_SESSION["tipoUtilizador"] != 1) {
    header("Location: Logout.php");
    exit();
}

// Verifica se veio a carteira
if (!isset($_GET['id_carteira'])) {
    echo "Carteira não fornecida.";
    exit();
}


$id_carteira = $_GET['id_carteira'];

// Obter dados da carteira e nome do utilizador
$sql = "SELECT c.*, u.nomeUtilizador 
        FROM carteira c
        JOIN utilizador u ON c.id_utilizador = u.id_utilizador
        WHERE c.id_carteira = '$id_carteira'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) != 1) {
    echo "Carteira não encontrada.";
    exit();
}

$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novoSaldo = $_POST['saldo'];

    if (!is_numeric($novoSaldo) || $novoSaldo < 0) {
        echo "<script>alert('Saldo inválido.');</script>";
    } else {
        $update_sql = "UPDATE carteira SET saldo = '$novoSaldo' WHERE id_carteira = '$id_carteira'";
        if (mysqli_query($conn, $update_sql)) {
            echo "<script>alert('Saldo atualizado com sucesso!'); window.location.href='AdminGerirCarteiras.php';</script>";
            exit();
        } else {
            echo "<script>alert('Erro ao atualizar: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>




<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Saldo da Carteira</title>
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
            min-height: 100vh;
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #28a745;
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
        form {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        label {
            margin-top: 10px;
            display: block;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #388e3c;
        }
    </style>
</head>
<body>
<div class="navbar">
    <div class="nav-left">Editar Saldo</div>
    <div class="nav-right">
        <a href="AdminGerirCarteiras.php">Voltar</a>
        <a href="logout.php">Log Out</a>
    </div>
</div>

<form method="POST">
    <h3>Editar Saldo da Carteira</h3>
    <p><strong>Utilizador:</strong> <?php echo htmlspecialchars($row['nomeUtilizador']); ?></p>
    
    <label for="saldo">Saldo (€)</label>
    <input type="number" step="0.01" name="saldo" value="<?php echo $row['saldo']; ?>" required>

    <button type="submit" class="btn">Guardar Alterações</button>
</form>
</body>
</html>