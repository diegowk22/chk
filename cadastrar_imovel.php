<?php 
   session_start();

   include("php/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: index.php");
   }
?>
<?php 

$id = $_SESSION['id'];
$query = mysqli_query($con,"SELECT * FROM users WHERE Id=$id");

while($result = mysqli_fetch_assoc($query)){
    $res_id = $result['Id'];
    $res_nome = $result['nome'];
    $res_telefone = $result['telefone'];
    $res_Email = $result['Email'];
    $res_data_nascimento = $result['data_nascimento'];
    $res_id = $result['Id'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Cadastrar Imóvel</title>
    <style>
        .step-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .step-number {
            background-color: #d3d3d3;
            width: 50px;
            height: 50px;
            line-height: 50px;
            border-radius: 50%;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }
        .step-text {
            font-size: 24px;
        }
    </style>
    <script>
        function redirectToMenuImovel(id, id_movel) {
            setTimeout(function() {
                window.location.href = 'menu_imovel.php?id=' + id + '&id_movel=' + id_movel;
            }, 3000);
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="box form-box">
        <?php 
         
         include("php/config.php");
         if(isset($_POST['submit'])){
            $nome_vistoriante = $_POST['nome_vistoriante'];
            $endereco_local = $_POST['endereco_local'];
            $numero_local = $_POST['numero_local'];
            $bairro = $_POST['bairro'];
            $cidade = $_POST['cidade'];
            $local_vistoriado = $_POST['local_vistoriado'];
            
         //verifying the unique email

         $verify_query = mysqli_query($con,"SELECT endereco_local FROM imoveis WHERE endereco_local='$endereco_local'");

         if(mysqli_num_rows($verify_query) !=0 ){
            echo "<div class='message'>
                      <p>Este imóvel já tem cadastro, verifique na lista de imóveis do painel.</p>
                  </div> <br>";
            echo "<a href='javascript:self.history.back()'><button class='btn'>Voltar</button>";
         } 
         else{

            mysqli_query($con,"INSERT INTO imoveis(id_user,email_user,nome_vistoriante,endereco_local,numero_local,bairro,cidade,local_vistoriado) VALUES('$res_id','$res_Email','$nome_vistoriante','$endereco_local','$numero_local','$bairro','$cidade','$local_vistoriado')") or die("Erro!");

            // Getting the ID of the newly inserted row
            $new_imovel_id = mysqli_insert_id($con);

            echo "<div class='message'>
                      <p>Registrado com sucesso!</p>
                  </div> <br>";
            echo "<a href='menu_imovel.php?id=$res_id&id_movel=$new_imovel_id'><button class='btn'>Ir ao Menu Imóvel</button></a>";

            // Automatically redirect after 3 seconds
            echo "<script>redirectToMenuImovel('$res_id', '$new_imovel_id');</script>";
         }

         }else{
        ?>
            <div class="step-header">
                <div class="step-number">1º</div>
                <div class="step-text">PASSO</div>
            </div>
            <header>Cadastrar Imóvel</header>

            <form action="" method="post">
                <div class="field input">
                    <label for="nome_vistoriante">Nome do Vistoriante</label>
                    <input type="text" name="nome_vistoriante" id="nome_vistoriante" autocomplete="off" required>
                </div>                

                <div class="field input">
                    <label for="endereco_local">Endereço do Local</label>
                    <input type="text" name="endereco_local" id="endereco_local" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="numero_local">Nº</label>
                    <input type="number" name="numero_local" id="numero_local" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="bairro">Bairro</label>
                    <input type="text" name="bairro" id="bairro" autocomplete="off" required>
                </div>
                
                <div class="field input">
                    <label for="cidade">Cidade</label>
                    <input type="text" name="cidade" id="cidade" autocomplete="off" required>
                </div>
                
                <div class="field input">
                    <label for="estado">Estado</label>
                        <select id="estado" name="estado">
                        <option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AP">Amapá</option>
                        <option value="AM">Amazonas</option>
                        <option value="BA">Bahia</option>
                        <option value="CE">Ceará</option>
                        <option value="DF">Distrito Federal</option>
                        <option value="ES">Espírito Santo</option>
                        <option value="GO">Goiás</option>
                        <option value="MA">Maranhão</option>
                        <option value="MT">Mato Grosso</option>
                        <option value="MS">Mato Grosso do Sul</option>
                        <option value="MG">Minas Gerais</option>
                        <option value="PA">Pará</option>
                        <option value="PB">Paraíba</option>
                        <option value="PR">Paraná</option>
                        <option value="PE">Pernambuco</option>
                        <option value="PI">Piauí</option>
                        <option value="RJ">Rio de Janeiro</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="RS">Rio Grande do Sul</option>
                        <option value="RO">Rondônia</option>
                        <option value="RR">Roraima</option>
                        <option value="SC">Santa Catarina</option>
                        <option value="SP">São Paulo</option>
                        <option value="SE">Sergipe</option>
                        <option value="TO">Tocantins</option>
                        <option value="EX">Estrangeiro</option>
                        </select>
                </div>

                <div class="field input">
                    <label for="local_vistoriado">Tipo de Local</label>
                    <select name="local_vistoriado" id="local_vistoriado">
                      <option value="casa">Casa</option>
                      <option value="apto">Apto</option>
                      <option value="salão comercial">Salão Comercial</option>
                    </select>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Cadastrar imóvel" required>
                </div>
                <div class="links">
                    <a href="home.php">Voltar</a>
                </div>
            </form>
        </div>
        <?php } ?>
      </div>
</body>
</html>
