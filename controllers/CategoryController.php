<?php

namespace app\controllers;
use app\models\Category;
use app\models\Product;
use Yii;
use yii\data\Pagination;

class CategoryController extends AppController {


    public function actionIndex() {
       $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
       $this->setMeta('E-shopper');
       return $this->render('index', compact('hits'));
    }

    public function actionView() {
        $id = Yii::$app->request->get('id');
        $category_name = Category::findOne($id);
        if (empty($category_name)) {
            throw new \yii\web\HttpException(404, 'Такой категории нет');
        }
        // $products = Product::find()->where(['category_id' => $id])->all();
        $query = Product::find()->where(['category_id' => $id]);
        $page = new Pagination(
            [
                'totalCount' => $query->count(), 
                'pageSize' => 3, 
                'forcePageParam' => false, 
                'pageSizeParam' => false
            ]
        );
        $products = $query->offset($page->offset)->limit($page->limit)->all();
        
        $this->setMeta('E-shopper | ' . $category_name->name, $category_name->keywords, $category_name->description);
        return $this->render('view', compact('products', 'category_name', 'page'));
    }

    public function actionSearch() {
        $q = trim(Yii::$app->request->get('q'));
        $this->setMeta('E-shopper | Поиск ' . $q);
        if (!$q) {
            return $this->render('search');
        }
        $query = Product::find()->where(['like', 'name', $q]);
        $page = new Pagination(
            [
                'totalCount' => $query->count(), 
                'pageSize' => 3, 
                'forcePageParam' => false, 
                'pageSizeParam' => false
            ]
        );
        $products = $query->offset($page->offset)->limit($page->limit)->all();
        return $this->render('search', compact('products', 'page', 'q'));
    }

}