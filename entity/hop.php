<?php

class Hop {
    private $id;
    private $name;
    private $usage;
    private $aroma;
    private $substitution;
    private $style;
    private $storage;
    private $aa;
    private $industry;
    private $productId;
    private $country;

    public function setAa($aa) {
        $this->aa = $aa;
    }

    public function getAa() {
        return $this->aa;
    }

    public function setAroma($aroma) {
        $this->aroma = $aroma;
    }

    public function getAroma() {
        return $this->aroma;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function getCountry() {
        return $this->country;

    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setIndustry($industry) {
        $this->industry = $industry;
    }

    public function getIndustry() {
        return $this->industry;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setProductId($productId) {
        $this->productId = $productId;
    }

    public function getProductId() {
        return $this->productId;
    }

    public function setStorage($storage) {
        $this->storage = $storage;
    }

    public function getStorage() {
        return $this->storage;
    }

    public function setStyle($style) {
        $this->style = $style;
    }

    public function getStyle() {
        return $this->style;
    }

    public function setSubstitution($substitution) {
        $this->substitution = $substitution;
    }

    public function getSubstitution() {
        return $this->substitution;
    }

    public function setUsage($usage) {
        $this->usage = $usage;
    }

    public function getUsage() {
        return $this->usage;
    }

    static function loadMultiple($results) {
        $hops = array();
        $x=0;
        foreach ($results as $row) {
            $hop = Hop::mapRow($row);
            $hops[$x]=$hop;
            $x++;
        }
        return $hops;
    }

    static function load($results) {
        $hops = Hop::loadMultiple($results);
        return $hops[0];
    }

    static function mapRow ($row) {
        $hop = new Hop();
        if (!empty($row["ID"])) {
            $hop->setId($row["ID"]);
        }
        if (!empty($row["name"])) {
            $hop->setName($row["name"]);
        }
        if (!empty($row["usage"])) {
            $hop->setUsage($row["usage"]);
        }
        if (!empty($row["aroma"])) {
            $hop->setAroma($row["aroma"]);
        }
        if (!empty($row["substitution"])) {
            $hop->setSubstitution($row["substitution"]);
        }
        if (!empty($row["style"])) {
            $hop->setStyle($row["style"]);
        }
        if (!empty($row["storage"])) {
            $hop->setStorage($row["storage"]);
        }
        if (!empty($row["aa"])) {
            $hop->setAa($row["aa"]);
        }
        if (!empty($row["industry"])) {
            $hop->setIndustry($row["industry"]);
        }
        if (!empty($row["country"])) {
            $hop->setCountry($row["country"]);
        }
        return $hop;
    }
}