<?php
/**
 * Created by PhpStorm.
 * User: Viktoriya
 * Date: 04.01.2018
 * Time: 14:49
 */

namespace app\controllers;


use app\models\ContactForm;
use yii\web\Controller;

class AppController extends Controller
{
    protected function setMeta($title = null, $keywords = null, $description = null)
    {
        $this->view->title = $title;
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => "$keywords"]);
        $this->view->registerMetaTag(['name' => 'description', 'content' => "$description"]);
    }
}