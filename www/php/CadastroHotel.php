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

        if ((trim($nome) == '') || (trim($rua) == '') || (trim($numero) == '') ||(trim($bairro) == '') || (trim($email) == '') ||(trim($cidade) == '') ||(trim($estado) == '') || (trim($tel) == '') || (trim($senha1) == '') || (trim($senha2) == '')) {
            echo "Todos os parametros são obrigatórios, refaça o formulário";
        } else if (verificaSenha($senha1, $senha2)) {
            echo "As senhas não batem";
        } else if (verificaEmail($email,"Hotel")){
            echo "E-mail ja cadastrado! , use outro";
            // entrar no banco de dados e verificar se existem emails/ telefone igual iguais
        } else {

            if(cadastrarHotel($nome, $rua,$bairro,$numero, $cidade,$estado, $email, $tel, $senha1))
                echo "<span> Hotel Cadastrado!</span>";
            else
                echo "<span> Falha ao cadastrar</span>";
        }
    }
    catch (PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

