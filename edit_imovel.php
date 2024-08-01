<?php 
   session_start();

   include("php/config.php");
   if(!isset($_SESSION['valid'])){
       header("Location: index.php");
       exit;
   }

   $id_imovel = isset($_GET['id_imovel']) ? $_GET['id_imovel'] : null;
   if (!$id_imovel) {
       header("Location: home.php");
       exit;
   }

   if (isset($_POST['submit'])) {
       $nome_vistoriante = $_POST['nome_vistoriante'];
       $email_user = $_POST['email_user'];
       $endereco_local = $_POST['endereco_local'];
       $numero_local = $_POST['numero_local'];
       $bairro = $_POST['bairro'];
       $cidade = $_POST['cidade'];
       $estado = $_POST['estado'];
       $local_vistoriado = $_POST['local_vistoriado'];

       $edit_query = mysqli_query($con, "UPDATE imoveis SET 
           nome_vistoriante='$nome_vistoriante', 
           email_user='$email_user', 
           endereco_local='$endereco_local', 
           numero_local='$numero_local', 
           bairro='$bairro', 
           cidade='$cidade', 
           estado='$estado', 
           local_vistoriado='$local_vistoriado' 
           WHERE id=$id_imovel") or die("error occurred");

       if ($edit_query) {
           echo "<script>
                   alert('Dados do imóvel atualizados!');
                   window.location.href = 'menu_imovel.php?id_imovel=$id_imovel';
                 </script>";
           exit;
       }
   } else {
       $query = mysqli_query($con, "SELECT * FROM imoveis WHERE id=$id_imovel");
       $result = mysqli_fetch_assoc($query);
       if (!$result) {
           header("Location: home.php");
           exit;
       }
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Editar Imóvel</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php"><img src="./img/checklistlogo.png" style="max-width:200px;"></a></p>
        </div>

        <div class="right-links">
            <a href="#">Editar Imóvel</a>
            <a href="php/logout.php"> <button class="btn">Sair</button> </a>
        </div>
    </div>
    <div class="container">
        <div class="box form-box">
            <header>Alterar dados do imóvel</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="nome_vistoriante">Nome do Vistoriante</label>
                    <input type="text" name="nome_vistoriante" id="nome_vistoriante" value="<?php echo $result['nome_vistoriante']; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email_user">Email do Usuário</label>
                    <input type="email" name="email_user" id="email_user" value="<?php echo $result['email_user']; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="endereco_local">Endereço</label>
                    <input type="text" name="endereco_local" id="endereco_local" value="<?php echo $result['endereco_local']; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="numero_local">Número</label>
                    <input type="number" name="numero_local" id="numero_local" value="<?php echo $result['numero_local']; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="bairro">Bairro</label>
                    <input type="text" name="bairro" id="bairro" value="<?php echo $result['bairro']; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="cidade">Cidade</label>
                    <input type="text" name="cidade" id="cidade" value="<?php echo $result['cidade']; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="estado">Estado</label>
                    <select id="estado" name="estado" required>
                        <option value="AC" <?php if($result['estado'] == 'AC') echo 'selected'; ?>>Acre</option>
                        <option value="AL" <?php if($result['estado'] == 'AL') echo 'selected'; ?>>Alagoas</option>
                        <option value="AP" <?php if($result['estado'] == 'AP') echo 'selected'; ?>>Amapá</option>
                        <option value="AM" <?php if($result['estado'] == 'AM') echo 'selected'; ?>>Amazonas</option>
                        <option value="BA" <?php if($result['estado'] == 'BA') echo 'selected'; ?>>Bahia</option>
                        <option value="CE" <?php if($result['estado'] == 'CE') echo 'selected'; ?>>Ceará</option>
                        <option value="DF" <?php if($result['estado'] == 'DF') echo 'selected'; ?>>Distrito Federal</option>
                        <option value="ES" <?php if($result['estado'] == 'ES') echo 'selected'; ?>>Espírito Santo</option>
                        <option value="GO" <?php if($result['estado'] == 'GO') echo 'selected'; ?>>Goiás</option>
                        <option value="MA" <?php if($result['estado'] == 'MA') echo 'selected'; ?>>Maranhão</option>
                        <option value="MT" <?php if($result['estado'] == 'MT') echo 'selected'; ?>>Mato Grosso</option>
                        <option value="MS" <?php if($result['estado'] == 'MS') echo 'selected'; ?>>Mato Grosso do Sul</option>
                        <option value="MG" <?php if($result['estado'] == 'MG') echo 'selected'; ?>>Minas Gerais</option>
                        <option value="PA" <?php if($result['estado'] == 'PA') echo 'selected'; ?>>Pará</option>
                        <option value="PB" <?php if($result['estado'] == 'PB') echo 'selected'; ?>>Paraíba</option>
                        <option value="PR" <?php if($result['estado'] == 'PR') echo 'selected'; ?>>Paraná</option>
                        <option value="PE" <?php if($result['estado'] == 'PE') echo 'selected'; ?>>Pernambuco</option>
                        <option value="PI" <?php if($result['estado'] == 'PI') echo 'selected'; ?>>Piauí</option>
                        <option value="RJ" <?php if($result['estado'] == 'RJ') echo 'selected'; ?>>Rio de Janeiro</option>
                        <option value="RN" <?php if($result['estado'] == 'RN') echo 'selected'; ?>>Rio Grande do Norte</option>
                        <option value="RS" <?php if($result['estado'] == 'RS') echo 'selected'; ?>>Rio Grande do Sul</option>
                        <option value="RO" <?php if($result['estado'] == 'RO') echo 'selected'; ?>>Rondônia</option>
                        <option value="RR" <?php if($result['estado'] == 'RR') echo 'selected'; ?>>Roraima</option>
                        <option value="SC" <?php if($result['estado'] == 'SC') echo 'selected'; ?>>Santa Catarina</option>
                        <option value="SP" <?php if($result['estado'] == 'SP') echo 'selected'; ?>>São Paulo</option>
                        <option value="SE" <?php if($result['estado'] == 'SE') echo 'selected'; ?>>Sergipe</option>
                        <option value="TO" <?php if($result['estado'] == 'TO') echo 'selected'; ?>>Tocantins</option>
                        <option value="EX" <?php if($result['estado'] == 'EX') echo 'selected'; ?>>Estrangeiro</option>
                    </select>
                </div>

                <div class="field input">
                    <label for="local_vistoriado">Local Vistoriado</label>
                    <input type="text" name="local_vistoriado" id="local_vistoriado" value="<?php echo $result['local_vistoriado']; ?>" autocomplete="off" required>
                </div>
                
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Atualizar" required>
                </div>
                
            </form>
        </div>
    </div>
</body>
</html>
