<?php
session_start();
include("EntraBd.php");
require_once("config.php");

if(isset($_SESSION["logUser"]))
{
    $pdo = conectarBD();

    echo "
        <html>
        <head>
            <title>Logado</title>
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
            <div class='row'>
                <ul class=\"tabs cyan accent-2\">
                    <li class=\"tab col s6\"> <a href=\"#busca\" class=\"black-text waves-effect waves-dark\">Buscar Hotéís</a> </li>
                    <li class=\"tab col s6\"> <a href=\"#reserva\" class=\"black-text waves-effect waves-dark\">Reservas Ativas</a> </li>
                </ul>
            </div>  
            
        </div>
        
        
        <div class=\"section\" id=\"busca\">
        
        <div class=\"carousel carousel-slider\">
        
        ";

    try{
        $pdo = conectarBD();

        $stmt = $pdo->prepare("SELECT Img FROM Quarto ORDER BY RAND()");

        $stmt->execute();
        $contador=0;

        while($contador<3)
        {
            $linha = $stmt->fetch();
            echo "<a class=\"carousel-item\"><img class='imgCarro' src='data:image;base64," . base64_encode($linha["Img"]) . "'></a> ";
            $contador++;
        }
        echo "</div>";
    }catch (PDOException $e)
    {
        echo $e->getMessage();
    }



    echo "     
        <div><h2>Hoteis recomendados</h2></div>
     
    ";

    try{
        $stmt= $pdo->prepare("select * from Hotel order by nome");

        $stmt->execute();

        while($row = $stmt->fetch())
            //foreach($resultado as $row
        {
            $end = getEndereco($row["idHotel"]);
            //Formatar os cards que vao conter os hotéis.
           echo " 
             <div class=\"row\">
		        <div class=\"col s12 m12 l12 xl12\">
		          <div class=\"card blue-grey darken-1\">
		            <div class=\"card-content white-text\">
		              <div class=\"row\">
		                  <span class=\"card-title\">$row[nome]</span>
		                  <a href='FazReserva.php?codHotel=$row[idHotel]'> Reservar</a>
		                  <p class='truncate'>$row[descricao]</p>
		                  <p class='truncate'>$end</p>
		                </div>
		            </div>
		          </div>
		        </div>
		     </div>
		     
		     ";
        }

        echo "

        </div>

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
              echo"  
                <div class=\"row\">
                    <div class=\"col s12 m12 l12 xl12\">
                        <div class=\"card blue-grey darken-1\">
                            <div class=\"card-content white-text\">
                                <div class=\"row\">
                                    <span class=\"card-title\">Quarto :$informacoes[nQuarto]</span>
                                    <a hidden>$informacoes[codHotel] </a>
                                    <img class='retrato col s3' src='data:image;base64,".base64_encode($informacoes["Img"])."'>
                                    <p class='col s3 m3 l3'>Valor da diaria: $informacoes[valDiaria] </p>
                                    <p class='col s3 m3 l3'>Valor total: $informacoes[valTot] </p>
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


             <script src=\"../js/jquery.min.js\"></script>
            <script src=\"../js/materialize.js\"></script>
            
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


