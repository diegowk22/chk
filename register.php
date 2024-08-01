<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Registrar</title>
</head>
<body>
      <div class="container">
        <div class="box form-box">

        <?php 
         
         include("php/config.php");
         if(isset($_POST['submit'])){
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $telefone = $_POST['telefone'];
            $password = $_POST['password'];
            $data_nascimento = $_POST['data_nascimento'];
            
         //verifying the unique email

         $verify_query = mysqli_query($con,"SELECT Email FROM users WHERE Email='$email'");

         if(mysqli_num_rows($verify_query) !=0 ){
            echo "<div class='message'>
                      <p>Este email já tem cadastro, tente logar!</p>
                  </div> <br>";
            echo "<a href='javascript:self.history.back()'><button class='btn'>Voltar</button>";
         }
         else{

            mysqli_query($con,"INSERT INTO users(Username,nome,Email,telefone,data_nascimento,Password) VALUES('$nome','$nome','$email','$telefone','$data_nascimento','$password')") or die("Erroe Occured");

            echo "<div class='message'>
                      <p>Registrado com sucesso!</p>
                  </div> <br>";
            echo "<a href='index.php'><button class='btn'>Realizar login</button>";
         

         }

         }else{
         
        ?>

            <header>Criar Cadastro</header>
            <form action="" method="post">
            <!--    <div class="field input">
                    <label for="username">Usuário</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div> -->

                <div class="field input">
                    <label for="username">Nome Completo</label>
                    <input type="text" name="nome" id="nome" autocomplete="off" required>
                </div>                

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="data_nascimento">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" id="data_nascimento" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age">Telefone</label>
                    <input type="number" name="telefone" id="telefone" autocomplete="off" required>
                </div>
                
                <div class="field input">
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Cadastrar" required>
                </div>
                <div class="links">
                     Já tem cadastro? <a href="index.php">Faça login</a>
                </div>
            </form>
        </div>
        <?php } ?>
      </div>
</body>
</html>