<?php
class utils {
	function getFlag($flag) {
		if ($flag == null) {
			return 0;
		} 
		return $flag;
	}

    function getMarkupPrice($user,$product,$groupBuy) {

        if ($product->getType() == "grain") {
            $price = $product->getPrice() * $product->getPounds();
        } else {
            $price = $product->getPrice();
        }
        $markup = $groupBuy->getMarkup();

        if ($user->getWholesale()) {
            return number_format($price,2);
        } else {
            return number_format(($price*$markup)+$price,2);
        }
    }

    function getWholeSalePrice($product,$groupBuyTotalPounds) {
        if ($product->getType() == "grain") {
            $price = $product->getPoundPrice($groupBuyTotalPounds) * $product->getPounds();
        } else {
            $price = $product->getPrice();
        }
        return number_format($price,2);
    }

    function getShipping($order,$groupBuyTotalPounds,$shipping) {

    }

    function getTax ($order) {

    }

}
?>