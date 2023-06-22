<?php
use yii\grid\GridView;
/** @var yii\web\View $this */
use app\widgets\SeatsWidget;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Html;

$this->title = 'Válassza ki a  kívánt helyeket!';

$MOVIE_ID = $_GET['id'];

$helper = Yii::$app->utils;

?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
        <?php 
            $form = ActiveForm::begin([
                'id' => 'reserve-form',
                'options' => ['class' => 'col-12'],
            ]) 
        ?>
            <div class="seat-container mb-3 flex-column"> 
            <h4 class="mb-4">Jegyvásárlás: <?=$movie["name"].' '.$helper->realistic_datetime($movie["start"], strtotime($movie["start_time"]), strtotime($movie["end_time"]));?> </h4>
              

               
                    <div class="d-flex w-100 mb-4">
                        <div class="w-50  h-auto  pt-2 border-top border-end">
                            <div class="row mb-1">
                                <label class="form-label col">
                                    Név:
                                </label>
                                <div class="col-9">
                                <?= $form->field($model, 'name')->textInput()->label(false) ?>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label class="form-label col">
                                    Tel.:
                                </label>
                                <div class="col-9">
                                <?= $form->field($model, 'phone')->textInput()->label(false) ?>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <label class="form-label col">
                                    E-mail:
                                </label>
                                <div class="col-9">
                                <?= $form->field($model, 'email')->textInput()->label(false) ?>
                                </div>
                            </div>
                        </div>
                        <div class="w-50    border-top   h-auto  pt-2" style="font-size:80%">
                            <b>Film</b>: <?=$movie["name"]?>
                            <br>
                            <b>Dátum</b>: <?=$movie["start"]?>
                            <br>
                            <b>Kezdés</b>: <?=$movie["start_time"]?>
                            <br>
                            <b>Befejezés</b>: <?=$movie["end_time"]?>
                            <br>
                            <b>Jegy ára</b>: <?=$movie["price"]?> &euro;
                            <br>
                            <b>Vásárlás folyamata</b>: adja meg adatait, majd a kiválasztott székre kattintva jelölje be a lefoglalni kívát ülőhelyeket. Ha kész, nyomja meg a fizetés gombot.
                        </div>
                    </div>

                    <h4>Moziterem: válasszon ülőhelyet</h4>
                    
            </div>    
 
        

            <?= $form->field($model, 'position')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'movie_id')->hiddenInput([
                'value' => $MOVIE_ID
            ])->label(false) ?>
             <?= $form->field($model, 'row_col')->hiddenInput()->label(false) ?>
             <?= $form->field($model, 'row')->hiddenInput()->label(false) ?>
             <?= $form->field($model, 'col')->hiddenInput()->label(false) ?>

            <?= SeatsWidget::widget([ 'grid'=>['rows'=>4, 'cols'=>14 ], 'movie_id'=>$MOVIE_ID, 'disabled'=>false ]) ?>

            <?php ActiveForm::end() ?>
      
            <div class="seat-container flex-row mt-4">
                <b>Jegyek száma: </b><?='&nbsp;';?><span id="ticket-count"><?php if($cnt = $helper->getCartCount($MOVIE_ID)) print  $cnt.' drb.'; else print  'nincs kiválasztva';?></span>               
            </div>  
            <div class="seat-container flex-row">
                <b>Fizetendő összeg: </b><?='&nbsp;';?><span id="ticket-price"><?=$helper->getTotal($MOVIE_ID, $movie["price"]);?></span> &euro;
            </div> 

            <div class="seat-container flex-row mt-4">
                <?php 
                $count = $helper->getCartCount($MOVIE_ID);
                print  $helper->getCartCount($MOVIE_ID)>0 ? Html::a( (( $count > 10 ) ? 'Maximum 10 jegy! (jelenleg '.$count.' db)': 'Fizetés ('.$count.')') , Yii::$app->urlManager->createUrl(['ticket/order', 'movie_id' => $MOVIE_ID]), ['class' => 'btn btn-primary']): ''?>
            </div> 
            
    </div>
</div>
<?php 
 
$this->registerJs("
$('.reserve-btn').on('click', function (e) { 
	 $('#reserveform-position').val($(this).data('position'))
     $('#reserveform-row_col').val($(this).data('row_col'))
     $('#reserveform-row').val($(this).data('row'))
     $('#reserveform-col').val($(this).data('col'))
});
", View::POS_END);
?>