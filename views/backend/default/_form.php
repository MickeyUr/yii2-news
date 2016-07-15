<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\checkbox\CheckboxX;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'annotation')->widget('common\widgets\Redactor') ?>

    <?= $form->field($model, 'content')->widget('common\widgets\Redactor') ?>

<!--    --><?//= $form->field($model, 'tags')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->widget(FileInput::classname(), [
        'pluginOptions' => [
            'allowedFileExtensions'=>['jpg','gif','png'],
            'language' => 'de',
            'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            'browseLabel' =>  'Select Image',
            'initialPreview'=>[
                $model->getImageTag('thumb'),
//                Html::img("/images/moon.jpg", ['class'=>'file-preview-image', 'alt'=>'The Moon', 'title'=>'The Moon']),
            ]
        ],
        'options' => ['accept' => 'image/*'],
    ]);?>

    <?= $form->field($model, 'status')->widget(CheckboxX::classname(['initInputType'=>CheckboxX::INPUT_CHECKBOX]), [ 'pluginOptions'=>['threeState'=>false]]); ?>

    <?= $form->field($model, 'visibility')->dropDownList(
        Yii::$app->lookup->items('NewsVisibility'),
        ['prompt'=>Yii::t('Select','--- Выбор--- ')]
    ) ?>

    <?= $form->field($model, 'publish_date')->widget(\yii\jui\DatePicker::classname(), [
        'language' =>  substr(Yii::$app->language, 0, 2),
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('News', 'Create') : Yii::t('News', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
