<?php
class Product implements JsonSerializable
{
    private $Id;
    private $country;
    private $type;
    private $name;
    private $vendor;
    private $description;
    private $unitSize;
    private $price;
    private $price4000;
    private $price8000;
    private $price12000;
    private $price32000;
    private $pounds;
    private $supplier;
    private $split;
    private $deactive;
    private $amount;
    private $retailPrice = 13.72;
    private $imagePath;

    static function load($results)
    {
        $products = Product::loadMultiple($results);
        return $products[0];
    }

    static function loadMultiple($results)
    {
        $products = array();
        $x = 0;
        if ($results != null) {
            foreach ($results as $row) {
                $product = Product::mapRow($row);
                $products[$x] = $product;
                $x++;
            }
        }
        return $products;
    }

    static function mapRow($row)
    {
        $product = new Product();
        if (!empty($row["id"])) {
            $product->setId($row["id"]);
        }
        if (!empty($row["deactive"])) {
            $product->setDeactive($row["deactive"]);
        }
        if (!empty($row["type"])) {
            $product->setType($row["type"]);
        }
        if (!empty($row["name"])) {
            $product->setName($row["name"]);
        }
        if (!empty($row["country"])) {
            $product->setCountry($row["country"]);
        }
        if (!empty($row["vendor"])) {
            $product->setVendor($row["vendor"]);
        }
        if (!empty($row["description"])) {
            $product->setDescription($row["description"]);
        }
        if (!empty($row["price"])) {
            $product->setPrice($row["price"]);
        }
        if (!empty($row["price4000"])) {
            $product->setPrice4000($row["price4000"]);
        }
        if (!empty($row["price8000"])) {
            $product->setPrice8000($row["price8000"]);
        }
        if (!empty($row["price12000"])) {
            $product->setPrice12000($row["price12000"]);
        }
        if (!empty($row["price32000"])) {
            $product->setPrice32000($row["price32000"]);
        }
        if (!empty($row["pounds"])) {
            $product->setPounds($row["pounds"]);
        }
        if (!empty($row["supplier"])) {
            $product->setSupplier($row["supplier"]);
        }
        if (!empty($row["type"])) {
            $product->setType($row["type"]);
        }
        if (!empty($row["split"])) {
            $product->setSplit($row["split"]);
        }
        if (!empty($row["amount"])) {
            $product->setAmount($row["amount"]);
        }
        if (!empty($row["retailPrice"])) {
            $product->setRetailPrice($row["retailPrice"]);
        }
        if (!empty($row["imagePath"])) {
            $product->setImagePath($row["imagePath"]);
        }
        if (!empty($row["unitSize"])) {
            $product->setUnitSize($row["unitSize"]);
        }
        return $product;
    }

    /**
     * @return mixed
     */
    public function getUnitSize()
    {
        return $this->unitSize;
    }

    /**
     * @param mixed $unitSize
     */
    public function setUnitSize($unitSize)
    {
        $this->unitSize = $unitSize;
    }

    /**
     * @return mixed
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * @param mixed $imagePath
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    /**
     * @return mixed
     */
    public function getRetailPrice()
    {
        return $this->retailPrice;
    }

    /**
     * @param mixed $retailPrice
     */
    public function setRetailPrice($retailPrice)
    {
        $this->retailPrice = $retailPrice;
    }

    public function getUnits()
    {
        if ($this->getType() == 'hops') {
            return 1;
        }

        if ($this->getType() == 'grain') {
            if ($this->getSplit() > 0) {
                return ($this->getPounds() / $this->getSplit());
            } else {
                return $this->getPounds();
            }

        }

        return 1;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getSplit()
    {
        return $this->split;
    }

    public function setSplit($split)
    {
        $this->split = $split;
    }

    public function getPounds()
    {
        return $this->pounds;
    }

    public function setPounds($pounds)
    {
        $this->pounds = $pounds;
    }

    public function getDisplayUnits()
    {
        if ($this->getType() == 'hops') {
            return "1 lb";
        }

        if ($this->getType() == 'grain') {
            if ($this->getSplit() > 0) {
                return ($this->getPounds() / $this->getSplit()) . " lbs";
            } else {
                return $this->getPounds() . " lbs";
            }

        }

        return $this->getUnitSize();
    }

    public function getPoundsWithUnit()
    {
        if ($this->isHopOrGrain()) {
            return $this->getPounds() . " lbs";
        }

        return $this->getPounds();
    }

    public function isHopOrGrain()
    {
        return ($this->getType() == 'hops' || $this->getType() == 'grain');
    }

    public function getDisplayAmount()
    {
        if ($this->getType() == 'hops') {
            return round($this->getAmount() * 11) . " lbs";
        }

        if ($this->getType() == 'grain') {
            return ($this->getAmount() * $this->getPounds()) . " lbs";
        }

        return $this->getAmount();
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    function getPoundPrice($pounds)
    {
        $price = $this->getPrice();
        if ($pounds >= 2000 && $pounds < 8000) {
            $price = $this->getPrice4000();
        } else if ($pounds >= 8000 && $pounds < 12000) {
            $price = $this->getPrice8000();
        } else if ($pounds >= 12000 && $pounds < 32000) {
            $price = $this->getPrice12000();
        } else if ($pounds >= 32000) {
            $price = $this->getPrice32000();
        }
        return $price;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getPrice4000()
    {
        return $this->price4000;
    }

    public function setPrice4000($price4000)
    {
        $this->price4000 = $price4000;
    }

    public function getPrice8000()
    {
        return $this->price8000;
    }

    public function setPrice8000($price8000)
    {
        $this->price8000 = $price8000;
    }

    public function getPrice12000()
    {
        return $this->price12000;
    }

    public function setPrice12000($price12000)
    {
        $this->price12000 = $price12000;
    }

    public function getPrice32000()
    {
        return $this->price32000;
    }

    public function setPrice32000($price32000)
    {
        $this->price32000 = $price32000;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'deactive' => $this->getDeactive(),
            'country' => $this->getCountry(),
            'type' => $this->getType(),
            'name' => $this->getName(),
            'vendor' => $this->getVendor(),
            'description' => $this->getDescription(),
            'price' => $this->getPrice(),
            'price4000' => $this->getPrice4000(),
            'price8000' => $this->getPrice8000(),
            'price12000' => $this->getPrice12000(),
            'price32000' => $this->getPrice32000(),
            'pounds' => $this->getPounds(),
            'supplier' => $this->getSupplier(),
            'split' => $this->getSplit()
        ];
    }

    public function getId()
    {
        return $this->Id;
    }

    public function setId($Id)
    {
        $this->Id = $Id;
    }

    public function getDeactive()
    {
        return $this->deactive;
    }

    public function setDeactive($deactive)
    {
        $this->deactive = $deactive;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getVendor()
    {
        return $this->vendor;
    }

    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getSupplier()
    {
        return $this->supplier;
    }

    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;
    }

}

?>