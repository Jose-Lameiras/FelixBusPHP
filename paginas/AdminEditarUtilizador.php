<?php
session_start();
include('../basedados/basedados.h');

// Verifica se é administrador
if ($_SESSION["tipoUtilizador"] != 1) {
    header("Location: Logout.php");
    exit();
}

// Verifica se veio o mail
if (!isset($_GET['mail'])) {
    echo "Email não fornecido.";
    exit();
}

$mail = $_GET['mail'];

// Obter utilizador
$sql = "SELECT * FROM utilizador WHERE mail='$mail'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) != 1) {
    echo "Utilizador não encontrado.";
    exit();
}

$row = mysqli_fetch_assoc($result);

// Obter tipos de utilizador
$tipos_sql = "SELECT * FROM tipoutilizador";
$tipos_result = mysqli_query($conn, $tipos_sql);

$tipos = [];
while ($tipo = mysqli_fetch_assoc($tipos_result)) {
    $tipos[] = $tipo;
}

// peocessar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novoNome = $_POST['nomeUtilizador'];
    $novoMail = $_POST['mail'];
    $novaPass = $_POST['pass'];
    $novoTelemovel = $_POST['telemovel'];
    $novoTipo = $_POST['tipoUtilizador'];

    $update_sql = "UPDATE utilizador SET 
        nomeUtilizador='$novoNome', 
        mail='$novoMail',
        pass='$novaPass', 
        telemovel='$novoTelemovel', 
        tipoUtilizador='$novoTipo'
        WHERE mail='$mail'";

    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Utilizador atualizado com sucesso!'); window.location.href='AdminUtilizadorEditado.php';</script>";
        exit();
    } else {
        echo "Erro ao atualizar utilizador: " . mysqli_error($conn);
    }
}



?>


<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Utilizador</title>
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
    </style>
</head>
<body>
<div class="navbar">
  <div class="nav-left">Editar Utilizador- Admin</div>
  <div class="nav-right">
    <a href="PagIniAdmin.php">Voltar</a>
    <a href="logout.php">Log Out</a>
  </div>
</div>


<form method="POST">
    

<h2>A editar o Utilizador:  <?php echo $row['nomeUtilizador']; ?></h2>

    <label>Nome de Utilizador</label>
    <input type="text" name="nomeUtilizador" value="<?php echo $row['nomeUtilizador']; ?>" required>

    <label>Mail</label>
    <input type="mail" name="mail" value="<?php echo $row['mail']; ?>" required>
    

    <label>Password</label>
    <input type="text" name="pass" value="<?php echo $row['pass']; ?>" required>

    <label>Telemóvel</label>
    <input type="text" name="telemovel" value="<?php echo $row['telemovel']; ?>">

    <label>Tipo de Utilizador</label>
    <select name="tipoUtilizador" required>
        <?php foreach ($tipos as $tipo): ?>
            <option value="<?php echo $tipo['id_Tipo']; ?>" <?php if ($row['tipoUtilizador'] == $tipo['id_Tipo']) echo 'selected'; ?>>
                <?php echo ($tipo['descricao']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button class="btn save-btn" type="submit">Concluir</button>
    <a href="AdminUtilizadorEditado.php" class="btn back-btn">Voltar</a>
</form>

</body>
</html>
