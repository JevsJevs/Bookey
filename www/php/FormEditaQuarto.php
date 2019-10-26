<?php
session_start();



include ("config.php");
include ("EntraBd.php");


$hotel = new Hotel();
$hotel = unserialize($_SESSION["myhotel"]);

$numeroQto = $_POST["numeroQto"];

$novaDiar = $_POST["valdia"];
$novaFoto = $_FILES["foto"];

$nomeft = $novaFoto['name'];
$tipoft = $novaFoto['type'];
$tamft = $novaFoto['size'];

$qto = new Quarto();

$qto->loadByidHnum($hotel->getId(),$numeroQto);

if ((trim($novaDiar) == '') && (trim($novaFoto['name']) == '')) {
    echo "Todos os parametros são obrigatórios, refaça o formulário";
} else if (!preg_match("/^image\/(jpeg|png|gif)$/", $tipoft)) {
    echo "<span id='error'>Imagem invalida</span>";
} else if ($tamft > MaxSize) {
    echo "<span id='error'>Imagem grande demais. Max 2mb</span>";
} else {
    $fileBin = file_get_contents($novaFoto['tmp_name']);

    $qto->AttValorImg($fileBin, $novaDiar);

    header("location:LogadoHotel.php");
}