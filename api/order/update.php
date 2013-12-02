<?php   require '../../dao/splitDao.php';
        require '../../dao/orderDao.php';
        require '../../properties.php';
        require '../../entity/product.php';
        require '../../entity/groupbuy.php';
        require '../../entity/user.php';
        session_start();

    $orderDao = new orderDao();
    $orderDao->connect($host,$pdo);
    header('Content-type: application/json');

    if (!isset($_SESSION['user']) && empty($_SESSION['user'])) {
        $arr = array('message' => "not authenticated");
        json_encode($arr);
    }

    $user = $_SESSION['user'];

    $amounts = $_REQUEST["amountProduct"];
    $products = $_REQUEST["product"];
    $groupBuyId = strip_tags($_REQUEST["groupBuyId"]);


    $count = count($amounts);

    for ($i=0;$i<$count;$i++) {
        if ($amounts[$i] > 0) {
            $orderDao->setProductOrder($groupBuyId,$amounts[$i],$products[$i],$user);
        } else {
            $orderDao->removeProductOrder($groupBuyId,$products[$i],$user);
        }

    }
    $array = ['success' => true];
    echo json_encode($array, JSON_PRETTY_PRINT);
?>