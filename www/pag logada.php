<?php
session_start();
include ("EntraBd.php");
require_once ("config.php");

if(isset($_SESSION["logUser"]))
{
    $pdo = conectarBD();
    //$hotel = $_POST["hotel"];

    echo "
    
        <html>
        <head>
            <title>Logado</title>
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
            <meta charset=\"utf-8\">
        
            <link rel=\"stylesheet\" href=\"icons/material.css\">
            <link rel=\"stylesheet\" href=\"cascata/materialize.min.css\">
            <link rel=\"stylesheet\" href=\"cascata/classes.css\">
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
            <div class='row'>
                <ul class=\"tabs cyan accent-2\">
                    <li class=\"tab col s6\"> <a href=\"#busca\" class=\"black-text waves-effect waves-dark\">Buscar Hotéís</a> </li>
                    <li class=\"tab col s6\"> <a href=\"#reserva\" class=\"black-text waves-effect waves-dark\">Reservas Ativas</a> </li>
                </ul>
            </div>
            
        </div>
        
        <div class=\"section\" id=\"busca\">
        
        <div class=\"carousel carousel-slider\">
        
            <a class=\"carousel-item\" href=\"#one!\"><img class='imgCarro' src=\"img/images.jpg \"></a>
            <a class=\"carousel-item\" href=\"#two!\"><img class='imgCarro' src=\"img/images%20(2).jpg \"></a>
            <a class=\"carousel-item\" href=\"#three!\"><img class='imgCarro' src=\"img/images%20(1).jpg \"></a>
            <a class=\"carousel-item\" href=\"#four!\"><img class='imgCarro' src=\"https://lorempixel.com/250/250/nature/4\"></a>
            <a class=\"carousel-item\" href=\"#five!\"><img class='imgCarro' src=\"https://lorempixel.com/250/250/nature/5\"></a>
        
        ";

        /*$pdo = conectarBD();


        $stmt= $pdo->prepare("select Img from Quarto ORDER BY RAND()");
        $stmt->execute();

        for($row = 0; $row<4;$row++)
        {
            $obj = $stmt->fetch();
            echo "<a class=\"carousel-item\" href=\"#\"><img class='imgCarro' src='data:image;base64,".base64_encode($obj["Img"])."'>";
        }*/

        echo "
            </div>
        
        
        
            <div><h2>Hoteis recomendados</h2></div>
            
            
            
    ";

    try{
        $stmt= $pdo->prepare("select * from Hotel order by nome");

        $stmt->execute();

        while($row = $stmt->fetch())
            //foreach($resultado as $row
        {
            //Formatar os cards que vao conter os hotéis.
           echo " 
             <div class=\"row\">
		        <div class=\"col s12 m12 l12 xl12\">
		          <div class=\"card blue-grey darken-1\">
		            <div class=\"card-content white-text\">
		              <div class=\"row\">
		                  <span class=\"card-title\">$row[nome]</span>
		                  <a href='Reservando.php?codHotel=$row[idHotel]'> Reservar</a>
		                  <p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.</p>
		                </div>
		            </div>
		          </div>
		        </div>
		     </div>
		     
		     ";
        }

        echo "

        </div>
        
        ";

        echo"

            <div class=\"section\" id=\"reserva\">
            ";

        try{
            //$idUser  = obtemPrimary($_SESSION["user"],"Usuario");
            $usuario = new User();
            $usuario = unserialize($_SESSION['logUser']);

           /* $stmt= $pdo->prepare("select * from Quarto WHERE codUser = :codUser order by codHotel");
            $stmt->bindParam(":codUser",$idUser);
            $stmt->execute();*/

           $roww = $usuario->seusQuartos();

            for($i=0;$i<sizeof($roww);$i++)
            {

              $informacoes = $roww[$i];
              echo"  <div class=\"row\">
                    <div class=\"col s12 m12 l12 xl12\">
                        <div class=\"card blue-grey darken-1\">
                            <div class=\"card-content white-text\">
                                <div class=\"row\">
                                    <span class=\"card-title\">Quarto :$informacoes[nQuarto]</span>
                                    <a hidden>$informacoes[codHotel] </a>
                                    <img class=\"imgListag col s4 m4 g4\" src=\"img\logo.png\">
                                    <p>I am a very simple card. I am good at containing small bits of information.
                                        I am convenient because I require little markup to use effectively.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
            }
        }
        catch (PDOException $exception)
        {
            echo "Error".$exception->getMessage();
        }

            echo "
            </div>


             <script src=\"js/jquery.min.js\"></script>
            <script src=\"js/materialize.js\"></script>
            <script type=\"text/javascript\">
                M.AutoInit();
            </script>
            </body>
            </html>        
        ";
    }
    catch (PDOException $e)
    {
        echo $output = $e->getMessage();
    }
}
?>


