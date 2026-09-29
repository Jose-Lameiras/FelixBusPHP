<?php
session_start();
include('../basedados/basedados.h');

if ($_SESSION["tipoUtilizador"] != 2) {
    header("Location: login.php");
    exit();
}

$id_utilizador = $_SESSION["id_utilizador"];

// Comprar bilhete
$mensagem = "";
if (isset($_POST['comprar'])) {
    $id_horario = intval($_POST['id_horario']);

    //  preço e lugares disponíveis do horário
    $sql_horario = "
        SELECT h.*, r.preco 
        FROM horarios h
        JOIN rotas r ON h.id_rota = r.id_rota
        WHERE h.id_horario = $id_horario
    ";
    $res_horario = mysqli_query($conn, $sql_horario);
    $horario = mysqli_fetch_assoc($res_horario);

    if ($horario && $horario['lugares_disponiveis'] > 0) {
        $preco = $horario['preco'];

        // Buscar saldo do cliente
        $sql_saldo = "SELECT saldo FROM carteira WHERE id_utilizador = $id_utilizador";
        $res_saldo = mysqli_query($conn, $sql_saldo);
        $row_saldo = mysqli_fetch_assoc($res_saldo);
        $saldo = $row_saldo ? floatval($row_saldo['saldo']) : 0;

        if ($saldo >= $preco) {
            // Descontar saldo do cliente
            mysqli_query($conn, "UPDATE carteira SET saldo = saldo - $preco WHERE id_utilizador = $id_utilizador");

            // Adicionar saldo à carteira da FelixBus
            mysqli_query($conn, "UPDATE carteira SET saldo = saldo + $preco WHERE id_utilizador = 100");

            // Registar auditoria
            mysqli_query($conn, "
                INSERT INTO carteira_felixbus 
                    (id_utilizador, operacao, valor, data_operacao, carteira_origem, carteira_destino) 
                VALUES 
                    ($id_utilizador, 'compra_bilhete', $preco, NOW(), $id_utilizador, 1)
            ");

            // Criar bilhete
            mysqli_query($conn, "INSERT INTO bilhetes (id_utilizador, id_horario) VALUES ($id_utilizador, $id_horario)");

            // Atualizar lugares disponíveis
            mysqli_query($conn, "UPDATE horarios SET lugares_disponiveis = lugares_disponiveis - 1 WHERE id_horario = $id_horario");

            $mensagem = "Bilhete comprado com sucesso!";
        } else {
            $mensagem = "Saldo insuficiente!";
        }
    } else {
        $mensagem = "Horário indisponível!";
    }
}
// Apagar bilhete
if (isset($_POST['apagar_bilhete'])) {
    $id_bilhete = intval($_POST['id_bilhete']);

    
    $sql_horario = "SELECT id_horario FROM bilhetes WHERE id_bilhete = $id_bilhete AND id_utilizador = $id_utilizador";
    $res_horario = mysqli_query($conn, $sql_horario);
    if ($row = mysqli_fetch_assoc($res_horario)) {
        $id_horario = $row['id_horario'];
        // Apagar o bilhete
    
        mysqli_query($conn, "DELETE FROM bilhetes WHERE id_bilhete = $id_bilhete AND id_utilizador = $id_utilizador");
        // Devolver o lugar ao horário
        mysqli_query($conn, "UPDATE horarios SET lugares_disponiveis = lugares_disponiveis + 1 WHERE id_horario = $id_horario");
        $mensagem = "Bilhete apagado com sucesso!";
    }
}

// Buscar horários disponíveis (lugares > 0)
$sql_horarios = "
    SELECT h.*, r.preco, c1.nome_cidade AS origem, c2.nome_cidade AS destino
    FROM horarios h
    JOIN rotas r ON h.id_rota = r.id_rota
    JOIN cidades c1 ON r.id_origem = c1.id_cidade
    JOIN cidades c2 ON r.id_destino = c2.id_cidade
    WHERE h.lugares_disponiveis > 0
";
$res_horarios = mysqli_query($conn, $sql_horarios);

// Buscar bilhetes do cliente
$sql_bilhetes = "
    SELECT 
        b.*, 
        h.data, h.hora_partida, h.hora_chegada, 
        r.preco, 
        c1.nome_cidade AS origem, 
        c2.nome_cidade AS destino
    FROM bilhetes b
    JOIN horarios h ON b.id_horario = h.id_horario
    JOIN rotas r ON h.id_rota = r.id_rota
    JOIN cidades c1 ON r.id_origem = c1.id_cidade
    JOIN cidades c2 ON r.id_destino = c2.id_cidade
    WHERE b.id_utilizador = $id_utilizador
";
$res_bilhetes = mysqli_query($conn, $sql_bilhetes);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Página Inicial Cliente</title>
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

        .container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
            min-width: 320px;
            max-width: 700px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        th {
            background: #e0f2f1;
        }

        .mensagem {
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .erro {
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
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

        .section-title {
            margin-top: 30px;
            margin-bottom: 10px;
            color: #2e7d32;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="nav-left">Bilhetes</div>
        <div class="nav-right">
            <a href="PagIniCliente.php">Voltar</a>
            <a href="logout.php">Log Out</a>
        </div>
    </div>

    <h1>Gestão de Bilhetes</h1>

    <div class="container">
        <?php if ($mensagem) { ?>
            <div class="<?php echo ($mensagem == "Saldo insuficiente!" || $mensagem == "Horário indisponível!") ? 'erro' : 'mensagem'; ?>">
                <?php echo $mensagem; ?>
            </div>
        <?php } ?>

        <h2 class="section-title">Horários Disponíveis</h2>
        <table>
            <tr>
                <th>Origem</th>
                <th>Destino</th>
                <th>Data</th>
                <th>Partida</th>
                <th>Chegada</th>
                <th>Preço</th>
                <th>Lugares</th>
                <th>Comprar</th>
            </tr>
            <?php while ($horario = mysqli_fetch_assoc($res_horarios)) { ?>
                <tr>
                    <form method="post">
                        <td><?php echo $horario['origem']; ?></td>
                        <td><?php echo $horario['destino']; ?></td>
                        <td><?php echo $horario['data']; ?></td>
                        <td><?php echo $horario['hora_partida']; ?></td>
                        <td><?php echo $horario['hora_chegada']; ?></td>
                        <td><?php echo $horario['preco']; ?> €</td>
                        <td><?php echo $horario['lugares_disponiveis']; ?></td>
                        <td>
                            <input type="hidden" name="id_horario" value="<?php echo $horario['id_horario']; ?>">
                            <button class="comprar-btn" type="submit" name="comprar">Comprar</button>
                        </td>
                    </form>
                </tr>
            <?php } ?>
        </table>

        <h2 class="section-title">Meus Bilhetes</h2>
        <table>
            <tr>
                <th>Origem</th>
                <th>Destino</th>
                <th>Data</th>
                <th>Partida</th>
                <th>Chegada</th>
                <th>Preço</th>
                <th>Apagar</th>
            </tr>
            <?php while ($bilhete = mysqli_fetch_assoc($res_bilhetes)) { ?>
                <tr>
                    <td><?php echo $bilhete['origem']; ?></td>
                    <td><?php echo $bilhete['destino']; ?></td>
                    <td><?php echo $bilhete['data']; ?></td>
                    <td><?php echo $bilhete['hora_partida']; ?></td>
                    <td><?php echo $bilhete['hora_chegada']; ?></td>
                    <td><?php echo $bilhete['preco']; ?> €</td>
                    <td>
                        <form method="post" style="margin:0;">
                            <input type="hidden" name="id_bilhete" value="<?php echo $bilhete['id_bilhete']; ?>">
                            <button type="submit" name="apagar_bilhete" class="comprar-btn" style="background:#dc3545;">Apagar</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>