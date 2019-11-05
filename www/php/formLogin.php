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
                    echo "
                        <link rel=\"stylesheet\" href=\"../icons/material.css\">
                        <link rel=\"stylesheet\" href=\"../cascata/materialize.min.css\">
                        <link rel=\"stylesheet\" href=\"../cascata/classes.css\">
                        <body style='background-color: #B1D4EB'>
                            <div class='row'>
                                <div class='col s3 offset-s5' style='background-color: #0D47A1; margin-top: 300px; height: 100px;'>
                                    <span style='color: red'>Senha Incorreta</span>
                                </div>
                            </div>                      
                        </body>
                    ";
            }
            catch (PDOException $e)
            {
                echo "Erro". $e->getMessage();
            }
        }

}
