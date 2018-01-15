<?php
/**
 * Created by PhpStorm.
 * User: Viktoriya
 * Date: 09.01.2018
 * Time: 20:21
 */

namespace app\controllers;

use app\models\Cart;
use app\models\Product;
use app\models\Order;
use app\models\OrderItems;
use Yii;


class CartController extends AppController
{
    public function actionAdd() {
        $id = Yii::$app->request->get('id');
        $qry = (int)Yii::$app->request->get('qry');
        $qry = !$qry ? 1 : $qry;
        $product = Product::findOne($id);
        if (empty($product)) return false;
//        debug($product);
        $session = Yii::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->addToCart($product, $qry);
//        debug($session['cart']);
//        debug($session['cart.qry']);
//        debug($session['cart.sum']);
        if ( !Yii::$app->request->isAjax) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionClear() {
        $session = Yii::$app->session;
        $session->open();
        $session->remove('cart');
        $session->remove('cart.qry');
        $session->remove('cart.sum');
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionDelItem() {
        $id = Yii::$app->request->get('id');
        $session = Yii::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->recalc($id);
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));

    }

    public function actionShow() {
        $session = Yii::$app->session;
        $session->open();
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionView() {
        $session = Yii::$app->session;
        $session->open();
        $this->setMeta('Корзина');
        $order = new Order();
        if ($order->load(Yii::$app->request->post())) {
            $order->qry = $session['cart.qry'];
            $order->sum = $session['cart.sum'];

            if ($order->save()) {
                $this->saveOrderItems($session['cart'], $order->id);
                Yii::$app->session->setFlash('success', 'Ваш заказ принят!');

                Yii::$app->mailer->compose('order', ['session' => $session])->setFrom(['test@rff.fgh' => 'eshoper'])->setTo($order->email)->setSubject('заказ')->send();


                $session->remove('cart');
                $session->remove('cart.qry');
                $session->remove('cart.sum');

                return $this->refresh();
            }else{
                Yii::$app->session->setFlash('error', 'Ошибка в оформлении заказа!');
            }
        }
        return $this->render('view', compact('session', 'order'));

    }

    protected function saveOrderItems($items, $order_id) {
        foreach ($items as $id => $item) {
            $order_items = new OrderItems();
            $order_items->order_id = $order_id;
            $order_items->product_id = $id;
            $order_items->name = $item['name'];
            $order_items->price = $item['price'];
            $order_items->qty_item = $item['qry'];
            $order_items->sum_item = $item['qry'] * $item['price'];
            $order_items->save();

        }
    }
}