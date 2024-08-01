<?php
session_start();
include("php/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_ambiente = intval($_POST['id_ambiente']);
    
    $query = "DELETE FROM ambientes WHERE id = $id_ambiente";
    if (mysqli_query($con, $query)) {
        echo "success";
    } else {
        echo "Erro: " . mysqli_error($con);
    }
} else {
    echo "Método de requisição inválido.";
}
?>
