<?php
/**
 * Created by PhpStorm.
 * User: aluno
 * Date: 07/11/2019
 * Time: 10:42
 */
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include("../EntraBd.php");
include ("../../Bibliotecas/PHPMailer-master/PHPMailerAutoload.php");

try{
    $email = $_POST["email"];
    $tipo = $_POST["tipo"];

    $pdo = conectarBD();
    $stmt = $pdo->prepare("SELECT email FROM ".$tipo." WHERE email= :EMAIL ; ");
    //$stmt->bindParam(":TIPO",$tipo);
    $stmt->bindParam(":EMAIL",$email);

    $stmt->execute();



    if($stmt->rowCount() == 1)
    {
        // Inicia a classe PHPMailer
        $mail = new PHPMailer();

    // Método de envio
        $mail->IsSMTP();

    // Enviar por SMTP
        $mail->Host = "smtp.gmail.com";

    // Você pode alterar este parametro para o endereço de SMTP do seu provedor
        $mail->Port = 587;

    // Usar autenticação SMTP (obrigatório)
        $mail->SMTPAuth = true;

    // Usuário do servidor SMTP (endereço de email)
    // obs: Use a mesma senha da sua conta de email
        $mail->Username = 'bookeyhotel@gmail.com';
        $mail->Password = 'bookey123';

    // Configurações de compatibilidade para autenticação em TLS
        $mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) );

    // Você pode habilitar esta opção caso tenha problemas. Assim pode identificar mensagens de erro.
    // $mail->SMTPDebug = 2;

    // Define o remetente
    // Seu e-mail
        $mail->From = "bookeyhotel@gmail.com";

    // Seu nome
        $mail->FromName = "Jevs";

    // Define o(s) destinatário(s)
        $mail->AddAddress($email);

    // Definir se o e-mail é em formato HTML ou texto plano
    // Formato HTML . Use "false" para enviar em formato texto simples ou "true" para HTML.
        $mail->IsHTML(true);

    // Charset (opcional)
        $mail->CharSet = 'UTF-8';

    // Assunto da mensagem
        $mail->Subject = "Veja qual é a sua nova senha";

    // Corpo do email
        //buscaSenhaEmail($email,$tipo)
        $mail->Body = '
            <h3>Bom dia! Sua senha é:</h3>
            <br/>
            <p> '.buscaSenhaEmail($email,$tipo).' </p>
            
            ';

    // Envia o e-mail
        $enviado = $mail->Send();

        // Exibe uma mensagem de resultado
        if ($enviado)
        {
            header("location: ../Telas aviso/EmailEnviado.php");
        } else {
            header("location: ../Telas aviso/EmailErro.php");
        }

    }else{
        // email nao cadastrado. volte ao inicio.
    }
}
catch (Exception $e)
{
    echo $e->getMessage();
}