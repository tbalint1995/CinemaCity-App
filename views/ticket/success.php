<?php 
    use yii\helpers\Html;
?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success">Köszönjük, hogy nálunk
                vásárolt</div>
            </div>

            <div class="col-12">
                <?=Html::a('Vissza a főoldalra', ['site/index'], ['class' => 'btn btn-primary']);?>
            </div>
        </div>
    </div>

</div>