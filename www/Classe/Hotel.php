<?php


class Hotel
{
    private $nome;
    private $senha;
    private $email;
    private $telefone;
    private $id;

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

    public function setId($id)
    {
        $this->id = $id;
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

    public function getId()
    {
        return $this->id;
    }
//////////////////////////////////////////////

    public function insere()
    {

        $sql = new Sql();
        $encryptSenha = md5($this->getSenha());

        //verifica se já existe email
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

    public function __construct($email)
    {
        $sql = new Sql();

        $row = $sql->select("SELECT * FROM Hotel Where email=:EMAIL",array(":EMAIL"=>$email));

        if(count($row)>0)
        {
            $resultado = $row[0];

            $this->setId($resultado['idHotel']);
            $this->setEmail($resultado['email']);
            $this->setNome($resultado['nome']);
            $this->setTelefone($resultado['Telefone']);
            $this->setSenha($resultado['senha']);
        }
    }

    public function __toString()
    {
        return "Id: ".$this->getId()."<br>Email: ".$this->getEmail()."<br>Senha: ".$this->getSenha();
    }

    public function __sleep()
    {
        return array('id','email','nome','telefone','senha');
    }

}