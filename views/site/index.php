<?php
use yii\grid\GridView;
/** @var yii\web\View $this */
use app\widgets\SeatsWidget;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Html;

$this->title = 'Előadások listája';

$MOVIE_ID = 1;

?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-12">
            <div class="seat-container d-block mb-3">
                <h2>Előadások listája</h2>
                
            </div>    
<?php

$dataProvider = new yii\data\ArrayDataProvider([
    'allModels' => $available_movies,
    'sort' => [
        'attributes' => ['start', 'name'],
    ],
    'pagination' => [
        'pageSize' => 10,
    ],
]);

 

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'name',
        'start',
        'end_time',
        [
            'label' => 'Duration',
            'format' => 'raw',
            'value' => function($model) {
              
                return Html::decode(  ((strtotime($model['end'])-strtotime($model['start'])) / 60) ).' min.';
            }
        ],
        [
            'label' => 'Price',
            'format' => 'raw',
            'value' => function($model) {
                return Html::decode(  $model['price'] ).' &euro;';
            }
        ],
        [
            'label' => 'Buy Ticket',
            'format' => 'raw',
            'value' => function($model) {
                $url = Yii::$app->urlManager->createUrl(['ticket/buy', 'id' => $model['id']]);
                return Html::a('Buy', $url, ['class' => 'btn btn-primary']);
            }
        ],
    ],
]);
?>

 
    </div>
</div>
 