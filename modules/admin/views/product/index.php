<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
//            'category_id',
        [
                'attribute' => 'category_id',
                'value' => function($data) {
                    return $data->category->name;
                }
        ],
            'code',
            'price',
            // 'availability',
            // 'description:ntext',
            // 'is_new',
            // 'is_recommended',
            // 'img',
            // 'content:ntext',
            // 'keywords',
            // 'hit',
            [
                'attribute' => 'hit',
                'value' => function($data) {
                    return !$data->hit ? '<span class="text-danger">нет</span>' : '<span class="text-success">да</span>';
                },
                'format' => 'html',
            ],
//             'new',
            [
                'attribute' => 'new',
                'value' => function($data) {
                    return !$data->new ? '<span class="text-danger">нет</span>' : '<span class="text-success">да</span>';
                },
                'format' => 'html',
            ],
            // 'sale',
            [
                'attribute' => 'sale',
                'value' => function($data) {
                    return !$data->sale ? '<span class="text-danger">нет</span>' : '<span class="text-success">да</span>';
                },
                'format' => 'html',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>