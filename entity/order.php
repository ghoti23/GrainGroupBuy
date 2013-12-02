<?php
class Order {
	private $email;
	private $amount;
	private $groupBuy;
	private $product;
    private $split;
    private $user;
    private $paid;
    private $shipping;
    private $tax;

    public function setPaid($paid) {
        $this->paid = $paid;
    }

    public function getPaid()  {
        return $this->paid;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getUser() {
        return $this->user;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setGroupBuy($groupBuy) {
        $this->groupBuy = $groupBuy;
    }

    public function getGroupBuy() {
        return $this->groupBuy;
    }

    public function setProduct($product) {
        $this->product = $product;
    }

    public function getProduct() {
        return $this->product;
    }

    public function setSplit($split) {
        $this->split = $split;
    }

    public function getSplit() {
        return $this->split;
    }

	static function loadMultiple($results) {
		$orders = array();
		$x=0;
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
		 	$order->setProduct(Product::loadMultiple($results));
            $order->setUser(User::mapRow($row));
            if (!empty($row["paid"])) {
                $order->setPaid($row["paid"]);
            }
		 	$orders[$x]=$order;
		 	$x++;
		}
		return $orders;
	}

	static function load($results) {
		$orders = Order::loadMultiple($results);
        if (empty($orders)) {
            return new Order();
        }
		return $orders[0];
	}

	function totalAmountPounds($orders) {
		$totalPounds=0;
		foreach ($orders as $i => $value) {
			$order = $orders[$i];
			$product = $order->getProduct();
			$totalPounds = $product->getPounds()+$totalPounds;
		}
		return $totalPounds;
	}
}
?>