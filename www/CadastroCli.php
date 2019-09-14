<!DOCTYPE html>
<html>
<head>
    <title>Cadastro Usuário</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">

    <link rel="stylesheet" href="icons/material.css">
    <link rel="stylesheet" href="css/materialize.min.css">
    <link rel="stylesheet" href="css/classes.css">

</head>

<body>

<div class="topo-fixo z-depth-2 ">
    <div class="valign-wrapper light-blue black-text">
        <h5 class="titulo">Bookey</h5>
        <div>
            <i class="material-icons waves-effect waves-light waves-circle dropdown-button right" data-activates="submenu" data-gutter="5" data-constrainwidth="false">more_vert</i>

            <ul id="submenu" class="dropdown-content">
                <li><a href="sass.html">Sass</a></li>
                <li><a href="badges.html">Components</a></li>
                <li><a href="collapsible.html">JavaScript</a></li>
            </ul>
        </div>
    </div>

    <h2>Cadastro Clientes</h2>

    <div class="col s10 m10 l10 offset-s1 ">

        <form id="Cadastra" method="post">

            <div class="row">
                <div class="col s6 offset-s1">Nome:<br><input type="text" name="nome"></div>
                <div class="col s4">Data de Nascimento:<br><input type="date" name="dnasc"></div>
            </div>

            <div class="row">
                <div class="col s3 offset-s1">Username:<br><input type="text" name="nick"></div>
                <div class="col s7 ">E-mail:<br><input type="email" name="email"></div>
            </div>

            <div class="row">
                <div class=" col s6 offset-s3">Telefone Celular:<br><input type="number" name="cel"></div>
            </div>

            <div class="row">
                <div class="col s5 offset-s1">Senha:<br><input type="password" name="senha1"></div>
                <div class="col s5">Confirme a Senha: <br><input type="password" name="senha2"></div>
            </div>


            <div class="row">
                <div class="col s2 offset-s5"><input type="submit" value="Cadastrar"></div>
            </div>
        </form>

    </div>

</body>

<script src="js/jquery.min.js"></script>
<script src="js/materialize.min.js"></script>

</html>

<?php

include ("EntraBd.php");

if($_SERVER["REQUEST_METHOD"] === 'POST')
{
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
        if(cadastrarUser($nome, $dnasc, $nick, $email, $cel, $senha1))
            echo "<span> Usuário Cadastrado!</span>";
        else
            echo "<span> Falha ao cadastrar</span>";
    }
}
catch (PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }
}
