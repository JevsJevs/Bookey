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
                header("location: Telas aviso/Quarto/EstadiaInvalida.php");
            }
            else {
                $quarto = new Quarto();

                $quarto->primLivre($idhotl);

                echo $quarto. "<br/>";

                var_dump($quarto->getIdHotel());

                $subtotal = ((strtotime($ckout) - strtotime($ckIn)) / 86400) * $quarto->getValDia();
                if($quarto->getIdHotel()==null)
                {
                    header("location: Telas aviso/Quarto/QtoIndisp.php");
                    echo "entrou";
                }
                else{
                    $quarto->reservar($usuario->getId(), $ckIn, $ckout, $subtotal);
                    header( "location:pag logada.php");
                }

            }
    }


}