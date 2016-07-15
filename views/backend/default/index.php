<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Nav;
use kartik\icons\Icon;
use mickey\news\models\News;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('News', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
<!--    --><?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
        <div class="span8">
            <?=Nav::widget([
                'items'=>[
                    [
                        'label' => Icon::show('list') . 'Все новости',
                        'url' => ['/news/default/index'],
                        'active'=>empty($_GET),
                    ],
                    [
                        'label' => Icon::show('eye') . 'Опубликованные',
                        'url'=>['/news/default/index', 'NewsSearch'=>['status'=>News::STATUS_ENABLED],
                            'active'=>$model->status==News::STATUS_ENABLED],
                    ],
                    [
                        'label' => Icon::show('eye-slash') . 'Черновики',
                        'url'=>['/news/default/index', 'NewsSearch'=>['status'=>News::STATUS_DISABLED],
                            'active'=>$model->status==News::STATUS_DISABLED],
                    ],
                ],
                'encodeLabels' => false,
                'options' => ['class' =>'nav-pills'], // set this to nav-tab to get tab-styled navigation
            ]);?>
        </div>
        <div class="pull-right">
            <?= Html::a(Yii::t('News', 'Create News'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'annotation:ntext',
            'content:ntext',
            'tags',
            // 'image',
            // 'status',
            // 'visibility',
            // 'publish_date',
            // 'created_at',
            // 'created_by',
            // 'updated_by',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
