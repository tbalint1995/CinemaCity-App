<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

/** @var yii\web\View $this */
/** @var app\models\Movie $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="movie-form col-md-6 col-lg-4">

    <?php $form = ActiveForm::begin([
        'id' => 'movie-form',
        'enableClientValidation' => true,
        'enableAjaxValidation' => false,
    ]); ?>

    <?= $form->field($model, 'name')->textInput()   ?>

    <?= $form->field($model, 'date')->textInput(['type'=>'date', 'min'=>date('Y-m-d')]) ?>

    <?= $form->field($model, 'start_time')->textInput(['type'=>'time', 'value'=>date('H:i', strtotime($model->start_time))]) ?>

    <?= $form->field($model, 'end_time')->textInput(['type'=>'time', 'value'=>date('H:i', strtotime($model->end_time))]) ?>

    <?= $form->field($model, 'price')->textInput(['type'=>'number',  'min'=>0, 'step'=>'0.01']) ?>

 

    <div class="form-group mt-3">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

 


