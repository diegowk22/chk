<?php 
   session_start();

   include("php/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: index.php");
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Checklist de Vistoria</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php"><img src="./img/checklistlogo.png" style="max-width:300px;"></a> </p>
        </div>

        <div class="right-links">

            <?php 
            
            $id = $_SESSION['id'];
            $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id");

            while($result = mysqli_fetch_assoc($query)){
                $res_nome = $result['nome'];
                $res_telefone = $result['telefone'];
                $res_Email = $result['Email'];
                $res_data_nascimento = $result['data_nascimento'];
                $res_id = $result['Id'];
            }
            
            echo "<a href='home.php?Id=$res_id'>Voltar ao Menu</a>";
            ?>

            <a href="php/logout.php"> <button class="btn">Sair</button> </a>

        </div>
    </div>