<?php /*
  *
  * $news - новость
  *
  * */
?>

<h3>
<?= $news->title; ?>
<span class="label">
    <?=Yii::$app->formatter->asDatetime($news->publish_date);?>
</span>
</h3>

<?php if ($news->image): ?>
        <img src="<?= $news->getImageUrl('thumb'); ?>">
<?php endif; ?>

<?= $news->content; ?>
