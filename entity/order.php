<?php
class Order
{
    private $email;
    private $amount;
    private $groupBuy;
    private $product;
    private $split;
    private $user;
    private $paid;
    private $createDate;
    private $shipping;
    private $tax;

    static function load($results)
    {
        $orders = Order::loadMultiple($results);
        if (empty($orders)) {
            return new Order();
        }
        return $orders[0];
    }

    static function loadMultiple($results)
    {
        $orders = array();
        $x = 0;
        foreach ($results as $row) {
            $order = new Order();
            if (isset($row["email"])) {
                $order->setEmail($row["email"]);
            }
            if (isset($row["groupBuyId"])) {
                $order->setGroupBuy($row["groupBuyId"]);
            }
            if (!empty($row["amount"])) {
                $order->setAmount($row["amount"]);
            }
            if (!empty($row["createDate"])) {
                $order->setCreateDate($row["createDate"]);
            }
            $order->setProduct(Product::loadMultiple($results));
            $order->setUser(User::mapRow($row));
            if (!empty($row["paid"])) {
                $order->setPaid($row["paid"]);
            }
            $orders[$x] = $order;
            $x++;
        }
        return $orders;
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
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @param mixed $shipping
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;
    }

    /**
     * @return mixed
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param mixed $tax
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    public function getPaid()
    {
        return $this->paid;
    }

    public function setPaid($paid)
    {
        $this->paid = $paid;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getGroupBuy()
    {
        return $this->groupBuy;
    }

    public function setGroupBuy($groupBuy)
    {
        $this->groupBuy = $groupBuy;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct($product)
    {
        $this->product = $product;
    }

    public function getSplit()
    {
        return $this->split;
    }

    public function setSplit($split)
    {
        $this->split = $split;
    }

    function totalAmountPounds($orders)
    {
        $totalPounds = 0;
        foreach ($orders as $i => $value) {
            $order = $orders[$i];
            $product = $order->getProduct();
            $totalPounds = $product->getPounds() + $totalPounds;
        }
        return $totalPounds;
    }
}

?>