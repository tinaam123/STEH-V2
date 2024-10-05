<?php
class Prijava
{
    public $id;
    public $predmet;
    public $katedra;
    public $sala;
    public $datum;

    public function __construct($id, $katedra, $predmet, $sala, $datum)
    {
        $this->id = $id;
        $this->katedra = $katedra;
        $this->predmet = $predmet;
        $this->sala = $sala;
        $this->datum = $datum;
    }

    public static function getAll(mysqli $conn)
    {

        $query = "SELECT * FROM prijave";

        return $conn->query($query);
    }


    public static function delete($id, mysqli $conn)
    {
        $query = "DELETE FROM prijave WHERE id='$id'";

        return $conn->query($query);
    }

    public static function add(Prijava $prijava, mysqli $conn)
    {
        $query = "INSERT INTO prijave (predmet, katedra, sala, datum) 
        VALUES ('$prijava->predmet','$prijava->katedra','$prijava->sala','$prijava->datum')";

        return $conn->query($query);
    }

    public static function update(Prijava $prijava, mysqli $conn)
    {
        $query = "UPDATE prijave 
          SET predmet = '$prijava->predmet', 
              katedra = '$prijava->katedra', 
              sala = '$prijava->sala', 
              datum = '$prijava->datum' 
          WHERE id = $prijava->id";

        return $conn->query($query);
    }
}
