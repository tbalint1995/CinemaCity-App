<?php

use app\models\Movie;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MovieSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Napi vetítések: '.date('Y-m-d');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movie-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Movies list', ['movies'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Create Movie', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php  
    /**
     * 
     * Egy listát tartalmaz az aktuális napi vetítések listájával, amik még nem kezdődtek el. Ha
     * rákattint az egyikre, akkor átviszi a “Vetítés nézet” oldalra.
     * A táblázat tartalmazza a film címét, dátumot, kezdés időpontját, befejezés időpontját, jegy
     * árát, mennyi hely foglalt(Pl. 17/40)
     * 
     * **/
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'date',
            'start_time',
            'end_time',
            [
                'label' => 'Price',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::decode(  $model['price'] ).' &euro;';
                }
            ],
            //'created_at',
            //'updated_at',
            [
                'label' => 'Reserved',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::decode(  Yii::$app->utils->orderedSeatsNumber($model->id).'/40' );
                }
            ],
            [
                'label' => 'Details',
                'format' => 'raw',
                'value' => function($model) {
                    $url = Yii::$app->urlManager->createUrl(['admin/movie/view', 'id' => $model['id']]);
                    return Html::a('View', $url, ['class' => 'btn btn-primary']);
                }
            ],
        ],
    ]); ?>


</div>
