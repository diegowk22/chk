<?php
session_start();
include("php/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
    exit;
}

$id_imovel = isset($_GET['id_imovel']) ? $_GET['id_imovel'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Checklist de Vistoria</title>
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

        .ambiente {
            border: 1px solid #000;
            margin-bottom: 10px;
            padding: 10px;
            display: inline-block;
            width: 30%;
            vertical-align: top;
        }
        .ambiente.realizado {
            background-color: #abd2a2;
        }
        .ambiente-item {
            margin-bottom: 10px;
        }
        .nome {
            font-weight: bold;
        }
        .delete-icon,
        .editar-icon {
            cursor: pointer;
        }
        .btn.editar-ambiente {
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .btn.deletar-ambiente {
            margin-top: 10px;
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .btn.editar-ambiente:hover {
            background-color: #45a049;
        }
        .btn.deletar-ambiente:hover {
            background-color: #e53935;
        }
        @media screen and (max-width: 768px) {
            .ambiente {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php"><img src="./img/checklistlogo.png" style="max-width:200px;"></a></p>
        </div>
        <div class="right-links">
            <?php
            $id = $_SESSION['id'];
            $query = mysqli_query($con, "SELECT * FROM users WHERE Id=$id");
            while ($result = mysqli_fetch_assoc($query)) {
                $res_nome = $result['nome'];
                $res_id = $result['Id'];
            }
            echo "<a href='home.php?Id=$res_id'>Voltar ao Menu</a>";
            ?>
            <a href="php/logout.php"><button class="btn">Sair</button></a>
        </div>
    </div>
    <main>
        <div class="main-box top">
            <div class="bottom">
                <div class="box">
                <div class="step-header">
                <div class="step-number">2º</div>
                <div class="step-text">PASSO</div>
            </div>
                    <h3>Vistorias</h3>
                    <p>Abaixo você pode adicionar ambientes de vistoria ou acessar algum ambiente já adicionado para realizar a vistoria.</p>

                    <div id="ambienteSelecionado"></div>
                    <div id="opcoesAmbiente" style="display: none;">
                        <p>Escolha o ambiente que deseja adicionar:</p>
                        <button class="btn opcao" data-tipo="Sala">Sala</button>
                        <button class="btn opcao" data-tipo="Cozinha">Cozinha</button>
                        <button class="btn opcao" data-tipo="Dormitório">Dormitório</button>
                        <button class="btn opcao" data-tipo="Banheiro">Banheiro</button>
                        <button class="btn opcao" data-tipo="Terraço">Terraço</button>
                        <button class="btn opcao" data-tipo="Corredor">Corredor</button>
                        <button class="btn opcao" data-tipo="Área de Serviço">Área de Serviço</button>
                    </div>

                    <div class="alnhar-esquerda">
                        <button id="adicionarAmbiente" class="btn add">+ Adicionar ambiente</button>
                        <br><br>
                        <div id="ambientes2" class="table-container">
                            <?php
                            // Consultar o banco de dados para obter os ambientes associados a este imóvel
                            $query_ambientes = "SELECT * FROM ambientes WHERE id_imovel = $id_imovel";
                            $result_ambientes = mysqli_query($con, $query_ambientes);

                            // Verifique se a consulta foi bem-sucedida
                            if ($result_ambientes) {
                                if (mysqli_num_rows($result_ambientes) > 0) {
                                    while ($row_ambiente = mysqli_fetch_assoc($result_ambientes)) {
                                        $id_ambiente = $row_ambiente['id'];
                                        $nome_ambiente = $row_ambiente['nome_ambiente'];
                                        $situacao = $row_ambiente['situacao']; // Obter a situação do ambiente
                                        $classe_realizado = $situacao === "Realizado" ? "realizado" : "";
                                        $btn_vistoriar_display = $situacao === "Realizado" ? "none" : "inline-block";
                                        echo "<div class='ambiente $classe_realizado'><div class='ambiente-item'>";
                                        echo "<div class='nome'>$nome_ambiente</div>";
                                        echo "<button class='btn editar-ambiente' style='display: $btn_vistoriar_display;' onclick='editarAmbiente(\"$nome_ambiente\")'>Vistoriar ✏️</button>";
                                        echo "<button class='btn deletar-ambiente' onclick='confirmDelete(this, $id_ambiente)'>Del 🗑️</button>";
                                        echo "<div class='situacao'>Situação: $situacao</div>"; // Exibir a situação dinamicamente
                                        echo "</div></div>";
                                    }
                                } else {
                                    echo "Nenhum ambiente encontrado.";
                                }
                            } else {
                                echo "Erro na consulta: " . mysqli_error($con);
                            }
                            ?>
                        </div>
                        <div id="ambientes" class="table-container"></div>

                        <a href="generate_report.php?id_imovel=<?php echo $id_imovel; ?>">
                            <button class="btn">Concluir e gerar relatório de vistoria</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="bottom">
                <div class="box">
                    <p>Dados desta propriedade:</p>
                    <?php echo "<a href='edit_imovel.php?id_imovel=$id_imovel'><button class='btn'>Editar Imóvel</button></a>"; ?>
                    <br>
                    <?php
                    if ($id_imovel) {
                        $query = "SELECT * FROM imoveis WHERE id = $id_imovel";
                        $result = mysqli_query($con, $query);

                        // Verifique se a consulta foi bem-sucedida
                        if ($result) {
                            if (mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                echo "Nome do Vistoriante: <b>" . $row["nome_vistoriante"] . "</b>  ";
                                echo "Local Vistoriado: <b>" . $row["local_vistoriado"] . "</b><br>";
                                echo "Endereço: " . $row["endereco_local"] . " - " . $row["numero_local"] . " <br>";
                                echo "Bairro: " . $row["bairro"] . "<br>";
                                echo "Cidade: " . $row["cidade"] . " - " . $row["estado"] . " <br>";
                            } else {
                                echo "Nenhum imóvel encontrado com o ID fornecido.";
                            }
                        } else {
                            echo "Erro na consulta: " . mysqli_error($con);
                        }
                    } else {
                        echo "ID do imóvel não especificado.";
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <script>
// Defina contadores para os ambientes
var contadorDormitorios = 1;
var contadorBanheiros = 1;
var contadorTerracos = 1;

document.getElementById("adicionarAmbiente").addEventListener("click", function() {
    var opcoesAmbiente = document.getElementById("opcoesAmbiente");
    var ambientesExistentes = document.querySelectorAll('#ambientes2 .nome');

    var cozinhaExiste = Array.from(ambientesExistentes).some(ambiente => ambiente.textContent.trim() === "Cozinha");
    var salaExiste = Array.from(ambientesExistentes).some(ambiente => ambiente.textContent.trim() === "Sala");

    // Mostrar ou ocultar opções de ambiente com base na existência
    document.querySelector('.opcao[data-tipo="Cozinha"]').style.display = cozinhaExiste ? "none" : "inline-block";
    document.querySelector('.opcao[data-tipo="Sala"]').style.display = salaExiste ? "none" : "inline-block";

    if (opcoesAmbiente.style.display === "none" || opcoesAmbiente.style.opacity === "0") {
        fadeIn(opcoesAmbiente);
    } else {
        fadeOut(opcoesAmbiente);
    }
});

document.querySelectorAll('.opcao').forEach(item => {
    item.addEventListener('click', event => {
        var tipo = event.target.getAttribute('data-tipo');
        var nomeAmbiente;

        if (tipo === "Dormitório") {
            // Contar quantos dormitórios já existem
            var totalDormitorios = countAmbientes("Dormitório");
            nomeAmbiente = `${tipo} ${totalDormitorios + 1}`;
        } else if (tipo === "Banheiro") {
            // Contar quantos banheiros já existem
            var totalBanheiros = countAmbientes("Banheiro");
            nomeAmbiente = `${tipo} ${totalBanheiros + 1}`;
        } else if (tipo === "Terraço") {
            // Contar quantos terraços já existem
            var totalTerracos = countAmbientes("Terraço");
            nomeAmbiente = `${tipo} ${totalTerracos + 1}`;
        } else {
            nomeAmbiente = tipo;
        }

        adicionarAmbiente(nomeAmbiente, <?php echo $id_imovel; ?>);
        fadeOut(document.getElementById("opcoesAmbiente"));
    });
});

function countAmbientes(tipo) {
    var ambientes = document.querySelectorAll('.nome');
    var count = 0;
    ambientes.forEach(ambiente => {
        if (ambiente.textContent.trim().startsWith(tipo)) {
            count++;
        }
    });
    return count;
}       

function adicionarAmbiente(nomeAmbiente, idImovel) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "adicionar_ambiente.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Adicionar o ambiente na interface do usuário
            var ambienteSelecionado = document.createElement("div");
            ambienteSelecionado.classList.add("ambiente");
            var idAmbiente = xhr.responseText;
            ambienteSelecionado.innerHTML = `
                <div class="ambiente-item">
                    <div class="nome">${nomeAmbiente}</div>
                    <div class="situacao">Situação: Aguardando...</div>
                    <button class="btn editar-ambiente" onclick="editarAmbiente('${nomeAmbiente}')">Vistoriar ✏️</button>
                    <button class="btn deletar-ambiente" onclick="confirmDelete(this, ${idAmbiente})">Del 🗑️</button>
                </div>
            `;
            document.getElementById("ambientes").appendChild(ambienteSelecionado);
        }
    };
    xhr.send(`nome_ambiente=${nomeAmbiente}&id_imovel=${idImovel}`);
}

function confirmDelete(element, idAmbiente) {
    var confirmDelete = confirm("Tem certeza que deseja excluir este ambiente?");
    if (confirmDelete) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "excluir_ambiente.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText === "success") {
                    // Remover o ambiente da interface do usuário
                    var ambiente = getAncestor(element, 'ambiente');
                    if (ambiente) {
                        ambiente.remove();
                    }
                } else {
                    alert("Erro ao excluir ambiente: " + xhr.responseText);
                }
            }
        };
        xhr.send("id_ambiente=" + idAmbiente);
    }
}

function getAncestor(element, className) {
    while (element && !element.classList.contains(className)) {
        element = element.parentNode;
    }
    return element;
}

function editarAmbiente(nomeAmbiente) {
    var urlParams = new URLSearchParams(window.location.search);
    var idImovel = urlParams.get('id_imovel');
    window.location.href = `vistoria_ambiente.php?id_imovel=${idImovel}&ambiente=${nomeAmbiente}`;
}

function fadeIn(element) {
    element.style.display = "block";
    var opacidade = 0;
    var timer = setInterval(function() {
        if (opacidade >= 1) {
            clearInterval(timer);
        }
        element.style.opacity = opacidade;
        opacidade += 0.1;
    }, 50);
}

function fadeOut(element) {
    var opacidade = 1;
    var timer = setInterval(function() {
        if (opacidade <= 0) {
            clearInterval(timer);
            element.style.display = "none";
        }
        element.style.opacity = opacidade;
        opacidade -= 0.1;
    }, 50);
}

    </script>
</body>
</html>
