<?php

include("EntraBd.php");
require_once("config.php");

switch ($_POST["action"])
{
    case 'user':
        {
            try
            {
                $user = $_POST["user"];
                $senha = $_POST["senha"];
                $usuario = new User();

                $usuario->loadByEmail($user);

                if( !(strcmp(md5($senha),$usuario->getSenha() ) ) )
                {
                    session_start();
                    $_SESSION["logUser"] = serialize($usuario);
                    header("location:pag logada.php");
                }
                else
                    echo "<span style='color: red'>Senha Incorreta</span>";

            }
            catch (PDOException $e)
            {
                echo "Erro". $e->getMessage();
            }

        }

    case 'hotel':
        {
            try{
                $user = $_POST["user"];
                $senha = $_POST["senha"];

                $hotel = new Hotel();
                $hotel->loadByemail($user);

                if( !(strcmp(md5($senha),$hotel->getSenha() ) ) )
                {
                    session_start();
                    $_SESSION["myhotel"] = serialize($hotel);
                    header("location:LogadoHotel.php");
                }
                else
                    echo "<span style='color: red'>Senha Incorreta</span>";
            }
            catch (PDOException $e)
            {
                echo "Erro". $e->getMessage();
            }
        }

}
