<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Movie $model */

$this->title = 'Error Create Movie';
$this->params['breadcrumbs'][] = ['label' => 'Movies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movie-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::decode($message)) ?>
       <hr>
        <a href="javascript:history.back()" class="btn btn-primary">Fix it!</a>  
    </div>

</div>
