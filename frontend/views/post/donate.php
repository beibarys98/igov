<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/** @var common\models\Post $post */
/** @var common\models\Donation $donation */

$this->title = 'iGOV';
?>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-3" style="width: 25rem;">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($donation, 'whatsapp_number')->textInput([
            'placeholder' => 'WhatsApp нөміріңіз',
        ])->label(false) ?>

        <?= $form->field($donation, 'amount')->input('number', [
            'placeholder' => 'Қанша ақша бере аласыз? (Ең азы 100 тг!)',
            'min' => 1
        ])->label(false) ?>

        <?= $form->field($donation, 'post_id')->hiddenInput(['value' => $post->id])->label(false) ?>

        <div class="form-group mt-3">
            <?= Html::submitButton('Жіберу', ['class' => 'btn btn-success w-100']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>