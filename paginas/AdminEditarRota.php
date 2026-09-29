<?php
session_start();
include('../basedados/basedados.h');

// Verifica se é administrador
if (!isset($_SESSION["tipoUtilizador"]) || $_SESSION["tipoUtilizador"] != 1) {
    header("Location: Logout.php");
    exit();
}

// Verifica se veio a rota
if (!isset($_GET['rota'])) {
    echo "Rota não fornecida.";
    exit();
}

$rota = intval($_GET['rota']);

// Buscar dados da rota
$sql = "SELECT id_rota, id_origem, id_destino, preco FROM rotas WHERE id_rota = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $rota);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) != 1) {
    echo "Rota não encontrada na base de dados.";
    exit();
}
$row = mysqli_fetch_assoc($result);

// Buscar todas as cidades
$cidade_sql = "SELECT * FROM cidades";
$cidade_result = mysqli_query($conn, $cidade_sql);
$cidades = [];
while ($cidade = mysqli_fetch_assoc($cidade_result)) {
    $cidades[] = $cidade;
}

// Processar formulário
$erros = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novaOrigem = intval($_POST['id_origem']);
    $novoDestino = intval($_POST['id_destino']);
    $novoPreco = floatval($_POST['preco']);
    $data = $_POST['data'];
    $hora_partida = $_POST['hora_partida'];
    $hora_chegada = $_POST['hora_chegada'];
    $lugares_disponiveis = intval($_POST['lugares_disponiveis']);

    $hoje = date('Y-m-d');

    if ($novaOrigem == $novoDestino) {
        $erros[] = "A origem e o destino não podem ser iguais.";
    }
    if ($data < $hoje) {
        $erros[] = "A data não pode ser menor que a de hoje.";
    }
    if ($lugares_disponiveis <= 50) {
        $erros[] = "Os lugares disponíveis têm de ser maiores que 50.";
    }

    if (empty($erros)) {
        // Atualizar rota
        $update_sql = "UPDATE rotas SET id_origem = ?, id_destino = ?, preco = ? WHERE id_rota = ?";
        $stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($stmt, "iidi", $novaOrigem, $novoDestino, $novoPreco, $rota);
        mysqli_stmt_execute($stmt);

        // Adicionar novo horário
        $insert_horario_sql = "INSERT INTO horarios (id_rota, data, hora_partida, hora_chegada, lugares_disponiveis) VALUES (?, ?, ?, ?, ?)";
        $stmt_h = mysqli_prepare($conn, $insert_horario_sql);
        mysqli_stmt_bind_param($stmt_h, "isssi", $rota, $data, $hora_partida, $hora_chegada, $lugares_disponiveis);
        mysqli_stmt_execute($stmt_h);

        echo "<script>alert('Rota editada e novo horário adicionado com sucesso!'); window.location.href='AdminGerirRotas.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Rota e Adicionar Horário</title>
    <style>
        body { font-family: Arial, sans-serif; padding-top: 100px; background-color: #f4f4f4; display: flex; flex-direction: column; align-items: center; }
        .navbar { position: fixed; top: 0; left: 0; width: 100%; background-color: hsl(122, 39.40%, 49.20%); color: white; display: flex; justify-content: space-between; align-items: center; padding: 15px 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.2); z-index: 1000; }
        .navbar a { color: white; text-decoration: none; margin-left: 20px; font-weight: bold; }
        .navbar a:hover { text-decoration: underline; }
        form { width: 100%; max-width: 500px; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        label { margin-top: 15px; display: block; font-weight: bold; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; border-radius: 4px; border: 1px solid #ccc; }
        .btn { margin-top: 20px; padding: 10px 20px; border: none; cursor: pointer; border-radius: 4px; }
        .save-btn { background-color: #4CAF50; color: white; }
        .back-btn { background-color: #ccc; color: black; margin-left: 10px; }
        .erros { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="navbar">
    <div class="nav-left">Editar Rota e Adicionar Horário - Admin</div>
    <div class="nav-right">
        <a href="AdminGerirRotas.php">Voltar</a>
        <a href="logout.php">Log Out</a>
    </div>
</div>

<form method="POST">
    <?php if (!empty($erros)): ?>
        <div class="erros">
            <?php foreach ($erros as $erro): ?>
                <?= $erro ?><br>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <label>Origem</label>
    <select name="id_origem" required>
        <?php foreach ($cidades as $cidade): ?>
            <option value="<?= $cidade['id_cidade'] ?>" <?= ($cidade['id_cidade'] == ($novaOrigem ?? $row['id_origem'])) ? 'selected' : '' ?>>
                <?= $cidade['nome_cidade'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Destino</label>
    <select name="id_destino" required>
        <?php foreach ($cidades as $cidade): ?>
            <option value="<?= $cidade['id_cidade'] ?>" <?= ($cidade['id_cidade'] == ($novoDestino ?? $row['id_destino'])) ? 'selected' : '' ?>>
                <?= $cidade['nome_cidade'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Preço</label>
    <input type="number" step="0.01" name="preco" value="<?= htmlspecialchars($novoPreco ?? $row['preco']) ?>" required>

    <hr>
    <label>Data do novo horário</label>
    <input type="date" name="data" value="<?= htmlspecialchars($data ?? '') ?>" required>

    <label>Hora de partida</label>
    <input type="time" name="hora_partida" value="<?= htmlspecialchars($hora_partida ?? '') ?>" required>

    <label>Hora de chegada</label>
    <input type="time" name="hora_chegada" value="<?= htmlspecialchars($hora_chegada ?? '') ?>" required>

    <label>Lugares disponíveis</label>
    <input type="number" name="lugares_disponiveis" min="1" value="<?= htmlspecialchars($lugares_disponiveis ?? '') ?>" required>

    <button class="btn save-btn" type="submit">Guardar Alterações e Adicionar Horário</button>
</form>

</body>
</html>