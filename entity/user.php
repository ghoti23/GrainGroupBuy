<?php
class User implements JsonSerializable {
	var $username;
	var $email;
	var $password;
	var $admin;
	var $approve;
    var $deactive;
    var $city;
    var $state;
    var $wholesale;

    public function setWholesale($wholesale)
    {
        $this->wholesale = $wholesale;
    }

    public function getWholesale()
    {
        return $this->wholesale;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

    public function getAdmin()
    {
        return $this->admin;
    }

    public function setApprove($approve)
    {
        $this->approve = $approve;
    }

    public function getApprove()
    {
        return $this->approve;
    }

    public function setDeactive($deactive)
    {
        $this->deactive = $deactive;
    }

    public function getDeactive()
    {
        return $this->deactive;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

	static function loadMultiple($results) {
		$users = array();
		$x=0;
		foreach ($results as $row) {
			$user = User::mapRow($row);
		 	$users[$x]=$user;
		 	$x++;
		}		
		return $users;
	}

	static function load($results) {
		$users = User::loadMultiple($results);
		return $users[0];
	}

	static function mapRow ($row) {
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
		return $user;
	}

    public function jsonSerialize() {
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
}
?>