<?php
class Split {
    private $id;
    private $owner;
	private $splitAmount;
	private $groupBuyId;
	private $product;

    public function setGroupBuyId($groupBuyId)
    {
        $this->groupBuyId = $groupBuyId;
    }

    public function getGroupBuyId()
    {
        return $this->groupBuyId;
    }


    public function setId($id)
    {
        $this->id = $id;
    }


    public function getId()
    {
        return $this->id;
    }


    public function setOwner($owner)
    {
        $this->owner = $owner;
    }


    public function getOwner()
    {
        return $this->owner;
    }


    public function setProduct($productId)
    {
        $this->product = $productId;
    }


    public function getProduct()
    {
        return $this->product;
    }


    public function setSplitAmount($splitAmount)
    {
        $this->splitAmount = $splitAmount;
    }


    public function getSplitAmount()
    {
        return $this->splitAmount;
    }

    static function mapRow ($row) {
        $split = new Split();
        if (isset($row["splitId"])) {
            $split->setId($row["splitId"]);
        }
        if (isset($row["owner"])) {
            $split->setOwner($row["owner"]);
        }
        if (isset($row["groupBuyId"])) {
            $split->setGroupBuyId($row["groupBuyId"]);
        }
        if (isset($row["splitAmt"])) {
            $split->setSplitAmount($row["splitAmt"]);
        }
        $split->setProduct(Product::load($row));
        return $split;
    }

	static function loadMultiple($results) {
        $splits = array();
        $x=0;
        if ($results != null) {
            foreach ($results as $row) {
                $split = Split::mapRow($row);
                $split->setProduct(Product::load($results));
                $splits[$x]=$split;
                $x++;
            }
        }
        return $splits;
	}

	static function load($results) {
		$splits = Split::loadMultiple($results);
		return $splits[0];
	}

	function totalAmountPounds($orders) {
		$totalPounds=0;
		foreach ($orders as $i => $value) {
			$order = $orders[$i];
			$grain = $order->get_grain();
			$totalPounds = $grain->get_pound()+$totalPounds;
		}
		return $totalPounds;
	}
}
?>