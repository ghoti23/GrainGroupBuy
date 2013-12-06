<?php


class userDao {
    private $pdoObject;

    public function connect($host, $pdo) {
        try {
            $result = $this->pdoObject = $pdo;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        return null;
    }

    public function disconnect() {
        $pdo = $this->pdoObject;
        $pdo->close();
    }

    public function getUser($email) {
        try {
            $sql = "Select * FROM user where email = ?";
            //echo $sql . " " . $user->getEmail() . " " . $user->getPassword();
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ( $email ) );
            $count = $sth->rowCount();
            $results = $sth->fetchall();
            if ($count == 0) {
                return null;
            } else {
                $user = User::load($results);
                return $user;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

    public function login($user) {
        try {
            $sql = "Select * FROM user where email = ? and password = ?";
            //echo $sql . " " . $user->getEmail() . " " . $user->getPassword();
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ( $user->getEmail(),$user->getPassword() ) );
            $count = $sth->rowCount();
            $results = $sth->fetchall();
            if ($count == 0) {
                return null;
            } else {
                $user = User::load($results);
                return $user;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

    public function approveList() {
        try {
            $sql = "Select * FROM user where approve = 0 and deactive = 0";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute();
            $count = $sth->rowCount();

            if ($count == 0) {
                return null;
            } else {
                $results = $sth->fetchall();
                $users = User::loadMultiple($results);

                return $users;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function approveMember ($email) {
        try {
            $sql = 'UPDATE user set approve = 1 where email = ?';
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($email) );
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function updatePassword ($user) {
        try {
            $sql = 'UPDATE user set password = ? where email = ?';
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($user->getPassword(),$user->getEmail()) );
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateAccountPassword ($email, $password) {
        try {
            $sql = 'UPDATE user set password = ? where email = ?';
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($password, $email) );
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function loadUserForgotPassword ($id, $email) {
        try {
            $sql = 'Select * from user where password = ? and email = ?';
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute(array ($id,$email) );
            $results = $sth->fetchAll();
            $user = User::load($results);

            return $user;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getTotalMembers() {
        try {
            $total = 0;
            $sql = "SELECT COUNT( u.email ) as total FROM user u WHERE approve = 1";
            $pdo = $this->pdoObject;
            $sth=$pdo->prepare($sql);
            $sth->execute();
            $results = $sth->fetchAll();
            if ($results != null) {
                foreach ($results as $row) {
                    $total = $row["total"];
                }
            }

            return $total;

        } catch (Exception $e) {
            echo "Error: ". $e->getMessage();
        }
    }
}