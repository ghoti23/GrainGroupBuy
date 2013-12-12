<?php
class ProductSplit
{
    private $id;
    private $email;
    private $amount = 0;
    private $groupBuyId;
    private $createDate;
    private $product;
    private $allEmails = array();

    static function mapRow($row)
    {
        $split = new ProductSplit();
        if (isset($row["id"])) {
            $split->setId($row["id"]);
        }
        if (isset($row["email"])) {
            $split->setEmail($row["email"]);
        }
        if (isset($row["groupBuyId"])) {
            $split->setGroupBuyId($row["groupBuyId"]);
        }
        if (isset($row["amount"])) {
            $split->setAmount($row["amount"]);
        }
        if (isset($row["createDate"])) {
            $split->setCreateDate($row["createDate"]);
        }
        $split->setProduct(Product::mapRow($row));
        return $split;
    }

    static function loadMultiple($results)
    {
        $splits = array();
        $x = 0;
        if ($results != null) {
            foreach ($results as $row) {
                $split = ProductSplit::mapRow($row);
                $splits[$x] = $split;
                $x++;
            }
        }
        return ProductSplit::process($splits);
    }

    static function load($results)
    {
        $splits = ProductSplit::loadMultiple($results);
        return $splits[0];
    }

    static function process($products)
    {
        $splits = array();
        foreach ($products as $product) {
            $id = $product->getId();
            if (!isset($splits[$id])) {
                $splits[$id] = $product;
            } else {
                $splits[$id]->setAmount(($product->getAmount() + $splits[$id]->getAmount()));
            }

            $productSplit = $splits[$id];
            $amount = round($productSplit->getAmount(), 2);
            $whole = floor($amount);
            $fraction = $amount - $whole;

            if ($whole >= 1) {
                if ($fraction == 0) {
                    unset($splits[$id]);
                    continue;
                }

                $productSplit->setAmount($fraction);
                $productSplit->setAllEmails(array());
                continue;
            }

            $productSplit->addEmail($product->getEmail());
        }

        return $splits;
    }

    public function getGroupBuyId()
    {
        return $this->groupBuyId;
    }

    public function setGroupBuyId($groupBuyId)
    {
        $this->groupBuyId = $groupBuyId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
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

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct($productId)
    {
        $this->product = $productId;
    }

    /**
     * @param array $allEmails
     */
    public function setAllEmails($allEmails)
    {
        $this->allEmails = $allEmails;
    }

    /**
     * @return array
     */
    public function getAllEmails()
    {
        return $this->allEmails;
    }

    public function addEmail($email) {
        array_push($this->allEmails, $email);
    }

    public function getPercentComplete()
    {
        return round($this->getAmount() * 100);
    }

    public function getDisplayAmount()
    {
        if ($this->getProduct()->getType() == 'hops') {
            return round(($this->getAmount() * 11)) . " lbs";
        }

        if ($this->getProduct()->getType() == 'grain') {
            return ($this->getAmount() * $this->getProduct()->getPounds()) . " lbs";
        }

        return $this->getAmount();
    }

}
?>