<?php

include("EntraBd.php");
require_once("config.php");

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
        }else if($user==null)
        {
            echo "
                <link rel=\"stylesheet\" href=\"../icons/material.css\">
                <link rel=\"stylesheet\" href=\"../cascata/materialize.min.css\">
                <link rel=\"stylesheet\" href=\"../cascata/classes.css\">
                
                <body style='background-color: #B1D4EB'>
                    
                    <div class=\"row\" style='padding-top: 10%;'>
                        <div class=\"col s6 m6 l6 offset-s3 offset-l3 offset-m3\">
                              <div class=\"card blue-grey darken-1\">
                                    <div class=\"card-content white-text center-align\">
                                          <span class=\"card-title\" style='color: red'>Erro! Insira um email válido</span>
                                          <hr><br/>
                                            <input type=\"button\" onclick=\"location.href='../html/index.html'\" value=\"Tentar Novamente\">
                                    </div>
                              </div>
                        </div>
                     </div>
                    
                    
                                        
                </body>
                
                <script src=\"../js/jquery.min.js\"></script>
                <script src=\"../js/materialize.js\"></script>
                
                <script type=\"text/javascript\">
                    M.AutoInit();
                </script>
            ";


        } else
            echo "
                <link rel=\"stylesheet\" href=\"../icons/material.css\">
                <link rel=\"stylesheet\" href=\"../cascata/materialize.min.css\">
                <link rel=\"stylesheet\" href=\"../cascata/classes.css\">
                
                <body style='background-color: #B1D4EB'>
                    
                    <div class=\"row\" style='padding-top: 10%;'>
                        <div class=\"col s6 m6 l6 offset-s3 offset-l3 offset-m3\">
                              <div class=\"card blue-grey darken-1\">
                                    <div class=\"card-content white-text center-align\">
                                          <span class=\"card-title\" style='color: red'>Senha Incorreta</span>
                                          <hr><br/>
                                          
                                            <ul class='collapsible'>
                                                <li>
                                                    <div class='collapsible-header blue darken-2'><i class=\"material-icons\">mail_outline</i>Esqueceu a senha?</div>
                                                    <div class='collapsible-body'>
                                                        <form method='post' action='Email/RecuperaSenha.php'>
                                                            Insira seu email: <input type='email' name='email'>
                                                            <input type='hidden' value='Hotel' name='tipo'>
                                                            
                                                            <input type='submit' value='Enviar'>
                                                        </form>
                                                    </div>
                                                </li>
                                            </ul>
                                            
                                            <input type=\"button\" onclick=\"location.href='../html/index.html'\" value=\"Tentar Novamente\">
                                    </div>
                              </div>
                        </div>
                     </div>
                    
                    
                                        
                </body>
                
                <script src=\"../js/jquery.min.js\"></script>
                <script src=\"../js/materialize.js\"></script>
                
                <script type=\"text/javascript\">
                    M.AutoInit();
                </script>
            ";
    }
    catch (PDOException $e)
    {
        echo "Erro". $e->getMessage();
    }
?>
