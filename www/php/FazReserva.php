<?php
session_start();
include("EntraBd.php");
require_once("config.php");

if(isset($_SESSION["logUser"])) {
    $pdo = conectarBD();

    $usuario = new User();

    $usuario = unserialize($_SESSION["logUser"]);

    $idhotl = $_GET["codHotel"];

    $data = getdate();

    $hoje = date("Y-m-d", strtotime("now"));


    echo "
            <html>
            <head>
                <title>Cadastro Hotel</title>
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
                <meta charset=\"utf-8\">
            
                <link rel=\"stylesheet\" href=\"../icons/material.css\">
                <link rel=\"stylesheet\" href=\"../cascata/materialize.min.css\">
                <link rel=\"stylesheet\" href=\"../cascata/classes.css\">
            
            </head>
            
            <body>
            
            <div class=\"topo-fixo z-depth-2 \">
                <div class=\"valign-wrapper light-blue black-text\">
                    <h5 class=\"titulo\">Bookey</h5>
                    <div>
                        <i class=\"material-icons waves-effect waves-light waves-circle dropdown-button right\" data-activates=\"submenu\" data-gutter=\"5\" data-constrainwidth=\"false\">more_vert</i>
            
                        <ul id=\"submenu\" class=\"dropdown-content\">
                            <li><a href=\"sass.html\">Sass</a></li>
                            <li><a href=\"badges.html\">Components</a></li>
                            <li><a href=\"collapsible.html\">JavaScript</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <br/><br/>
            <br/>
            <br/>
            
                <form name='reservar' method='post' action=\"../php/Reservando.php\">
            
                    <div class='row'>
                        <div class='col s4 offset-s1'>
                            Data Check-in:
                            <input type='date' name='in' min='$hoje'> <!-- min dia atual-->
                        </div>
                        <div class='col s4 offset-s1'>
                            Data Check-out:
                            <input type='date' name='out' min='$hoje'> <!-- min 1 dia após o outro, ajustar pois a variavel amanha nn é dinamica -->
                        </div>
                    </div>
            
                    <input type=\"hidden\" name=\"codHotel\" value=\"$idhotl\">
                    <!-- Inserir algo que contabilize o valor com base nas datas inseridas. 5 dias selecionados = 5 * diaria -->
            
                    <div class='row'>
                        <div class='col s3 offset-s5'>
                            <input type='submit'>
                        </div>
                    </div>
            
                </form>
                    
            </body>
            </html>
    
    ";
}
?>