<?php /*
  *
  * $dataProvider - news
  *
  * */ ?>
<div class="container">
    <div class="col-md-12" id="news">
        <div class="row">
            <div class="col-md-9 col-sm-7">
                <h1>NEWS</h1>
                <?= \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProvider,
                    'viewParams'=>['searchModel'=>$searchModel],
                    'summary' => "Показаны записи <b>{begin} - {end}</b>  из <b>{count}</b>.",
                    'layout' => '{items}{pager}',
                    'itemView' => '_view',
                    'options' => [
                        'tag' => 'div',
                        'class' => 'catalog_items',
                        'id' => 'list-wrapper',
                    ],
            //            'itemOptions' => [
            //                'tag' => 'div',
            //                'class' => 'item',
            //            ],
                ]);
                ?>
            </div>
            <div class="col-md-3 col-sm-5">
                <h1>Archive</h1>
            </div>
        </div>
    </div>
</div>