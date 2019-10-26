<?php
session_start();
include("EntraBd.php");
require_once("config.php");

if(isset($_SESSION["myhotel"]))
{
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
                        <li class=\"tab col s6 selected\"> <a href=\"#estrut\" class=\"black-text waves-effect waves-dark\">Sua Estrutura</a> </li>
                        <li class=\"tab col s6 \"> <a href=\"#reserva\" class=\"black-text waves-effect waves-dark\">Seus Hóspedes</a> </li>
                    </ul>
                </div>
            </div>
            
            <div class=\"section\" id=\"estrut\">
                    <a href='../html/CadQuarto.html'><h1>+ Adicionar Quarto</h1></a>
                    
        ";
    try{
        $hotel = new Hotel();
        $pdo = conectarBD();
        $hotel = unserialize($_SESSION["myhotel"]);
        $var = $hotel->getId();
        $stmt= $pdo->prepare("select * from Quarto WHERE codHotel = :identific order by nQuarto");
        $stmt->bindParam(":identific",$var);
        $stmt->execute();
        while($row = $stmt->fetch())
            //foreach($resultado as $row
        {
            //Formatar os cards que vao conter os hotéis.
            echo " 
                <div class=\"row\">
                    <div class=\"col s12 m12 l12 xl12\">
                      <div class=\"card blue-grey darken-1 hoverable\">
                        <div class=\"card-content white-text\">
                        <span class=\"card-title\">$row[nQuarto]</span>
                          <div class=\"row\">                              
                ";
            if($row['Img']=="")
                echo "Sem Foto";
            else
                echo " <img class='retrato col s3' src='data:image;base64,".base64_encode($row["Img"])."'>";
            echo "
                              <p class='col s3' style=\"width: 50%; overflow: hidden; text-overflow: ellipsis;\">I am a very simple card. I am good at containing small bits of information.I am convenient because I require little markup to use effectively.</p>
                              <p class='col s2'>Valor da diária: $row[valDiaria] </p>
                              <a  class='col s1' href='EditaQuarto.php?numero=$row[nQuarto]'> Alterar</a>
                          </div>
                        </div>  
                      </div>
                    </div>
                </div>
                ";
        }
        echo "
                </div>
                
                <div class='section' id='reserva'>
                ";
        try{
            $pdo = conectarBD();
            $stmt= $pdo->prepare("select * from Quarto WHERE codHotel = :identific AND codUser IS NOT NULL order by nQuarto");
            $stmt->bindParam(":identific",$var);
            $stmt->execute();
            while($row = $stmt->fetch())
            {
                //inserir data de estadia também (futuro)
                echo " 
                <div class=\"row\">
                    <div class=\"col s12 m12 l12 xl12\">
                      <div class=\"card blue-grey darken-1\">
                        <div class=\"card-content white-text\">
                          <div class=\"row\">
                              <span class=\"card-title\">$row[nQuarto]</span>
                              <img class='retrato col s3' src='data:image;base64,".base64_encode($row["Img"])."'>
                              <p>I am a very simple card. I am good at containing small bits of information.I am convenient because I require little markup to use effectively.</p>
                              <p>Valor da diária: $row[valDiaria] - Usuário No: $row[codUser] </p>
                              <a href='TerminaReserva.php/?numeroQ=$row[nQuarto]'>Terminar Reserva - CheckOut</a>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>";
            }
        }
        catch (PDOException $e)
        {
            echo "Erro ao carregar hospedes".$e->getMessage();
        }
        echo"
            </div>
            
                </body>
                <script src=\" ../js/jquery.min.js\"></script>
                <script src=\" ../js/materialize.min.js\"></script>
                <script>
                    M.AutoInit();
                </script>           
            ";
    }
    catch (PDOException $e)
    {
        echo $output = $e->getMessage();
    }
}
?>