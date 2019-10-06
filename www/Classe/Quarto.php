<?php


class Quarto
{
    private $idHotel;
    private $numQuarto;
    private $imagem;
    private $valDia;
    private $valTot;

    // AS VEZES NULL
    private $idUser;
    private $senhaEntra;


    public function getIdHotel()
    {
        return $this->idHotel;
    }


    public function getNumQuarto()
    {
        return $this->numQuarto;
    }


    public function getImagem()
    {
        return $this->imagem;
    }


    public function getValDia()
    {
        return $this->valDia;
    }

    // as vezes nulos
    public function getIdUser()
    {
        return $this->idUser;
    }

    public function getSenhaEntra()
    {
        return $this->senhaEntra;
    }

    public function getValTot()
    {
        return $this->valTot;
    }
////////////////////////////////////////////

    public function setIdHotel($idHotel)
    {
        $this->idHotel = $idHotel;
    }

    public function setNumQuarto($numQuarto)
    {
        $this->numQuarto = $numQuarto;
    }

    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
    }

    public function setValDia($valDia)
    {
        $this->valDia = $valDia;
    }

    //as vezes nulos

    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    public function setSenhaEntra($senhaEntra)
    {
        $this->senhaEntra = $senhaEntra;
    }

    public function setValTot($valTot)
    {
        $this->valTot = $valTot;
    }
//////////////////////////////////////////

    public function cadastrar()
    {
        $sql = new Sql();

        $sql->query("INSERT INTO Quarto (codUser,codHotel,nQuarto,Img,senhaEntra,valDiaria) VALUES (null,:codHotel,:numero,:imagem,null,:valDia)",
            array(
               ":codHotel"=>$this->getIdHotel(),
                ":numero"=>$this->getNumQuarto(),
                ":imagem"=>$this->getImagem(),
                ":valDia"=>$this->getValDia()
            ));
        echo "Quarto Cadastrado";
    }

    public function loadByHotelNum($emailHotel,$numero)
    {
        $sql = new Sql();
        $idHotel = $sql->query("SELECT idHotel FROM Hotel where email =:email ", array(":email"=>$emailHotel));

        $results = $sql->select("select * from Quarto where numero = :NUM AND codHotel = :HOTEL", array(":NUM"=>$numero, ":HOTEL"=>$idHotel));

        if (count($results) > 0) {
            $row = $results[0];

            $this->setIdHotel($row['codHotel']);
            $this->setNumQuarto($row['nQuarto']);
            $this->setImagem($row['Img']);
            $this->setValDia($row['valDiaria']);

            $this->setIdUser($row['codUser']);
            $this->setSenhaEntra($row['senhaEntra']);
        }
    }

    public function loadByidHnum($idh,$numero)
    {
        $sql = new Sql();

        $results = $sql->select("select * from Quarto where nQuarto = :NUM AND codHotel = :HOTEL", array(":NUM"=>$numero, ":HOTEL"=>$idh));

        if (count($results) > 0) {
            $row = $results[0];

            $this->setIdHotel($row['codHotel']);
            $this->setNumQuarto($row['nQuarto']);
            $this->setImagem($row['Img']);
            $this->setValDia($row['valDiaria']);

            $this->setIdUser($row['codUser']);
            $this->setSenhaEntra($row['senhaEntra']);
        }
    }

    public function __toString()
    {
        return "Quarto <br/>Id: ".$this->getIdHotel()."<br>Numero: ".$this->getNumQuarto()."<br>Senha: ".$this->getIdUser();
    }

    public function primLivre($idh)
    {
        $sql = new Sql();

        $results = $sql->select("select * from Quarto where codHotel = :HOTEL AND codUser IS NULL  AND checkIn IS NULL AND checkOut IS NULL;",
            array(":HOTEL"=>$idh));

        if (count($results) > 0) {
            $row = $results[0];

            $this->setIdHotel($row['codHotel']);
            $this->setNumQuarto($row['nQuarto']);
            $this->setImagem($row['Img']);
            $this->setValDia($row['valDiaria']);

            $this->setIdUser($row['codUser']);
            $this->setSenhaEntra($row['senhaEntra']);
        }
    }

    public function reservar($usuario,$cIn,$cOut,$valT)
    {
        $sql = new Sql();

        $sql->query("UPDATE Quarto SET codUser = :USUARIO,checkIn= :CIN, checkOut = :COUT, valTot = :VTOT WHERE codHotel= :CODH AND
                    nQuarto=:NQUART",
                array(
                    ":USUARIO"=>$usuario,
                    ":CIN"=>$cIn,
                    ":COUT"=>$cOut,
                    ":VTOT"=>$valT,
                    ":CODH"=>$this->getIdHotel(),
                    ":NQUART"=>$this->getNumQuarto()
                ));
        echo "reserva Concluida";
    }

    public function AttValorImg($Img,$valD)
    {
        $sql = new Sql();

        $sql->query("UPDATE Quarto SET Img = :IMAGEM,valDiaria= :VD WHERE codHotel= :CODH AND
                    nQuarto=:NQUART",
            array(
                ":IMAGEM"=>$Img,
                ":VD"=>$valD,
                ":CODH"=>$this->getIdHotel(),
                ":NQUART"=>$this->getNumQuarto()
            ));
        echo "Atualização Concluida";
    }
}