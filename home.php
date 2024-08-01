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
    <title>Checklist de Vistoria</title>
    <style>
        /* Estilos para o modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        /* Estilos para dispositivos móveis */
        @media screen and (max-width: 768px) {
            .modal-content {
                width: 95%;
            }
        }
        /* Estilos para as colunas */
        .steps-container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .step {
            width: 22%;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
        }
        .step-number {
            background-color: #d3d3d3;
            width: 50px;
            height: 50px;
            line-height: 50px;
            border-radius: 50%;
            font-size: 24px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .step p {
            margin-top: 10px;
        }
        .doubts {
            text-align: center;
            margin-top: 20px;
        }

        .btn-large {
            display: block;
            width: 80%;
            margin: 0 auto;
            padding: 15px;
            font-size: 24px;
            text-align: center;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
        .btn-large:hover {
            background-color: #0056b3;
        }

        
    </style>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php"><img src="./img/checklistlogo.png" style="max-width:200px;"></a> </p>
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
            
            echo "<a href='edit.php?Id=$res_id'>Alterar dados pessoais</a>";
            ?>
            <a href="php/logout.php"> <button class="btn">Sair</button> </a>
        </div>
    </div>
    <main>
       <div class="main-box top">
          <div class="top">
            <div class="box">
                <p>Bem-vindo <b><?php echo strtok($res_nome, " "); ?></b>!</p>
            </div>
            <div class="box">
                <p>Seus dados: <b><?php echo $res_Email ?></b> / <b><?php echo $res_telefone ?></b>. </p>
            </div>
          </div>
          <div class="bottom">
            <div class="box">
                <p>Bem-vindo ao Sistema Checklist Inteligente!</p>
                <div class="steps-container">
                    <div class="step">
                        <div class="step-number">1</div>
                        <p>Cadastre o imóvel</p>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <p>Adicione ambientes</p>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <p>Realize vistorias</p>
                    </div>
                    <div class="step">
                        <div class="step-number">4</div>
                        <p>Gere relatórios</p>
                    </div>
                </div>
                <div class="doubts">
                    <p>Ainda com dúvidas? Clique no botão abaixo para entender com mais detalhes como usar o sistema</p>
                    <button id="openModal" class="btn instrucoes">Confira como utilizar o sistema</button>
                </div>
                <br>
 
                <hr>
                <br>
                <a href="cadastrar_imovel.php"> <button class="btn-large">COMEÇAR O CHECKLIST</button></a>
            </div>
          </div>
       </div>
    </main>

    <!-- O Modal -->
    <div id="myModal" class="modal">
        <!-- Conteúdo do Modal -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Instruções para Uso do Sistema Checklist Inteligente</h2>
            <p>Bem-vindo ao Sistema Checklist Inteligente!</p>
            <p>Siga os passos abaixo para utilizar o sistema de forma eficiente:</p>
            <br>
            <ol>
                <li><strong>Cadastro do Imóvel:</strong> 
                    <ul>
                        <li>Acesse o menu principal.</li>
                        <li>Clique na opção para cadastrar um novo imóvel.</li>
                        <li>Preencha todas as informações necessárias sobre o imóvel e salve.</li>
                    </ul>
                </li>
            </ol>
            <br>
            <p>Seguindo esses passos, você conseguirá utilizar o sistema para cadastrar imóveis de forma simples e prática.</p>
        </div>
    </div>

    <script>
        // Obtém o modal
        var modal = document.getElementById("myModal");

        // Obtém o botão que abre o modal
        var btn = document.getElementById("openModal");

        // Obtém o elemento <span> que fecha o modal
        var span = document.getElementsByClassName("close")[0];

        // Quando o usuário clicar no botão, abre o modal 
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // Quando o usuário clicar em <span> (x), fecha o modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Quando o usuário clicar fora do modal, fecha o modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
