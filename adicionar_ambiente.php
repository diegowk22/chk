<?php
session_start();
include("php/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_ambiente = mysqli_real_escape_string($con, $_POST['nome_ambiente']);
    $id_imovel = intval($_POST['id_imovel']);
    $id_usuario = $_SESSION['id'];

    $query = "INSERT INTO ambientes (id_imovel, id_usuario, nome_ambiente, situacao) VALUES ($id_imovel, $id_usuario, '$nome_ambiente', 'Aguardando')";
    if (mysqli_query($con, $query)) {
        echo "success";
    } else {
        echo "Erro: " . mysqli_error($con);
    }
} else {
    echo "Método de requisição inválido.";
}
?>
