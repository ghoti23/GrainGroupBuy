<?php
class User implements JsonSerializable
{
    var $username;
    var $email;
    var $password;
    var $admin;
    var $approve;
    var $deactive;
    var $city;
    var $state;
    var $wholesale;
    var $firstName;
    var $lastName;
    var $zipCode;

    static function load($results)
    {
        $users = User::loadMultiple($results);
        return $users[0];
    }

    static function loadMultiple($results)
    {
        $users = array();
        $x = 0;
        foreach ($results as $row) {
            $user = User::mapRow($row);
            $users[$x] = $user;
            $x++;
        }
        return $users;
    }

    static function mapRow($row)
    {
        $user = new User();
        if (!empty($row["username"])) {
            $user->setUsername($row["username"]);
        }
        if (!empty($row["password"])) {
            $user->setPassword($row["password"]);
        }
        if (!empty($row["email"])) {
            $user->setEmail($row["email"]);
        }
        if (!empty($row["username"])) {
            $user->setAdmin($row["username"]);
        }
        if (!empty($row["admin"])) {
            $user->setAdmin($row["admin"]);
        }
        if (!empty($row["approve"])) {
            $user->setApprove($row["approve"]);
        }
        if (!empty($row["deactive"])) {
            $user->setDeactive($row["deactive"]);
        }
        if (!empty($row["wholesale"])) {
            $user->setWholesale($row["wholesale"]);
        }
        if (!empty($row["firstName"])) {
            $user->setFirstName($row["firstName"]);
        }
        if (!empty($row["lastName"])) {
            $user->setLastName($row["lastName"]);
        }
        if (!empty($row["zipCode"])) {
            $user->setZipCode($row["zipCode"]);
        }
        return $user;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param mixed $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    public function jsonSerialize()
    {
        return [
            'username' => $this->getUsername(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'admin' => $this->getAdmin(),
            'approve' => $this->getApprove(),
            'deactive' => $this->getDeactive(),
            'wholesale' => $this->getWholesale()
        ];
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getAdmin()
    {
        return $this->admin;
    }

    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

    public function getApprove()
    {
        return $this->approve;
    }

    public function setApprove($approve)
    {
        $this->approve = $approve;
    }

    public function getDeactive()
    {
        return $this->deactive;
    }

    public function setDeactive($deactive)
    {
        $this->deactive = $deactive;
    }

    public function getWholesale()
    {
        return $this->wholesale;
    }

    public function setWholesale($wholesale)
    {
        $this->wholesale = $wholesale;
    }
}

?>