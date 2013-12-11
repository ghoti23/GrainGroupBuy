<?php

class groupBuyDao
{
    private $pdoObject;

    public function connect($host, $pdo)
    {
        try {
            $result = $this->pdoObject = $pdo;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        return null;
    }

    public function disconnect()
    {
        $pdo = $this->pdoObject;
        $pdo->close();
    }

    public function get($id)
    {
        try {
            $sql = 'Select * from groupbuy where ID = ?';
            $pdo = $this->pdoObject;
            $sth = $pdo->prepare($sql);
            $sth->execute(array($id));
            $results = $sth->fetchAll();
            $groupBuy = GroupBuy::load($results);

            return $groupBuy;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function selectCurrentGroupBuy()
    {
        try {
            $sql = 'select id,name,username AS owner,email AS ownerEmail,startDt,endDt from groupbuy join user owner on email = owner where (endDt >= CURRENT_DATE() or endDt is null) and startDt <= CURRENT_DATE()';
            $pdo = $this->pdoObject;
            $results = $pdo->query($sql);
            $orders = GroupBuy::loadMultiple($results);
            return $orders;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function selectNextGroupBuy()
    {
        try {
            $sql = 'select id,name,username AS owner,email AS ownerEmail,startDt,endDt from groupbuy join user owner on email = owner where startDt > CURRENT_DATE() order by startDt';
            $pdo = $this->pdoObject;
            $results = $pdo->query($sql);
            $orders = GroupBuy::loadMultiple($results);
            if (!empty($orders)) {
                return $orders[0];
            }

            return null;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function selectExpireGroupBuy()
    {
        try {
            $sql = 'select id, name, username AS owner, owner.email AS ownerEmail, startDt, endDt from groupbuy join user owner on email = owner where endDt <= CURRENT_DATE() order by endDt';
            $pdo = $this->pdoObject;
            $sth = $pdo->prepare($sql);
            $sth->execute();
            $results = $sth->fetchAll();
            $orders = GroupBuy::loadMultiple($results);
            return $orders;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getTopProducts()
    {
        try {
            $sql = "select p.* from product p, (SELECT id, SUM(amount*pounds) as total from product p left join user_order up on p.id = up.productId GROUP BY p.id ORDER BY total desc, p.id  LIMIT 3) pj where p.id = pj.id";
            $pdo = $this->pdoObject;
            $results = $pdo->query($sql);
            $products = Product::loadMultiple($results);
            return $products;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getTopGrains()
    {
        try {
            $sql = "select p.* from product p, (SELECT id, SUM(amount*pounds) as total from product p left join user_order up on p.id = up.productId and p.type = 'grain' GROUP BY p.id ORDER BY total desc, p.id  LIMIT 25) pj where p.id = pj.id";
            $pdo = $this->pdoObject;
            $results = $pdo->query($sql);
            $products = Product::loadMultiple($results);
            return $products;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getTopHops()
    {
        try {
            $sql = "select p.* from product p, (SELECT id, SUM(amount*pounds) as total from product p left join user_order up on p.id = up.productId and p.type = 'hops' GROUP BY p.id ORDER BY total desc, p.id  LIMIT 25) pj where p.id = pj.id";
            $pdo = $this->pdoObject;
            $results = $pdo->query($sql);
            $products = Product::loadMultiple($results);
            return $products;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getTopSupplies()
    {
        try {
            $sql = "select p.* from product p, (SELECT id, SUM(amount*pounds) as total from product p left join user_order up on p.id = up.productId and p.type = 'supply' GROUP BY p.id ORDER BY total desc, p.id  LIMIT 25) pj where p.id = pj.id";
            $pdo = $this->pdoObject;
            $results = $pdo->query($sql);
            $products = Product::loadMultiple($results);
            return $products;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getTopUsers()
    {
        try {
            $sql = "select product_total,split_total,(ifnull(product_total,0)+ifnull(split_total,0)) as total, u.username, u.email from user u left join product_total pt on pt.email = u.email left join split_total st on st.email=u.email order by total desc LIMIT 5";
            $pdo = $this->pdoObject;
            $results = $pdo->query($sql);
            return $results;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function activeGroupBuy($groupBuyID)
    {
        try {
            $sql = "select groupbuy.ID from groupbuy where (endDt >= CURRENT_DATE() or endDt is null) and startDt <= CURRENT_DATE()";
            $pdo = $this->pdoObject;
            $sth = $pdo->prepare($sql);
            $sth->execute(array($groupBuyID));
            $results = $sth->fetchAll();

            $ID = 0;

            foreach ($results as $row) {
                $ID = $row["ID"];
            }
            if ($ID > 0) {
                return 1;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function all()
    {
        try {
            $sql = "select * from groupbuy order by id";
            $pdo = $this->pdoObject;
            $sth = $pdo->prepare($sql);
            $sth->execute();
            $results = $sth->fetchAll();

            $orders = GroupBuy::loadMultiple($results);
            return $orders;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getGroupBuyUsers($groupbuy)
    {
        try {
            $sql = "SELECT DISTINCT u.email, u.username, u.password, u.admin, u.deactive, u.approve, u.wholesale,paid FROM groupbuy g JOIN user_product up ON g.ID = up.groupbuyId JOIN user u ON u.email = up.email LEFT JOIN groupbuy_paid gp on gp.groupBuyId = g.Id AND gp.email = u.email where g.ID =? UNION ALL SELECT DISTINCT u.email, u.username, u.password, u.admin, u.deactive, u.approve, u.wholesale,paid FROM groupbuy g JOIN user_product up ON g.ID = up.groupbuyId JOIN user u ON u.email = up.email RIGHT JOIN groupbuy_paid gp on gp.groupBuyId = g.Id AND gp.email = u.email where g.ID = ?  order By username";
            $pdo = $this->pdoObject;
            $sth = $pdo->prepare($sql);
            $sth->execute(array($groupbuy, $groupbuy));
            $results = $sth->fetchAll();
            $orders = Order::loadMultiple($results);
            $userArray = array();
            foreach ($orders as $order) {
                $user = $order->getUser();
                $userArray[$user->getEmail()] = $order;
            }

            //Splitting this up as current hosting site is having issues with performance
            $sql = "SELECT DISTINCT u.email, u.username, u.password, u.admin, u.deactive, u.approve, u.wholesale,paid FROM groupbuy g JOIN split s ON s.groupBuyId = g.ID JOIN user_split us ON s.id = us.splitId JOIN user u ON u.email = us.email left join groupbuy_paid gp on g.ID = gp.groupBuyId and u.email = gp.email where g.ID = ? UNION ALL SELECT DISTINCT u.email, u.username, u.password, u.admin, u.deactive, u.approve, u.wholesale,paid FROM groupbuy g JOIN split s ON s.groupBuyId = g.ID JOIN user_split us ON s.id = us.splitId JOIN user u ON u.email = us.email RIGHT join groupbuy_paid gp on g.ID = gp.groupBuyId and u.email = gp.email where g.ID = ? order by username";
            $pdo = $this->pdoObject;
            $sth = $pdo->prepare($sql);
            $sth->execute(array($groupbuy, $groupbuy));
            $results = $sth->fetchAll();
            $orders = Order::loadMultiple($results);

            foreach ($orders as $order) {
                $user = $order->getUser();
                if (!array_key_exists($user->getEmail(), $userArray)) {
                    $userArray[$user->getEmail()] = $order;
                }
            }
            return $userArray;

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function fullGroupBuyOrderGrain($groupBuyID)
    {
        try {
            //Loads full bags
            $sql = "SELECT vendor, product.id, product.name, pounds, SUM( amount ) AS amount,price, price4000, price8000, price12000, price32000,type,product.supplier FROM groupbuy INNER JOIN user_product ON groupBuyID = groupbuy.ID INNER JOIN product ON product.id = productId WHERE groupbuy.ID =? GROUP BY product.ID ORDER BY product.supplier, vendor, product.ID";
            $pdo = $this->pdoObject;
            $sth = $pdo->prepare($sql);
            $sth->execute(array($groupBuyID));
            $results = $sth->fetchall();
            $products = Product::loadMultiple($results);
            $productArray = array();

            foreach ($products as $product) {
                $productArray[$product->getId()] = $product;
            }

            //Loads split bags
            $sql = "SELECT vendor, p.id, p.name, pounds, count( p.Id ) AS amount, price, price4000, price8000, price12000, price32000,groupBuyId, type, supplier,splitAmt FROM split s JOIN product p ON s.productId = p.ID WHERE groupBuyId =? GROUP BY p.supplier,productId";
            $pdo = $this->pdoObject;
            $sth = $pdo->prepare($sql);
            $sth->execute(array($groupBuyID));
            $results = $sth->fetchall();
            foreach ($results as $row) {
                $product = Product::mapRow($row);
                if (array_key_exists($product->getId(), $productArray)) {
                    $currentOrder = $productArray[$product->getId()];
                    unset($productArray[$product->getId()]);
                    $existingAmount = $currentOrder->getAmount();
                    $currentAmount = $product->getAmount();
                    $product->setAmount($existingAmount + $currentAmount);
                }
                $productArray[$product->getId()] = $product;
            }

            return $productArray;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function add($groupBuy, $user)
    {
        try {
            $sql = "INSERT INTO groupbuy (name,owner,startDt,endDt,quote,notes,catalog,orderSpreadsheet,hops,grain,allowSplit,numOfSplit) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            $pdo = $this->pdoObject;
            $sth = $pdo->prepare($sql);
            $valid = $sth->execute(array($groupBuy->getName(),
                $user->getEmail(),
                $groupBuy->getStartDate(),
                $groupBuy->getEndDate(),
                $groupBuy->getQuote(),
                $groupBuy->getNotes(),
                $groupBuy->getCatalog(),
                $groupBuy->getOrderSpreadsheet(),
                $groupBuy->getHopsOnly(),
                $groupBuy->getGrainOnly(),
                $groupBuy->getAllowSplit(),
                $groupBuy->getSplitAmt()));

            return $pdo->lastInsertId();

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function update($groupBuy)
    {
        try {
            $sql = "UPDATE groupbuy set name = ?, startDt=?, endDt=?, quote=?, notes=?, hops=?, grain=?, shipping=?, catalog=?, orderSpreadsheet=?, tax=?, allowSplit=?, numOfSplit=? WHERE id=?";
            $pdo = $this->pdoObject;
            $sth = $pdo->prepare($sql);
            $valid = $sth->execute(array($groupBuy->getName(),
                $groupBuy->getStartDate(),
                $groupBuy->getEndDate(),
                $groupBuy->getQuote(),
                $groupBuy->getNotes(),
                $groupBuy->getHopsOnly(),
                $groupBuy->getGrainOnly(),
                $groupBuy->getShipping(),
                $groupBuy->getCatalog(),
                $groupBuy->getOrderSpreadsheet(),
                $groupBuy->getTax(),
                $groupBuy->getAllowSplit(),
                $groupBuy->getSplitAmt(),
                $groupBuy->getId()));
            return $valid;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}