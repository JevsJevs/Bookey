<!DOCTYPE html>
<html>
<head>
    <title>Cadastro Hotel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">

    <link rel="stylesheet" href="icons/material.css">
    <link rel="stylesheet" href="cascata/materialize.min.css">
    <link rel="stylesheet" href="cascata/classes.css">

</head>

<body>

<div class="topo-fixo z-depth-2 ">
    <div class="valign-wrapper light-blue black-text">
        <h5 class="titulo">Bookey</h5>
        <div>
            <i class="material-icons waves-effect waves-light waves-circle dropdown-button right" data-activates="submenu" data-gutter="5" data-constrainwidth="false">more_vert</i>

            <ul id="submenu" class="dropdown-content"></ul>
        </div>
    </div>

    <h2>Alterar Quarto - Hotel</h2>

</body>

<script src="js/jquery.min.js"></script>
<script src="js/materialize.min.js"></script>
<script>
    M.AutoInit();
</script>

</html>

<?php
session_start();

include ("EntraBd.php");
require_once ("config.php");

$hotel = new Hotel();

$hotel = unserialize($_SESSION["myhotel"]);

if(isset($_SESSION["myhotel"])) {
    $nQuart = $_GET["numero"];

    $qto = new Quarto();

    echo $nQuart;

    $qto->loadByidHnum($hotel->getId(),$nQuart);

    echo $qto;

    $numeroQuarto = $qto->getNumQuarto();
    $diaria = $qto->getValDia();

    echo $diaria;
    echo $numeroQuarto;

    echo "
        <form id=\"Cadastra\" method=\"post\" enctype=\"multipart/form-data\">

            <div class=\"row\">
                <div class=\"col s3 offset-s1\">Numero do quarto:<br><input type=\"number\" name=\"numero\" placeholder='$numeroQuarto' disabled></div>

                <img class='retrato col s4' src='data:image;base64,".base64_encode($qto->getImagem())."'>
    
     
                <br/>Nova Foto:<br/>
                  <div class='col s3'><input type=\"file\" name=\"foto\" accept=\"image/jpeg, image/png, image/gif, image/jpg\"></div>
 
            </div>
            
            <div class=\"row\">

           
              <div class=\"col s5 offset-s1\">Valor da diária<br><input type=\"text\" value='$diaria' name=\"valdia\"></div>
              
            </div>

            <div class=\"row\">
                <div class=\"col s2 offset-s5\"><input type=\"submit\" value=\"Cadastrar\"></div>
            </div>
        </form>
    
    ";

    if ($_SERVER["REQUEST_METHOD"] === 'POST')
    {
        $novaDiar = $_POST["valdia"];

        $novaFoto = $_FILES["foto"];

        $nomeft = $novaFoto['name'];
        $tipoft = $novaFoto['type'];
        $tamft = $novaFoto['size'];

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
    }
}