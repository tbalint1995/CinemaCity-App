<?php

use app\widgets\SeatsWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Movie $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Movies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="movie-view">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <p> 
    <?php if( !Yii::$app->utils->hasReservedSeat($model->id) ): ?>    
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    <?php else: ?>      
        <?= Html::a('Eladott jegyek', ['tickets', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?php endif; ?>  
    </p>
    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'date',
            'start_time',
            'end_time',
            'price',
            'created_at',
            'updated_at',
        ],
    ]) ?>




<div class="seat-container mb-3 flex-column">  
                    <div class="d-flex w-100 mb-4">
                        <div class="w-50  h-auto  pt-2 border-top border-end">
                            <div class="row mb-1">
                                <label class="form-label col">
                                    Film:
                                </label>
                                <div class="col-9">
                                <?= $model->name ?>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label class="form-label col">
                                    Dátum:
                                </label>
                                <div class="col-9">
                                <?= $model->date ?>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label class="form-label col">
                                    Kezdés:
                                </label>
                                <div class="col-9">
                                <?= $model->start_time ?>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label class="form-label col">
                                    Befejezés:
                                </label>
                                <div class="col-9">
                                <?= $model->end_time ?>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label class="form-label col">
                                    Jegy ára:
                                </label>
                                <div class="col-9">
                                <?= $model->price ?> &euro;
                                </div>
                            </div>
                        </div>
                        <div class="w-50    border-top   h-auto  pt-2" style="font-size:80%">
                            <b>Eladott legyek</b>: <?=Yii::$app->utils->orderedSeatsNumber($model->id)?>
                            <br>
                            <b>Bevétel</b>: <?=(Yii::$app->utils->orderedSeatsNumber($model->id) *  $model->price).' &euro;'?>
                             
                        </div>
                    </div>

                    <h4>Moziterem: eladott helyek <?= Html::a('Részletek', ['tickets', 'id' => $model->id], ['class' => 'btn btn-primary']) ?></h4>
                    
            </div>    

<?= SeatsWidget::widget([ 'grid'=>['rows'=>4, 'cols'=>14 ], 'movie_id'=>$model->id, 'disabled'=>true ]) ?>

</div>
