<?php

include("EntraBd.php");

    try {

        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $tel = $_POST["tel"];
        $rua = $_POST["rua"];
        $bairro = $_POST["bairro"];
        $numero = $_POST["numero"];
        $cidade = $_POST["cidade"];
        $estado = $_POST["estado"];
        $senha1 = $_POST["senha1"];
        $senha2 = $_POST["senha2"];
        $descricao = $_POST["descreve"];

        if ((trim($nome) == '') || (trim($rua) == '') || (trim($numero) == '') ||(trim($bairro) == '') || (trim($email) == '') ||(trim($cidade) == '') ||(trim($estado) == '') || (trim($tel) == '') || (trim($senha1) == '') || (trim($senha2) == '') || (trim($descricao)) == '' ) {
            header("location: Telas aviso/Hotel/FalhaCadastroAllParamHt.php");
        } else if (verificaSenha($senha1, $senha2)) {
            header("location: Telas aviso/Hotel/FalhaCadastroSenhaht.php");
        } else if (verificaEmail($email,"Hotel")){
            header("location: Telas aviso/Hotel/FalhaCadastroEmailht.php");
            // entrar no banco de dados e verificar se existem emails/ telefone igual iguais
        } else {

            if(cadastrarHotel($nome, $rua,$bairro,$numero, $cidade,$estado, $email, $tel, $senha1,$descricao))
                header("location: Telas aviso/CadastroConcluido.php");
            else
                header("location: Telas aviso/Hotel/FalhaCadastroht.php");
        }
    }
    catch (PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

