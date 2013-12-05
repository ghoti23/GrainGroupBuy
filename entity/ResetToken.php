<?php

class ResetToken
{
    private $id;
    private $email;
    private $createDate;

    static function mapRow($row)
    {
        $token = new ResetToken();
        if (isset($row["id"])) {
            $token->setId($row["id"]);
        }
        if (isset($row["email"])) {
            $token->setEmail($row["email"]);
        }
        if (isset($row["createDate"])) {
            $token->setCreateDate($row["createDate"]);
        }

        return $token;
    }

    /**
     * @return mixed
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param mixed $createDate
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


}

?>