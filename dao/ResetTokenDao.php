<?php
class ResetTokenDao {

    private $pdoObject;

    public function connect($host, $pdo) {
        try {
            $this->pdoObject = $pdo;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        return null;
    }

    public function disconnect() {
        $pdo = $this->pdoObject;
        $pdo->close();
    }

    public function get($id) {
        $sql="select * from reset_token where id = ?";
        $pdo = $this->pdoObject;
        $sth=$pdo->prepare($sql);
        $sth->execute(array ($id) );
        $results = $sth->fetchAll();

        if ($results != null) {
            foreach ($results as $row) {
                return ResetToken::mapRow($row);
            }
        }

        return null;
    }

    public function insert($email) {
        try {
            $id = substr(md5(rand()),0,24);

            $sql = "INSERT INTO reset_token (id, email) VALUES (?,?)";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ( $id, $email) );

            return $id;

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

}
?>