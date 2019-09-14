<?php
/**
 * Created by PhpStorm.
 * User: João
 * Date: 13/09/2019
 * Time: 17:30
 */

class User
{
private $id;
private $nome;
private $celular;
private $senha;
private $email;
private $dnasc;
private $apelido;

//getters

 public function getId()
 {
    return $this->id;
 }

 public function getNome()
 {
     return $this->nome;
 }

 public function getCelular()
 {
     return $this->celular;
 }

 public function getSenha()
 {
     return $this->senha;
 }

 public function getEmail()
 {
     return $this->email;
 }

 public function getApelido()
 {
    return $this->apelido;
 }

 public function getDnasc()
 {
    return $this->dnasc;
 }

//setters

 public function setId($id)
 {
    $this->id = $id;
 }

 public function setNome($nome)
 {
    $this->nome = $nome;
 }

 public function setCelular($celular)
 {
    $this->celular = $celular;
 }

 public function setDnasc($dnasc)
 {
    $this->dnasc = $dnasc;
 }

 public function setApelido($apelido)
 {
    $this->apelido = $apelido;
 }

 public function setEmail($email)
 {
    $this->email = $email;
 }

 public function setSenha($senha)
 {
    $this->senha = $senha;
 }

 //Demais metodos

public function loadByEmail($email)
{
        $sql = new Sql();
        $results = $sql->select("select * from Usuario where email = :EMAIL", array(":EMAIL"=>$email));

        if (count($results) > 0) {
            $row = $results[0];

            $this->setId($row['idUsuario']);
            $this->setNome($row['nome']);
            $this->setCelular($row['celular']);
            $this->setDnasc($row['dnasc']);
            $this->setApelido($row['apelido']);
            $this->setEmail($row['email']);
            $this->setSenha($row['senha']);
        }
}

    public function insere()
    {
        $sql = new Sql();
        $encryptSenha = md5($this->getSenha());

        //verifica se já existe PK
        $results = $sql->select("select * from Usuario where email = :email",
            array(':email' => $this->getEmail()));

        if (count($results) > 0) {
            echo "Usuário já Cadastrado!";
        } else { //insere
            $sql->query("INSERT INTO Usuario (dnasc,nome,apelido,celular,senha,email) values(:DNASC, :NOME, :NICK, :CEL, :SENHA, :EMAIL)",
                array(':NOME' => $this->getNome(),
                    ':DNASC' => $this->getDnasc(),
                    ':NICK' => $this->getApelido(),
                    ':CEL' => $this->getCelular(),
                    ':SENHA' => $encryptSenha,
                    ':EMAIL' => $this->getEmail())
            );
            echo "Usuario Cadastrado!";
        }
    }

    public function update($email,$nome,$dnasc,$nick,$cel,$senha)
    {
        $this->setNome($nome);
        $this->setCelular($cel);
        $this->setDnasc($dnasc);
        $this->setApelido($nick);
        $this->setEmail($email);
        $this->setSenha($senha);
        $encryptSenha = md5($this->getSenha());

        $sql = new Sql();

        $sql->query("UPDATE Usuario SET nome = :NOME, celular = :CEL, dnasc = :DNASC, apelido = :NICK, senha = :SENHA WHERE email = :email",
            array(':NOME' => $this->getNome(),
                ':DNASC' => $this->getDnasc(),
                ':NICK' => $this->getApelido(),
                ':CEL' => $this->getCelular(),
                ':SENHA' => $encryptSenha,
                ':EMAIL' => $this->getEmail())
        );
        echo "Cadastro Atualizado";
    }
}