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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Editar Cadastro</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php"><img src="./img/checklistlogo.png" style="max-width:200px;"></a></p>
        </div>

        <div class="right-links">
            <a href="#">Editar Cadastro</a>
            <a href="php/logout.php"> <button class="btn">Sair</button> </a>
        </div>
    </div>
    <div class="container">
        <div class="box form-box">
            <?php 
               if(isset($_POST['submit'])){
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $telefone = $_POST['telefone'];
                $data_nascimento = $_POST['data_nascimento'];

                $id = $_SESSION['id'];

                $edit_query = mysqli_query($con,"UPDATE users SET nome='$nome', Email='$email', telefone='$telefone', data_nascimento='$data_nascimento' WHERE Id=$id ") or die("error occurred");

                if($edit_query){
                    echo "<div class='message'>
                    <p>Perfil atualizado!</p>
                </div> <br>";
              echo "<a href='home.php'><button class='btn'>Voltar ao seu painel</button>";
       
                }
               }else{

                $id = $_SESSION['id'];
                $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id ");

                while($result = mysqli_fetch_assoc($query)){
                    $res_nome = $result['nome'];
                    $res_Email = $result['Email'];
                    $res_telefone = $result['telefone'];
                    $res_data_nascimento = $result['data_nascimento'];
                }

            ?>
            <header>Alterar dados pessoais</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="nome">Nome Completo</label>
                    <input type="text" name="nome" id="nome" value="<?php echo $res_nome; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" value="<?php echo $res_Email; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="telefone">Telefone/Whatsapp</label>
                    <input type="text" name="telefone" id="telefone" value="<?php echo $res_telefone; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="data_nascimento">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" id="" value="<?php echo $res_data_nascimento; ?>" autocomplete="off" required>
                </div>
                
                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Atualizar" required>
                </div>
                
            </form>
        </div>
        <?php } ?>
      </div>
</body>
</html>