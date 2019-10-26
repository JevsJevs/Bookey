<?php
session_start();
include("EntraBd.php");
require_once("config.php");

if(isset($_SESSION["logUser"])){
    $pdo = conectarBD();

    $usuario = new User();

    $usuario = unserialize($_SESSION["logUser"]);

    $idhotl = $_POST["codHotel"];

    $hotel = new Hotel();

    $hotel->loadById($idhotl);

    $data = getdate();

    $hoje = date("Y-m-d",strtotime("now"));
    //$amanha = date("Y-m-d",strtotime("now +1 day"));


    if(isset($hotel))
    {


            //insira formatacao antes

            $ckIn = $_POST['in'];
            $ckout = $_POST['out'];

            if($ckIn>$ckout)
            {
                echo "<span id='error'>Estadia invalida</span>";
            }
            else {
                $quarto = new Quarto();

                $quarto->primLivre($idhotl);

                $subtotal = ((strtotime($ckout) - strtotime($ckIn)) / 86400) * $quarto->getValDia();
                if($quarto==null)
                {
                    echo "<span id='error'>Não existem quartos livres, Volte mais tarde</span>";
                }
                else{
                    $quarto->reservar($usuario->getId(), $ckIn, $ckout, $subtotal);
                }

                header( "location:pag logada.php");
            }
    }


}