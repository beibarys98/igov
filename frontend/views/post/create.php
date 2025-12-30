<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Post $model */

$this->title = 'iGOV';
?>
<div class="d-flex justify-content-center align-items-center vh-90 mt-3">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>