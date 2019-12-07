<?php

namespace app\models;

use yii\db\ActiveRecord;

class Cart extends ActiveRecord {

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }


    public function addToCart($product, $qty = 1) {
        $mainImg = $product->getImage();
        if (isset($_SESSION['cart'][$product->id])) {
            $_SESSION['cart'][$product->id]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$product->id] = [
                'qty' => $qty,
                'name' => $product->name,
                'price' => $product->price,
                'img' => $mainImg->getUrl('x50'),
            ];
        }
        $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;
        $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $qty * $product->price : $qty * $product->price;
    }

    public function recalc($id) {
        if (!isset($_SESSION['cart'][$id])) { 
            return false;
        } else {
            $qtyminus = $_SESSION['cart'][$id]['qty'];
            $summinus = $_SESSION['cart'][$id]['sum'] * $_SESSION['cart'][$id]['price'];
            $_SESSION['cart.qty'] -= $qtyminus;
            $_SESSION['cart.sum'] -= $summinus;
            unset($_SESSION['cart'][$id]);
        }

    }

}