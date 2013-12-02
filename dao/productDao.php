<?php

class productDao {
    private $pdoObject;

    public function connect($host, $pdo) {
        try {
            $result = $this->pdoObject = $pdo;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        return null;
    }

    public function disconnect() {
        $pdo = $this->pdoObject;
        $pdo->close();
    }

    public function get($id) {
        $sql="select *,id as productId from product where id = ?";
        $pdo = $this->pdoObject;
        $sth=$pdo->prepare($sql);
        $sth->execute(array ($id) );
        $results = $sth->fetchAll();
        $product = Product::load($results);
        return $product;
    }

    public function save(Product $product) {
        $sql="INSERT INTO product (type,name,description,vendor,deactive,pounds,supplier,country,split,price,price4000,price8000,price12000,
            price32000) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $pdo = $this->pdoObject;
        $sth=$pdo->prepare($sql);
        $sth->execute(array (
            $product->getType(),
            $product->getName(),
            $product->getDescription(),
            $product->getVendor(),
            $product->getDeactive(),
            $product->getPounds(),
            $product->getSupplier(),
            $product->getCountry(),
            $product->getSplit(),
            $product->getPrice(),
            $product->getPrice4000(),
            $product->getPrice8000(),
            $product->getPrice12000(),
            $product->getPrice32000()
        ) );
        $results = $sth->fetchAll();
        $product = Product::load($results);
        return $product;
    }

    public function edit(Product $product) {
        $sql="Update product set type=?, name=?, description=?, vendor=?, deactive=?, pounds=?, supplier=?, country=?, split=?, price=?, price4000=?,
              price8000=?,price12000=?,price32000=? where id=?";
        $pdo = $this->pdoObject;
        $sth=$pdo->prepare($sql);
        $sth->execute(array (
            $product->getType(),
            $product->getName(),
            $product->getDescription(),
            $product->getVendor(),
            $product->getDeactive(),
            $product->getPounds(),
            $product->getSupplier(),
            $product->getCountry(),
            $product->getSplit(),
            $product->getPrice(),
            $product->getPrice4000(),
            $product->getPrice8000(),
            $product->getPrice12000(),
            $product->getPrice32000(),
            $product->getId()
        ) );
    }

    public function find($searchString, $supplier,$deactive) {
        try {
            if ($supplier != "ALL") {
                $sql = "Select * from product where (id like '%".$searchString."%' OR name like '%" . $searchString . "%' OR type like '%". $searchString."%' OR vendor like '%". $searchString."%') and supplier in ($supplier)";
            } else {
                $sql = "Select * from product where (id like '%".$searchString."%' OR name like '%" . $searchString . "%' OR type like '%". $searchString."%' OR vendor like '%". $searchString."%')";
            }
            if ($deactive != null) {
                $sql = $sql . " and deactive=0";
            }
            $sql = $sql . " ORDER BY vendor,name";
            $pdo = $this->pdoObject;
            $results=$pdo->query($sql);
            $products = Product::loadMultiple($results);
            return $products;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getByType($type) {
        if ($type != 'hops' && $type != 'grain') {
            return $this->getAllSupplies();
        }

        $sql="select *, id as productId from product where type = ? order by name";
        $pdo = $this->pdoObject;
        $sth=$pdo->prepare($sql);
        $sth->execute(array ($type) );
        $results = $sth->fetchAll();
        $products = Product::loadMultiple($results);
        return $products;
    }

    public function getAllSupplies() {
        $sql="select *, id as productId from product where type != 'hops' and type != 'grain' order by name";
        $pdo = $this->pdoObject;
        $sth=$pdo->prepare($sql);
        $sth->execute();
        $results = $sth->fetchAll();
        $products = Product::loadMultiple($results);
        return $products;
    }
}