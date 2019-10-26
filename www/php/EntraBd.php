<?php

function conectarBD() {
    $pdo = new PDO('mysql:host=143.106.241.3;dbname=cl17126;charser=utf-8','cl17126','cl*13022002');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function verificaSenha($senha1,$senha2){
    $retorno = false;
    if (strcmp($senha1,$senha2))
        $retorno = true;
    else
        $retorno = false;

    return $retorno;
}

function verificaEmail($email,$tabela) // ele não aceita o :tabela. só se for inserido manualmente
{
    $pdo = conectarBD();
    try {
        $query = "select * from $tabela WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);

        $stmt->execute();
    }
    catch (PDOException $e)
    {
        echo "erro:".$email." :".$e->getMessage();
    }

    $verify = $stmt->rowCount();

    if($verify<=0)
        return false;
    else
        return true;
}

function obtemPrimary($email,$table)
{
    try {
        $pdo = conectarBD();

        $stmt= $pdo->prepare("select * from $table where email=:email");
        $stmt->bindParam(':email', $email);

        $stmt->execute();

        $row = $stmt->fetch();

        return  $row[0];

    }
    catch (PDOException $e)
    {
        echo 'Error em achar a tabela: ' . $e->getMessage();
    }
}

function cadastrarHotel($nome,$rua,$bairro,$numero,$cidade,$estado,$email,$tel, $senha1) {
    $returnou = false;
    try {
        $encriptsenha = md5($senha1);

        $pdo = conectarBD();

        $stmt = $pdo->prepare("insert into Hotel (nome,senha, email, Telefone) VALUES (:nome, :senha, :email, :tel)");

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':tel', $tel);
        $stmt->bindParam(':senha', $encriptsenha);


        $stmt->execute();

    }
    catch (PDOException $e)
    {
        echo 'Error no cadastro em HOTEL: ' . $e->getMessage();
    }
    finally
    {
        try{
            $pdo = conectarBD();

            $stmt = $pdo->prepare("insert into Logradouro (HotelCodigo,numero,bairro,cidade,estado,rua) VALUES (:HotelCodigo,:numero,:bairro,:cidade,:estado,:rua)");

            $stmt->bindParam(':numero', $numero);
            $stmt->bindParam(':bairro', $bairro);
            $stmt->bindParam(':cidade', $cidade);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':rua', $rua);
            $envEmail = obtemPrimaryHotel($email);

            $stmt->bindParam(':HotelCodigo',$envEmail);

            $stmt->execute();
            $returnou = true;
        }
        catch (PDOException $e)
        {
            echo 'Falha ao cadastrar endereço: ' . $e->getMessage();
        }
    }
    return $returnou;
}

function cadastrarUser($nome,$dnasc,$nick,$email,$cel, $senha1) {
    $returnou = false;
    try {
        $encriptsenha = md5($senha1);

        $pdo = conectarBD();

        $stmt = $pdo->prepare("insert into Usuario (nome,dnasc, senha, email, celular, apelido) VALUES (:nome, :dnasc, :senha, :email, :cel, :nick)");

        $stmt->bindParam(':dnasc', $dnasc);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':nick', $nick);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':cel', $cel);
        $stmt->bindParam(':senha', $encriptsenha);


        $stmt->execute();
        $returnou =true;
    }
    catch (PDOException $e)
    {
        echo 'Error'. $email.'  : ' . $e->getMessage();
    }
    return $returnou;
}

function cadastraQuarto($codHotel,$numero,$imagem,$valDia)
{
    $retorno = false;
    try{
        $pdo = conectarBD();

        $stmt = $pdo->prepare("INSERT INTO Quarto (codUser,codHotel,nQuarto,Img,senhaEntra,valDiaria) VALUES (null,:codHotel,:numero,:imagem,null,:valDia)");
        $stmt->bindParam(":codHotel",$codHotel);
        $stmt->bindParam(":numero",$numero);
        $stmt->bindParam(":imagem",$imagem);
        $stmt->bindParam(":valDia",$valDia);

        $stmt->execute();
        $retorno = true;
    }
    catch(PDOException $e)
    {
        echo "Erro".$e->getMessage();
    }
    return $retorno;
}

function senhaLogin($senha,$email)
{
    try{

        $pdo = conectarBD();

        $stmt = $pdo->prepare("SELECT senha FROM Usuario WHERE email=:email; ");
        $stmt->bindParam(":email",$email);

        $stmt->execute();

        $confSenha = $stmt->fetch();

        $senhaCrypt = md5($senha);

        if(!strcmp($senhaCrypt,$confSenha))
            return true;
        else
            return false;

    }catch (PDOException $e)
    {
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}

function login($email,$senha,$tabela)
{
    try{

        $pdo = conectarBD();

        $stmt = $pdo->prepare("SELECT email FROM $tabela WHERE email=:email");
        $stmt->bindParam(":email",$email);

        $stmt->execute();

        $verify = $stmt->rowCount();

        if($verify>0)
        {
            if(verificaSenha($senha,$email))
                return true;
            else
                return false;
        }
        else
            return false;

    }catch (PDOException $e)
    {
        echo 'Error: ' . $e->getMessage();
    }
}

function geradorSenhaQto()
{
    $alfabetao = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $tamAlfabeto = strlen($alfabetao);
    $palavrapasse='';

    for($i =0 ; $i<10; $i++)
    {
        $palavrapasse[$i] = $alfabetao[rand(0 , $tamAlfabeto -1)];
    }

    return $palavrapasse;
}

function verificaCheckOut()
{
    $currentTime = $_SERVER['REQUEST_TIME'];
    $pdo = conectarBD();

    $stmt = $pdo->prepare("SELECT * FROM Quarto WHERE codUsuario IS NOT NULL");

    $stmt->execute();


    while ($linhas  = $stmt->fetch())
    {
        if($linhas[checkOut] == $currentTime)
        {
            // comando UPdate para remover
        }

    }

}

function repeteNumero($numero,$hotel)
{
    try{

        $retorno = false;
        $pdo = conectarBD();
        $stmt = $pdo->query("select nQuarto from Quarto where codHotel = ".$hotel." ;");

        $stmt->execute();

        while( $num = $stmt->fetch())
        {
            if($num["nQuarto"] == $numero)
            {
                $retorno = true;
            }
        }

        return $retorno;
    }
    catch (PDOException $e)
    {
        echo "erro:".$e->getMessage();
    }


}