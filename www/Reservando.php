<?php
session_start();
include ("EntraBd.php");

if(isset($_SESSION["user"]) && isset($_SESSION["senha"])) {
    $pdo = conectarBD();

    echo "
        <html>
        <head>
            <title>Logado</title>
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
            <meta charset=\"utf-8\">
        
            <link rel=\"stylesheet\" href=\"icons/material.css\">
            <link rel=\"stylesheet\" href=\"css/materialize.min.css\">
            <link rel=\"stylesheet\" href=\"css/classes.css\">
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
        ";

    try{
        $hotel = $_POST["hotelNome"];
        //$idUser  = obtemPrimary($hotel,"Hotel");
        $stmt= $pdo->prepare("select * from Hotel WHERE codHotel = :idHotel");
        $stmt->bindParam(":idHotel",$hotel);
        $stmt->execute();

        while($roww = $stmt->fetch())
        {
            echo"
            <div class='col s12 l2'><img src=\"$roww[Imgem]\"></div>            
            ";
        }
    }
    catch (PDOException $exception)
    {
        echo "Error".$exception->getMessage();
    }
    finally{
        echo "
            <form name='reservar' method='post'>
                Data Check-in:
                <input type='date' name='in'>
                
                Data Check-out:
                <input type='date' name='out'>
                
                
                <!-- Inserir algo que contabilize o valor com base nas datas inseridas. 5 dias selecionados = 5 * diaria -->
                
                <input type='submit'>
                         
            </form>
        ";

        if($_SERVER["REQUEST_METHOD"] === 'POST') {


        }

    }



}