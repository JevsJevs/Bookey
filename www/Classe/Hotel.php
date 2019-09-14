<?php


class Hotel
{
    private $nome;
    private $senha;
    private $email;
    private $telefone;

//setter
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

//getter
    public function getNome()
    {
        return $this->nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }
//////////////////////////////////////////////

    public function insere()
    {

        $sql = new Sql();
        $encryptSenha = md5($this->getSenha());

        //verifica se já existe PK
        $results = $sql->select("select * from Hotel where email = :email",
            array(':email' => $this->getEmail()));
        if (count($results) > 0) {
            echo "Usuário já Cadastrado!";
        } else { //insere
            $sql->query("INSERT INTO Hotel (nome,senha,email,telefone) values(:NOME, :SENHA, :EMAIL, :TEL)",
                array(':NOME' => $this->getNome(),
                    ':TEL' => $this->getTelefone(),
                    ':SENHA' => $encryptSenha,
                    ':EMAIL' => $this->getEmail())
            );
            echo "Usuario Cadastrado!";
        }
    }
}