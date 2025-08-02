<?php

class User
{
    public $id;
    public $username;
    public $password;


    public function __construct($id, $username, $password)
    {
        $this->$id = $id;
        $this->$username = $username;
        $this->$password = $password;
    }

    public function loginUser($username, $password, mysqli $conn)
    {
        $queryStr = "SELECT * FROM user WHERE username='$username' AND password='$password'";
        return $conn->query($queryStr);
    }
}
