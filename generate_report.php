<?php
session_start();

include("php/config.php");
require('fpdf/fpdf.php'); // Inclua a biblioteca FPDF

// Classe para criar o PDF
class PDF extends FPDF
{
    // Cabeçalho
    function Header()
    {
        $this->Image('img/checklistlogo.png', 10, 6, 30);
        $this->Ln(20);
    }

    // Rodapé
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Título
    function Title($title)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, $title, 0, 1, 'C');
        $this->Ln(5);
    }

    // Dados de duas colunas
    function TwoColumnData($left, $right)
    {
        $this->SetFont('Arial', '', 10);
        $this->Cell(90, 10, $left, 0, 0);
        $this->Cell(90, 10, $right, 0, 1);
    }

    // Linha horizontal
    function LineBreak()
    {
        $this->Ln(10);
    }

    // Subtítulo
    function SubTitle($subtitle)
    {
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 10, $subtitle, 0, 1, 'L');
        $this->Ln(5);
    }

    // Dados dos ambientes
    function RoomData($room, $status, $comment)
    {
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, "$room - $status", 0, 1);
        $this->MultiCell(0, 10, $comment);
        $this->Ln(5);
    }

    // Texto final
    function FooterText($text)
    {
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, $text, 0, 1, 'C');
    }
}

// Obtendo dados do usuário e do imóvel
$userId = $_SESSION['id'];
$userQuery = mysqli_query($con, "SELECT * FROM users WHERE Id=$userId");
if (!$userQuery) {
    die("Erro na consulta de usuário: " . mysqli_error($con));
}
$user = mysqli_fetch_assoc($userQuery);

$imovelId = isset($_GET['id_imovel']) ? $_GET['id_imovel'] : null;
if (!$imovelId) {
    die("ID do imóvel não especificado.");
}

$imovelQuery = mysqli_query($con, "SELECT * FROM imoveis WHERE id=$imovelId");
if (!$imovelQuery) {
    die("Erro na consulta de imóvel: " . mysqli_error($con));
}
$imovel = mysqli_fetch_assoc($imovelQuery);

$ambientesQuery = mysqli_query($con, "SELECT * FROM ambientes WHERE id_imovel=$imovelId");
if (!$ambientesQuery) {
    die("Erro na consulta de ambientes: " . mysqli_error($con));
}
$ambientes = mysqli_fetch_all($ambientesQuery, MYSQLI_ASSOC);

// Gerando PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Title('Relatório de Vistoria');

// Dados do vistoriante e do imóvel
$pdf->TwoColumnData("Nome: " . $user['nome'], "Endereço: " . $imovel['endereco_local']);
$pdf->TwoColumnData("Telefone: " . $user['telefone'], "Número: " . $imovel['numero_local']);
$pdf->TwoColumnData("Email: " . $user['Email'], "Cidade: " . $imovel['cidade']);
$pdf->TwoColumnData("Data de Nascimento: " . $user['data_nascimento'], "Estado: " . $imovel['estado']);

$pdf->LineBreak();
$pdf->Title('Vistoria dos Ambientes');

foreach ($ambientes as $ambiente) {
    $pdf->SubTitle($ambiente['nome_ambiente']);
    $itensQuery = mysqli_query($con, "SELECT * FROM itens_vistoria WHERE id_imovel=$imovelId AND id_ambiente=" . $ambiente['id']);
    if (!$itensQuery) {
        die("Erro na consulta de itens de vistoria: " . mysqli_error($con));
    }
    $itens = mysqli_fetch_all($itensQuery, MYSQLI_ASSOC);
    foreach ($itens as $item) {
        $pdf->RoomData($item['nome'], $item['status'], $item['comentario']);
    }
}

$pdf->LineBreak();
$pdf->FooterText("Em caso de dúvidas entre em contato conosco.");
$pdf->FooterText("© 2024 - Checklist Inteligente - Todos os direitos reservados.");

$pdf->Output('D', 'Relatorio_Vistoria.pdf');
?>
