<!DOCTYPE html>
<html>
<head>
    <title>Cadastro Hotel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">

    <link rel="stylesheet" href="icons/material.css">
    <link rel="stylesheet" href="css/materialize.min.css">
    <link rel="stylesheet" href="css/classes.css">

</head>

<body>

<div class="topo-fixo z-depth-2 ">
    <div class="valign-wrapper light-blue black-text">
        <h5 class="titulo">Bookey</h5>
        <div>
            <i class="material-icons waves-effect waves-light waves-circle dropdown-button right" data-activates="submenu" data-gutter="5" data-constrainwidth="false">more_vert</i>

            <ul id="submenu" class="dropdown-content">
                <li><a href="sass.html">Sass</a></li>
                <li><a href="badges.html">Components</a></li>
                <li><a href="collapsible.html">JavaScript</a></li>
            </ul>
        </div>
    </div>

    <h2>Cadastro Empresa - Hotel</h2>

    <div class="col s10 m10 l10 offset-s1 ">

        <form id="Cadastra" method="post" onsubmit="LogadoHotel.php">

            <div class="row">
                <div class="col s5 offset-s1">Numero do quarto:<br><input type="number" name="numero"></div>
                <div class="col s4 offset-s1">Foto Identificadora<br><input type="file" accept=".png,.jpg,.jpeg" name="img"></div>
            </div>

            <div class="row">
                <div class="col s5 offset-s1">Valor da diária<br><input type="text" name="valdia"></div>
            </div>

            <div class="row">
                <div class="col s2 offset-s5"><input type="submit" value="Cadastrar"></div>
            </div>
        </form>

    </div>

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

if($_SERVER["REQUEST_METHOD"] === 'POST')
{
    try {

        $nQuart = $_POST["numero"];
        $imagem = $_POST["img"];
        $valDia = $_POST["valdia"]; // formatar o valor para float
        $codQuarto = obtemPrimary($_SESSION["emailH"],"Hotel");


        if ((trim($nQuart) == '') || (trim($imagem) == '') || (trim($valDia) == '')) {
            echo "Todos os parametros são obrigatórios, refaça o formulário";
        } else {

           /* if(cadastraQuarto($codQuarto,$nQuart,$imagem,$valDia))
            {
                echo "<span> Quarto Cadastrado!</span>";
                header("location:LogadoHotel.php");
            }else
                echo "<span> Falha ao cadastrar</span>";*/
           $quarto = new Quarto();

           $quarto->setNumQuarto($nQuart);
           $quarto->setIdHotel($codQuarto);
           $quarto->setImagem($imagem);
           $quarto->setValDia($valDia);

           $quarto->cadastrar();

           header("location:LogadoHotel.php");
        }
    }
    catch (PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }
}