<?php
session_start();
include("php/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
    exit;
}

$id_imovel = isset($_GET['id_imovel']) ? $_GET['id_imovel'] : null;
$ambiente = isset($_GET['ambiente']) ? $_GET['ambiente'] : null;
$id_usuario = $_SESSION['id'];
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['itens'] as $nome_item => $item) {
        $status = $item['status'];
        $comentario = $item['comentario'];
        $query = "INSERT INTO itens_vistoria (id_usuario, id_imovel, id_ambiente, nome, status, comentario, data_submissao) 
                  VALUES ($id_usuario, $id_imovel, (SELECT id FROM ambientes WHERE nome_ambiente = '$ambiente' AND id_imovel = $id_imovel), '$nome_item', '$status', '$comentario', NOW())
                  ON DUPLICATE KEY UPDATE status='$status', comentario='$comentario', data_submissao=NOW()";
        mysqli_query($con, $query);
    }

    // Atualiza a situação do ambiente para "Realizado"
    $query_update = "UPDATE ambientes SET situacao='Realizado' WHERE nome_ambiente='$ambiente' AND id_imovel=$id_imovel";
    mysqli_query($con, $query_update);

    $success_message = "Vistoria atualizada com sucesso!";
    echo "<script type='text/javascript'>
            alert('$success_message');
            window.location.href = 'menu_imovel.php?id_imovel=$id_imovel';
          </script>";
    exit;
}

// Função para remover números do nome do ambiente
function removeNumbers($string) {
    return preg_replace('/\d/', '', $string);
}

function renderItem($item, $description, $tip) {
    echo "
        <div class='bottom'>
            <div class='box'>
                <h3>$item</h3>
                <p>$description</p>
                <br>
                <p>Dica: $tip</p>
                <div class='item'>
                    <label><input type='radio' name='itens[$item][status]' value='Aprovado'> Aprovado</label>
                    <label><input type='radio' name='itens[$item][status]' value='Reprovado'> Reprovado</label>
                    <textarea name='itens[$item][comentario]' placeholder='Comentário'></textarea>
                </div>
            </div>
        </div>
    ";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Vistoria do Ambiente</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php"><img src="./img/checklistlogo.png" style="max-width:200px;"></a></p>
        </div>
        <div class="right-links">
            <?php
            echo "<a href='menu_imovel.php?id_imovel=$id_imovel'>Voltar ao Imóvel</a>";
            ?>
            <a href="php/logout.php"><button class="btn">Sair</button></a>
        </div>
    </div>
    <main>
        <div class="main-box top">
            <div class="box">
                <h3>Vistoria do Ambiente: <?php echo htmlspecialchars($ambiente); ?></h3>
            </div>
            <form method="POST">
                <?php
                // Removendo números do nome do ambiente para comparação
                $tipo_ambiente = removeNumbers($ambiente);

                switch (trim($tipo_ambiente)) {
                    case "Dormitório":
                        renderItem("Contrapiso", "Contrapiso deve ser uniforme e plano, sem desníveis.", "Com o cabo de vassoura, dê leves batidas e verifique se escuta um som oco.");
                        renderItem("Acabamento e Pintura", "Verifique se a pintura está uniforme, sem manchas.", "Utilize uma lanterna para inspecionar as paredes e tetos.");
                        renderItem("Janelas", "Verifique se as janelas estão funcionando corretamente.", "Teste todas as janelas para garantir que estejam operacionais.");
                        renderItem("Peitoril da Janela", "Verifique se o peitoril da janela está instalado corretamente.", "Verifique a fixação e a vedação do peitoril.");
                        renderItem("Instalações Elétricas", "Verifique todas as instalações elétricas do ambiente.", "Certifique-se de que todas as tomadas e interruptores estão funcionando.");
                        renderItem("Porta de Madeira", "Verifique se a porta de madeira está em boas condições.", "Confira se a porta abre e fecha sem dificuldades.");
                        break;
                    case "Banheiro":
                        renderItem("Cerâmicas (Piso e Azulejo)", "Verifique se as cerâmicas estão bem instaladas.", "Observe se há cerâmicas soltas ou rachadas.");
                        renderItem("Peças de Granito", "Verifique se as peças de granito estão bem fixadas.", "Confira se não há rachaduras ou imperfeições.");
                        renderItem("Ralos", "Verifique se os ralos estão desobstruídos.", "Teste se a água escoa corretamente pelos ralos.");
                        renderItem("Hidráulica", "Verifique se todas as instalações hidráulicas estão funcionando.", "Teste todas as torneiras e registros.");
                        renderItem("Pia - Louças e Metais", "Verifique se a pia e os metais estão em bom estado.", "Teste as torneiras e verifique se não há vazamentos.");
                        renderItem("Forro", "Verifique se o forro está em boas condições.", "Observe se não há manchas ou infiltrações.");
                        renderItem("Instalações Elétricas", "Verifique todas as instalações elétricas do ambiente.", "Certifique-se de que todas as tomadas e interruptores estão funcionando.");
                        renderItem("Janelas", "Verifique se as janelas estão funcionando corretamente.", "Teste todas as janelas para garantir que estejam operacionais.");
                        renderItem("Porta", "Verifique se a porta está em boas condições.", "Confira se a porta abre e fecha sem dificuldades.");
                        break;
                    case "Sala":
                    case "Corredor":
                        renderItem("Contrapiso", "Contrapiso deve ser uniforme e plano, sem desníveis.", "Com o cabo de vassoura, dê leves batidas e verifique se escuta um som oco.");
                        renderItem("Acabamento e Pintura", "Verifique se a pintura está uniforme, sem manchas.", "Utilize uma lanterna para inspecionar as paredes e tetos.");
                        renderItem("Porta de Alumínio", "Verifique se a porta de alumínio está em boas condições.", "Confira se a porta abre e fecha sem dificuldades.");
                        renderItem("Instalações Elétricas", "Verifique todas as instalações elétricas do ambiente.", "Certifique-se de que todas as tomadas e interruptores estão funcionando.");
                        renderItem("Porta de Entrada", "Verifique se a porta de entrada está em boas condições.", "Confira se a porta abre e fecha sem dificuldades.");
                        break;
                    case "Terraço":
                    case "Sacada":
                        renderItem("Piso", "Verifique se o piso está em boas condições.", "Observe se há rachaduras ou desníveis.");
                        renderItem("Ralo", "Verifique se o ralo está desobstruído.", "Teste se a água escoa corretamente pelo ralo.");
                        renderItem("Soleira e Capa", "Verifique se a soleira e a capa estão bem instaladas.", "Confira se não há rachaduras ou imperfeições.");
                        renderItem("Guarda-corpo", "Verifique se o guarda-corpo está seguro.", "Teste a estabilidade e observe se há pontos de ferrugem.");
                        renderItem("Instalações Elétricas", "Verifique todas as instalações elétricas do ambiente.", "Certifique-se de que todas as tomadas e interruptores estão funcionando.");
                        renderItem("Acabamento e Pintura", "Verifique se a pintura está uniforme, sem manchas.", "Utilize uma lanterna para inspecionar as paredes e tetos.");
                        renderItem("Forro", "Verifique se o forro está em boas condições.", "Observe se não há manchas ou infiltrações.");
                        break;
                    case "Cozinha":
                    case "Área de Serviço":
                        renderItem("Cerâmicas (Piso e Azulejo)", "Verifique se as cerâmicas estão bem instaladas.", "Observe se há cerâmicas soltas ou rachadas.");
                        renderItem("Peças de Granito", "Verifique se as peças de granito estão bem fixadas.", "Confira se não há rachaduras ou imperfeições.");
                        renderItem("Ralos", "Verifique se os ralos estão desobstruídos.", "Teste se a água escoa corretamente pelos ralos.");
                        renderItem("Hidráulica", "Verifique se todas as instalações hidráulicas estão funcionando.", "Teste todas as torneiras e registros.");
                        renderItem("Louças e Metais", "Verifique se as louças e metais estão em bom estado.", "Teste as torneiras e verifique se não há vazamentos.");
                        renderItem("Pia", "Verifique se a pia está em boas condições.", "Observe se há manchas ou infiltrações.");
                        renderItem("Forro", "Verifique se o forro está em boas condições.", "Observe se não há manchas ou infiltrações.");
                        renderItem("Instalações Elétricas", "Verifique todas as instalações elétricas do ambiente.", "Certifique-se de que todas as tomadas e interruptores estão funcionando.");
                        renderItem("Portas", "Verifique se as portas estão em boas condições.", "Confira se as portas abrem e fecham sem dificuldades.");
                        renderItem("Interfone/Campainha", "Verifique se o interfone/campainha está funcionando.", "Observe se o interfone está corretamente instalado e funcionando.");
                        break;
                }
                ?>
                <br>
                <div class="box">
                    <button type="submit" class="btn">Salvar Vistoria</button>
                </div>
                <br>
            </form>
        </div>
    </main>
    <style>
        .item {
            border: 1px solid #000;
            margin-bottom: 10px;
            padding: 10px;
        }
        .item h4 {
            margin: 0 0 10px;
        }
        .item label {
            margin-right: 10px;
        }
        .item textarea {
            display: block;
            width: 100%;
            margin-top: 10px;
        }
    </style>
</body>
</html>
