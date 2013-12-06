<?php
class GroupBuy implements JsonSerializable
{
    private $name;
    private $owner;
    private $ID;
    private $orders = array();
    private $startDate;
    private $endDate;
    private $notes;
    private $quote;
    private $orderSpreadsheet;
    private $catalog;
    private $tax;
    private $shipping;
    private $hopsOnly;
    private $grainOnly;
    private $allowSplit;
    private $splitAmt;
    private $supplier;
    private $markup;

    static function load($results)
    {
        $groupBuy = GroupBuy::loadMultiple($results);
        if (empty($groupBuy)) {
            return new GroupBuy();
        }

        return $groupBuy[0];
    }

    static function loadMultiple($results)
    {
        $groupBuys = array();
        $x = 0;
        if ($results != null) {
            foreach ($results as $row) {
                $groupBuy = GroupBuy::mapRow($row);
                $groupBuys[$x] = $groupBuy;
                $x++;
            }
        }
        return $groupBuys;
    }

    static function mapRow($row)
    {
        $groupBuy = new GroupBuy();
        if (!empty($row["id"])) {
            $groupBuy->setId($row["id"]);
        }
        if (!empty($row["name"])) {
            $groupBuy->setName($row["name"]);
        }
        if (!empty($row["owner"])) {
            $groupBuy->setOwner($row["owner"]);
        }
        if (!empty($row["startDt"])) {
            $groupBuy->setStartDate($row["startDt"]);
        }
        if (!empty($row["endDt"])) {
            $groupBuy->setEndDate($row["endDt"]);
        }
        if (!empty($row["quote"])) {
            $groupBuy->setQuote($row["quote"]);
        }
        if (!empty($row["notes"])) {
            $groupBuy->setNotes($row["notes"]);
        }
        if (!empty($row["catalog"])) {
            $groupBuy->setCatalog($row["catalog"]);
        }
        if (!empty($row["orderSpreadsheet"])) {
            $groupBuy->setOrderSpreadsheet($row["orderSpreadsheet"]);
        }
        if (!empty($row["tax"])) {
            $groupBuy->setTax($row["tax"]);
        }
        if (!empty($row["shipping"])) {
            $groupBuy->setShipping($row["shipping"]);
        }
        if (!empty($row["hops"])) {
            $groupBuy->setHopsOnly($row["hops"]);
        }
        if (!empty($row["grain"])) {
            $groupBuy->setGrainOnly($row["grain"]);
        }
        if (!empty($row["numOfSplit"])) {
            $groupBuy->setSplitAmt($row["numOfSplit"]);
        }
        if (!empty($row["allowSplit"])) {
            $groupBuy->setAllowSplit($row["allowSplit"]);
        }
        if (!empty($row["markup"])) {
            $groupBuy->setMarkup($row["markup"]);
        }
        if (!empty($row["supplier"])) {
            $groupBuy->setSupplier($row["supplier"]);
        } else {
            $groupBuy->setSupplier("ALL");
        }
        return $groupBuy;
    }

    public function isActive()
    {
        $now = time();
        if (strtotime($this -> getStartDate()) < $now && strtotime($this -> getEndDate()) >= $now) {
            return true;
        }

        return false;
    }

    public function getDaysRemaining()
    {
        $now = time();
        $start = strtotime($this -> getStartDate());
        $end = strtotime($this -> getEndDate());

        if ($start < $now && $end >= $now) {
            return ceil(abs($now - $end) / (60 * 60 * 24));
        }

        return ceil(abs($now - $start) / (60 * 60 * 24));
    }

    function allowSplit($numOfSplits)
    {
        if ($this->allowSplit) {
            if (empty($this->splitAmt)) {
                return true;
            } else if (($this->splitAmt > $numOfSplits)) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'owner' => $this->getOwner(),
            'name' => $this->getName(),
            'orders' => $this->getOrders(),
            'startDate' => $this->getStartDate(),
            'endDate' => $this->getEndDate(),
            'notes' => $this->getNotes(),
            'quote' => $this->getQuote(),
            'orderSpreadsheet' => $this->getOrderSpreadsheet(),
            'catalog' => $this->getCatalog(),
            'tax' => $this->getTax(),
            'shipping' => $this->getShipping(),
            'supplier' => $this->getSupplier(),
            'splitAmt' => $this->getSplitAmt(),
            'allowSplit' => $this->getAllowSplit(),
            'hopsOnly' => $this->getHopsOnly(),
            'grainOnly' => $this->getGrainOnly(),
            'markup' => $this->getMarkup()
        ];
    }

    public function getID()
    {
        return $this->ID;
    }

    public function setID($ID)
    {
        $this->ID = $ID;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getOrders()
    {
        return $this->orders;
    }

    public function setOrders($orders)
    {
        $this->orders = $orders;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    public function getQuote()
    {
        return $this->quote;
    }

    public function setQuote($quote)
    {
        $this->quote = $quote;
    }

    public function getOrderSpreadsheet()
    {
        return $this->orderSpreadsheet;
    }

    public function setOrderSpreadsheet($orderSpreadsheet)
    {
        $this->orderSpreadsheet = $orderSpreadsheet;
    }

    public function getCatalog()
    {
        return $this->catalog;
    }

    public function setCatalog($catalog)
    {
        $this->catalog = $catalog;
    }

    public function getTax()
    {
        return $this->tax;
    }

    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    public function getShipping()
    {
        return $this->shipping;
    }

    public function setShipping($shipping)
    {
        $this->shipping = $shipping;
    }

    public function getSupplier()
    {
        return $this->supplier;
    }

    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;
    }

    public function getSplitAmt()
    {
        return $this->splitAmt;
    }

    public function setSplitAmt($splitAmt)
    {
        $this->splitAmt = $splitAmt;
    }

    public function getAllowSplit()
    {
        return $this->allowSplit;
    }

    public function setAllowSplit($allowSplit)
    {
        $this->allowSplit = $allowSplit;
    }

    public function getHopsOnly()
    {
        return $this->hopsOnly;
    }

    public function setHopsOnly($hopsOnly)
    {
        $this->hopsOnly = $hopsOnly;
    }

    public function getGrainOnly()
    {
        return $this->grainOnly;
    }

    public function setGrainOnly($grainOnly)
    {
        $this->grainOnly = $grainOnly;
    }

    public function getMarkup()
    {
        return $this->markup;
    }

    public function setMarkup($markup)
    {
        $this->markup = $markup;
    }

    public function getFormattedStartDate()
    {
        return date('F d, Y', strtotime ($this->getStartDate()));
    }

    public function getFormattedEndDate()
    {
        return date('F d, Y', strtotime ($this->getEndDate()));
    }

}

?>