<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>Só de Cenoura Garçom</title>
    <link rel="stylesheet" href="icons/material.css">
    <link rel="stylesheet" href="css/materialize.min.css">
    <link rel="stylesheet" href="css/classes.css">
</head>
<body>


    <h5 class="center-align logo">
        <img src="img/logo.png">
    </h5>

    <div class="row">
        <div class="col s6 offset-s3">
            <ul class="tabs">
                <li class="tab col s6"><a href="#User">Usuário</a></li>
                <li class="tab col s6"><a href="#Hotel">Hotel</a></li>
            </ul>
        </div>
    </div>

    <div class="container">

        <div id="User">
            <form name="login" method="post">
                <div class="row">
                    <div class="col s8 offset-s2">
                        <span>Login: <input type="email" name="user" placeholder="Email"></span>

                        <span>Senha: <input type="password" name="senha"></span>
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
                    <p class="centro tamFonte" >Não está cadastrado ainda?<br>     Cadastre-se já!</p>
                </div>
            </div>
            <div class="row">
                <div class="col s8 offset-s2">
                    <p class="center-align tamFonte"><input type="button" value="Cadastre-se"></p>
                </div>
            </div>
        </div>


        <div id="Hotel">
            <form name="login" method="post">
                <div class="row">
                    <div class="col s8 offset-s2">
                        <span>Login: <input type="email" name="user" placeholder="Email"></span>

                        <span>Senha: <input type="password" name="senha"></span>
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
                    <p class="centro tamFonte" >Não está cadastrado ainda?<br>     Cadastre-se já!</p>
                </div>
            </div>
            <div class="row">
                <div class="col s8 offset-s2">
                    <p class="center-align tamFonte"><input type="button" value="Cadastre-se"></p>
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

        switch ($_POST["action"])
        {
            case 'user':
            {
                try
                {
                    $user = $_POST["user"];
                    $senha = $_POST["senha"];
                    // fazer o esquema do switch($_POST[]) , 2 forms na mesma pagina.

                    if(login($user,$senha,"Usuario"))
                    {
                        session_start();
                        $_SESSION["user"] = $user;
                        $_SESSION["senha"] = $senha;

                        header("location:pag logada.php");
                    }
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

                    if(login($user,$senha,"Hotel"))
                    {
                        session_start();
                        $_SESSION["emailH"] = $user;
                        $_SESSION["senhaH"] = $senha;

                        header("location:LogadoHotel.php");
                    }
                    echo "Senha Incorreta";
                }
                catch (PDOException $e)
                {
                    echo "Erro". $e->getMessage();
                }
            }

        }
}
?>