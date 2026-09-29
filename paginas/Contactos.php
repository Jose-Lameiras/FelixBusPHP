
<?php 


session_start();





?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Contactos Felix Bus</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background: #e3eaf2;
      margin: 0;
      padding: 0;
    }

    /* NAVBAR */
    .navbar {
      position: fixed;
      top: 0;
      width: 100%;
      background-color:hsl(122, 39.40%, 49.20%);
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

    .nav-left {
      font-size: 18px;
      font-weight: bold;
    }
    .conteudo {
  padding-top: 80px;    
    }
    table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
    }

    td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
    }

    tr:nth-child(even) {
  background-color: #dddddd;
    }


  </style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
  <div class="nav-left">Contactos</div>
  <div class="nav-right">
    <a href="login.php">Login</a>
    <a href="registo.php">Registar</a>
    <a href="index.php">Voltar</a>
  </div>
</div>

<div class="conteudo">
    <table>
        <tr><br><h1>Horario de atendimento <h1></br></tr>
        <th>Segunda</th>
        <th>Terça</th>
        <th>Quarta</th>
        <th>Quinta</th>
        <th>Sexta</th>
        <th>Sabado</th>
        <tr>
            <td>10:30-22:30</td>
            <td>10:30-22:30</td>
            <td>10:30-22:30</td>
            <td>10:30-22:30</td>
            <td>10:30-22:30</td>
            <td>10:30-13:30</td>

        </tr>
    </table> 

    <br></br>
    <br></br>
    <br></br>
    <h3>Para mais informações contacte central@felixbus.com<H3>
    <h2 >Localização</h2>
</div>

<div class="Mapa">
				
				<div style="position: relative; overflow: hidden; padding-top: 50%; background-color: F2F2F2">

            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3575.1821117162567!2d-7.512379300000002!3d39.819511000000006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd3d5ea6bb2280e1%3A0x1c460157bc4b46c8!2sEscola%20Superior%20de%20Tecnologia%20-%20Instituto%20Polit%C3%A9cnico%20de%20Castelo%20Branco!5e1!3m2!1spt-PT!2spt!4v1746890141540!5m2!1spt-PT!2spt"
                width="600" 
                height="450" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
				</div>

</body>
</html>
