<?php

namespace mickey\news\controllers\frontend;
use mickey\news\models\News;
use mickey\news\models\search\NewsSearch;
use Yii;
use yii\web\NotFoundHttpException;

class DefaultController extends \yii\web\Controller
{
    public function actionView($id) {
        $news=$this->findModel($id);

        return $this->render('view',array(
            'news'=>$news,
        ));
    }

    public function actionArchive($tag=null) {
        $searchModel=new NewsSearch();
//        $searchModel->visibility=News::VISIBILITY_ARCHIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('archive',array(
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ));
    }

    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSlug($slug)
    {
        $model = News::find()->where(['slug'=>$slug])->one();
        if (!is_null($model)) {
            return $this->render('view',array(
                'news'=>$model,
            ));
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
