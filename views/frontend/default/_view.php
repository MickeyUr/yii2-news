<div class="item clearfix">
    <div class="row">
        <?php if ($model->image): ?>
            <div class="col-md-3">
                <a href="<?= $model->uri; ?>"><img src="<?= $model->getImageUrl('thumb'); ?>" class="img-responsive"></a>
            </div>
        <?php endif; ?>

        <div class="col-md-9">
            <div class="title"><a href="<?= $model->uri; ?>"><?= $model->title; ?></a></div>
            <div class="date"><?=Yii::$app->formatter->asDatetime($model->publish_date);?></div>
            <div class="text"><?= $model->annotation; ?></div>
        </div>
    </div>
</div>