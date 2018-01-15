<?php
/**
 * Created by PhpStorm.
 * User: Viktoriya
 * Date: 08.01.2018
 * Time: 9:46
 */

namespace app\controllers;
use app\models\Category;
use app\models\Product;
use yii\web\HttpException;
use Yii;



class ProductController extends AppController
{
    public function actionView($id) {
//        $id = Yii::$app->request->get('id');
        $product = Product::findOne($id);

        if (empty($product))
            throw new HttpException(404, 'Такого товара не существует...');

        //        $product = Product::find()->with('category')->where(['id'=>$id])->limit(1)->one();

        $hits = Product::find()->where(['hit' => '1'])->limit(5)->all();

        $this->setMeta('E_SHOPER | ' . $product->name, $product->keywords, $product->description );

        return $this->render('view', compact('product', 'hits'));
    }

}