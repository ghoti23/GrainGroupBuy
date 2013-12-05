<?php
class utils
{
    function getFlag($flag)
    {
        if ($flag == null) {
            return 0;
        }
        return $flag;
    }

    function getMarkupPrice($user, $product, $groupBuy)
    {
        if ($product->getType() == "grain") {
            $price = $product->getPrice() * $product->getPounds();
        } else {
            $price = $product->getPrice();
        }
        $markup = $groupBuy->getMarkup();

        if ($user->getWholesale()) {
            return number_format($price, 2);
        } else {
            return number_format(($price * $markup) + $price, 2);
        }
    }

    function getDisplayPrice($user, $product, $groupBuy)
    {
        if ($product->getType() == "grain") {
            if ($product->getSplit() > 0) {
                $price = $product->getPrice() * ($product->getPounds() / $product->getSplit());
            } else {
                $price = $product->getPrice() * $product->getPounds();
            }
        } elseif ($product->getType() == "hops") {
            $price = $product->getPrice() / $product->getPounds();
        } else {
            $price = $product->getPrice();
        }
        $markup = $groupBuy->getMarkup();

        if ($user->getWholesale()) {
            return number_format($price, 2);
        } else {
            return number_format(($price * $markup) + $price, 2);
        }
    }

    public function getDiscountPercent($price, $retailPrice)
    {
        if (empty($retailPrice) || empty($price)) {
            return null;
        }

        if ($price > $retailPrice) {
            return null;
        }

        return round((($retailPrice - $price) / $retailPrice) * 100);
    }

    function getWholeSalePrice($product, $groupBuyTotalPounds)
    {
        if ($product->getType() == "grain") {
            $price = $product->getPoundPrice($groupBuyTotalPounds) * $product->getPounds();
        } else {
            $price = $product->getPrice();
        }
        return number_format($price, 2);
    }

    function getShipping($order, $groupBuyTotalPounds, $shipping)
    {

    }

    function getTax($order)
    {

    }

}

?>