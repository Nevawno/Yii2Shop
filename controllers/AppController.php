<?php

namespace app\controllers;

use yii\base\Controller;

class AppController extends Controller {

    protected function setMeta($title = null, $keyword = null, $description = null) {
        $this->view->title = $title;
        $this->view->registerMetaTag(['name' => 'keyword', 'content' => "$keyword"]);
        $this->view->registerMetaTag(['name' => 'keyword', 'content' => "$description"]);
    }
    
}