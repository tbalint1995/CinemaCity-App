<?php

use app\models\Movie;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MovieSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tickets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movie-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Movie', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], 
			[

                'label'=>'Movie',
                'attribute'=>'title',
                'format' => 'raw',
                'value' => function($model) use ($movie) {
                    return Html::encode( $movie->name );
                }
              ],
              [

                'label'=>'Date',
                // 'filterAttribute'=>'date',
                // 'enableSorting'=>true,
                'format' => 'raw',
                'value' => function($model) use ($movie) {
                    return Html::encode( $movie->date );
                }
              ],
              [

                'label'=>'Start',
                'attribute'=>'start_time',
                'format' => 'raw',
                'value' => function($model) use ($movie) {
                    return Html::encode( $movie->start_time );
                }
              ],
              [

                'label'=>'End',
                'attribute'=>'end_time',
                'format' => 'raw',
                'value' => function($model) use ($movie) {
                    return Html::encode( $movie->end_time );
                }
              ],
              [

                'label'=>'Price',
                'attribute'=>'price',
                'format' => 'raw',
                'value' => function($model) use ($movie) {
                    return Html::encode( $movie->price );
                }
              ],
            'row_col',
            
            'name',
            'phone',
            'email' 
        ],
    ]); ?>


</div>
