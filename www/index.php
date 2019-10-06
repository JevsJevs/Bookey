<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>Login Bookey</title>
    <link rel="stylesheet" href="icons/material.css">
    <link rel="stylesheet" href="cascata/materialize.min.css">
    <link rel="stylesheet" href="cascata/classes.css">
</head>
<body style="background-color:#B1D4EB"><!-- #78909c -->

 <div class="container corFundo">

    <h5 class="center-align logo">
        <img class="retrato" src="img/logo.png">
    </h5>

        <div class="row">
            <ul class="tabs blue darken-4">
                <li class="tab col s6 white-text"><a href="#User"><p class="fonteBranca">Usuário</p></a></li>
                <li class="tab col s6 white-text"><a href="#Hotel"><p class="fonteBranca">Hotel</p></a></li>
            </ul>
        </div>

    <div class="container">

        <div id="User">
            <form name="user" method="post">
                <div class="row">
                    <div class="col s8 offset-s2">
                        <span class="fonteBranca">Login: <input type="email" name="user" placeholder="Email"></span>

                        <span class="fonteBranca">Senha: <input type="password" name="senha"></span>
                        <input type="hidden" name="action" value="user">
                    </div>
                </div>
                <div class="row">
                    <p class="center-align tamFonte">
                        <input type="submit" value="EntrarUser">
                    </p>
                </div>
            </form>

            <div class="row">
                <div class="col s8 offset-s2">
                    <p class="centro tamFonte fonteBranca" >Não está cadastrado ainda?<br>     Cadastre-se já!</p>
                </div>
            </div>
            <div class="row">
                <div class="col s8 offset-s2">
                    <p class="center-align tamFonte fonteBranca"><input type="button" value="Cadastre-se"></p>
                </div>
            </div>
        </div>


        <div id="Hotel">
            <form name="hotel" method="post">
                <div class="row">
                    <div class="col s8 offset-s2">
                        <span class="fonteBranca">Login: <input type="email" name="user" placeholder="Email"></span>

                        <span class="fonteBranca">Senha: <input type="password" name="senha"></span>
                        <input type="hidden" name="action" value="hotel">
                    </div>
                </div>
                <div class="row">
                    <p class="center-align tamFonte">
                        <input type="submit" value="EntrarHotel">
                    </p>
                </div>
            </form>

            <div class="row">
                <div class="col s8 offset-s2">
                    <p class="centro tamFonte fonteBranca"" >Não está cadastrado ainda?<br>     Cadastre-se já!</p>
                </div>
            </div>
            <div class="row">
                <div class="col s8 offset-s2">
                    <p class="center-align tamFonte  fonteBranca""><input type="button" value="Cadastre-se"></p>
                </div>
            </div>
        </div>

    </div>

 </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/materialize.min.js"></script>

    <script type="text/javascript">
        M.AutoInit();
    </script>
</body>
</html>

<?php

if($_SERVER["REQUEST_METHOD"] === 'POST')
{
    include ("EntraBd.php");
    require_once ("config.php");

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
                    // fazer o esquema do switch($_POST[]) , 2 forms na mesma pagina.

                    /*if(login($user,$senha,"Usuario"))
                    {
                        session_start();
                        $_SESSION["user"] = $user;
                        $_SESSION["senha"] = $senha;

                        header("location:pag logada.php");
                    }*/

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
}
?>