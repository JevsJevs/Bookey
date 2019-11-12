<?php

include("EntraBd.php");

try {

    $nome = $_POST["nome"];
    $dnasc = $_POST["dnasc"];
    $nick = $_POST["nick"];
    $email = $_POST["email"];
    $cel = $_POST["cel"];
    $senha1 = $_POST["senha1"];
    $senha2 = $_POST["senha2"];

    if ((trim($nome) == '') || (trim($dnasc) == '') || (trim($nick) == '') || (trim($email) == '') || (trim($cel) == '') || (trim($senha1) == '') || (trim($senha2) == '')) {
        header("location: Telas aviso/Cliente/FalhaCadastroAllParamCli.php");
    } else if (verificaSenha($senha1, $senha2)) {
        header("location: Telas aviso/Cliente/FalhaCadastroSenha.php");
    } else if (verificaEmail($email,"Usuario")){
        header("location: Telas aviso/Cliente/FalhaCadastroEmail.php");
        // entrar no banco de dados e verificar se existem emails/ telefone igual iguais
    } else {
        echo $email;
        if(cadastrarUser($nome, $dnasc, $nick, $email, $cel, $senha1)) {
            header("location: Telas aviso/CadastroConcluido.php");
        }
        else {
            header("location: Telas aviso/Cliente/FalhaCadastro.php");
        }
    }
}
catch (PDOException $e)
{
    echo "Error: " . $e->getMessage();
}

