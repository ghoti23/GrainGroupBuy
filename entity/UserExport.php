<?php

class UserExport implements JsonSerializable {
    var $productId;
    var $vendor;
    var $productName;
    var $price;
    var $amount;
    var $shipping;
    var $foodTax;
    var $nonFoodTax;
    var $total;

    public function jsonSerialize() {
        return [
            'productId' => $this->getProductId(),
            'vendor' => $this->getVendor(),
            'productName' => $this->getProductName(),
            'price' => $this->getPrice(),
            'amount' => $this->getAmount(),
            'shipping' => $this->getShipping(),
            'foodTax' => $this->getFoodTax(),
            'nonFoodTax' => $this->getNonFoodTax(),
            'total' => $this->getTotal()
        ];
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
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $foodTax
     */
    public function setFoodTax($foodTax)
    {
        $this->foodTax = $foodTax;
    }

    /**
     * @return mixed
     */
    public function getFoodTax()
    {
        return $this->foodTax;
    }

    /**
     * @param mixed $nonFoodTax
     */
    public function setNonFoodTax($nonFoodTax)
    {
        $this->nonFoodTax = $nonFoodTax;
    }

    /**
     * @return mixed
     */
    public function getNonFoodTax()
    {
        return $this->nonFoodTax;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param mixed $productName
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;
    }

    /**
     * @return mixed
     */
    public function getProductName()
    {
        return $this->productName;
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
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $vendor
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * @return mixed
     */
    public function getVendor()
    {
        return $this->vendor;
    }

}