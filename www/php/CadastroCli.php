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
        echo "Todos os parametros são obrigatórios, refaça o formulário";
    } else if (verificaSenha($senha1, $senha2)) {
        echo "As senhas não batem";
    } else if (verificaEmail($email,"Usuario")){
        echo "E-mail ja cadastrado! , use outro";
        // entrar no banco de dados e verificar se existem emails/ telefone igual iguais
    } else {
        echo $email;
        if(cadastrarUser($nome, $dnasc, $nick, $email, $cel, $senha1)) {
            echo "<span> Usuário Cadastrado!</span>";
            header("location: ../html/index.html");
        }
        else {
            echo "<span> Falha ao cadastrar</span>";
            header("location: ../html/CadCli.html");
        }
    }
}
catch (PDOException $e)
{
    echo "Error: " . $e->getMessage();
}

