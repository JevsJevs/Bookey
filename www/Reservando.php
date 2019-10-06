<?php
session_start();
include ("EntraBd.php");
require_once ("config.php");

if(isset($_SESSION["logUser"])){
    $pdo = conectarBD();

    $usuario = new User();

    $usuario = unserialize($_SESSION["logUser"]);



    $idhotl = $_GET["codHotel"];

    $hotel = new Hotel();

    $hotel->loadById($idhotl);

    $data = getdate();

    $hoje = date("Y-m-d",strtotime("now"));
    //$amanha = date("Y-m-d",strtotime("now +1 day"));

    echo ">JavaScript</a></li>
                    </ul>
                </div>
            </div>
        
        </div>
        \"";

    if(isset($hotel))
    {
        echo "
            <form name='reservar' method='post'>
            
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
                
                <!-- Inserir algo que contabilize o valor com base nas datas inseridas. 5 dias selecionados = 5 * diaria -->
                
                <div class='row'>
                    <div class='col s3 offset-s5'>
                        <input type='submit'>                
                    </div>
                </div>
                         
            </form>
        ";

        echo $hoje;

        if($_SERVER["REQUEST_METHOD"] === 'POST')
        {
            //insira formatacao antes

            $ckIn = $_POST['in'];
            $ckout = $_POST['out'];

            if($ckIn>$ckout)
            {
                echo "<span id='error'>Estadia invalida</span>";
            }
            else {
                $quarto = new Quarto();

                $quarto->primLivre($idhotl);

                echo $quarto;
                echo "<br/>";
                echo $usuario->getId();

                $subtotal = ((strtotime($ckout) - strtotime($ckIn)) / 86400) * $quarto->getValDia();

                $quarto->reservar($usuario->getId(), $ckIn, $ckout, $subtotal);

                header( "location:pag logada.php");
            }
        }

    }
}