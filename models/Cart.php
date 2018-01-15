<?php
/**
 * Created by PhpStorm.
 * User: Viktoriya
 * Date: 09.01.2018
 * Time: 20:40
 */

namespace app\models;

use yii\db\ActiveRecord;

class Cart extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }
    public function addToCart($product, $qry = 1) {
        if (isset($_SESSION['cart'][$product->id])) {
            $_SESSION['cart'][$product->id]['qry'] += $qry;
        }else{
            $_SESSION['cart'][$product->id] = [
                'qry' => $qry,
                'name' => $product->name,
                'price' => $product->price,
                'img' => $product->img,
            ];
        }
        $_SESSION['cart.qry'] = isset($_SESSION['cart.qry']) ? $_SESSION['cart.qry'] + $qry : $qry;
        $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $qry * $product->price : $qry * $product->price;
    }

    public function recalc($id) {
        if (!isset($_SESSION['cart'][$id])) return false;
        $qryMinus = $_SESSION['cart'][$id]['qry'];
        $sumMinus = $_SESSION['cart'][$id]['qry'] * $_SESSION['cart'][$id]['price'];
        $_SESSION['cart.qry'] -= $qryMinus;
        $_SESSION['cart.sum'] -= $sumMinus;
        unset($_SESSION['cart'][$id]);
    }
}
