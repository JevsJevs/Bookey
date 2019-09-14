
<!DOCTYPE html>
<html>
<head>
    <title>Cadastro Hotel</title>
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

    <h2>Cadastro Empresa - Hotel</h2>

    <div class="col s10 m10 l10 offset-s1 ">

        <form id="Cadastra" method="post">

            <div class="row">
                <div class="col s5 offset-s1">Nome:<br><input type="text" name="nome"></div>
                <div class="col s4 offset-s1">E-mail:<br><input type="email" name="email"></div>
            </div>

            <div class="row">
                <div class="col s4 offset-s4">Telefone Celular:<br><input type="number" name="tel"></div>
            </div>

            <div class="row">
                <div class="col s5 offset-s1">Rua:<br><input type="text" name="rua"></div>
                <div class="col s3 offset-s2">Numero:<br><input type="number" name="numero"></div>
            </div>

            <div class="row">
                <div class="col s3 offset-s1">Bairro:<br><input type="text" name="bairro"></div>
                <div class="col s3 offset-s1">Cidade:<br><input type="text" name="cidade"></div>
                <div class="input-field col s2 offset-s1">
                    <select name="estado">
                        <option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AP">Amapá</option>
                        <option value="AM">Amazonas</option>
                        <option value="BA">Bahia</option>
                        <option value="CE">Ceará</option>
                        <option value="DF">Distrito Federal</option>
                        <option value="ES">Espírito Santo</option>
                        <option value="GO">Goiás</option>
                        <option value="MA">Maranhão</option>
                        <option value="MT">Mato Grosso</option>
                        <option value="MS">Mato Grosso do Sul</option>
                        <option value="MG">Minas Gerais</option>
                        <option value="PA">Pará</option>
                        <option value="PB">Paraíba</option>
                        <option value="PR">Paraná</option>
                        <option value="PE">Pernambuco</option>
                        <option value="PI">Piauí</option>
                        <option value="RJ">Rio de Janeiro</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="RS">Rio Grande do Sul</option>
                        <option value="RO">Rondônia</option>
                        <option value="RR">Roraima</option>
                        <option value="SC">Santa Catarina</option>
                        <option value="SP">São Paulo</option>
                        <option value="SE">Sergipe</option>
                        <option value="TO">Tocantins</option>
                    </select>
                    <label>Estados:</label>
                </div>
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
<script>
    M.AutoInit();
</script>

</html>

<?php

include ("EntraBd.php");

if($_SERVER["REQUEST_METHOD"] === 'POST')
{
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
}