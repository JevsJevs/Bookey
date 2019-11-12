<?php
session_start();

include("EntraBd.php");
require_once("config.php");

 $hotel = new Hotel();

 $hotel = unserialize($_SESSION["myhotel"]);

if(isset($_SESSION["myhotel"])) {

        try {

            $nQuart = $_POST["numero"];


            $foto = $_FILES['img'];
            $nomeft = $foto['name'];
            $tipoft = $foto['type'];
            $tamft = $foto['size'];

            $valDia = $_POST["valdia"]; // formatar o valor para float
            //$codQuarto = obtemPrimary($_SESSION["emailH"],"Hotel");

            if ((trim($nQuart) == '') || (trim($nomeft) == '') || (trim($valDia) == '')) {
                header("location: Telas aviso/Quarto/FalhaCadastroAllParamQto.php");
            } else if (!preg_match("/^image\/(jpeg|png|gif)$/", $tipoft)) {
                header("location: Telas aviso/Quarto/FalhaCadastroQuartoImgInvalida.php");
            } else if ($tamft > MaxSize) {
                header("location: Telas aviso/Quarto/FalhaCadastroQuartoImgGrande.php");
            }else if(repeteNumero($nQuart,$hotel->getId())) {
                echo "Numero já cadastrado, mude-o";
            } else {

                /* if(cadastraQuarto($codQuarto,$nQuart,$imagem,$valDia))
                 {
                     echo "<span> Quarto Cadastrado!</span>";
                     header("location:LogadoHotel.php");
                 }else
                     echo "<span> Falha ao cadastrar</span>";*/
                $fileBin = file_get_contents($foto['tmp_name']);

                $quarto = new Quarto();

                $quarto->setNumQuarto($nQuart);
                $quarto->setIdHotel($hotel->getId());
                $quarto->setImagem($fileBin);
                $quarto->setValDia($valDia);

                if($quarto->cadastrar())
                {
                    header("location:LogadoHotel.php");
                }
                else
                    header("location: Telas aviso/Quarto/FalhaCadastroQuartoException");


            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
