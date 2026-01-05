<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Post $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="p-3" style="max-width: 25rem;">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <!-- Hidden File Input -->
    <?= $form->field($model, 'file')->fileInput([
        'id' => 'file-input',
        'style' => 'display:none;',
    ])->label(false) ?>

    <!-- Image Button / Preview -->
    <div class="text-center">
        <label for="file-input" style="cursor:pointer;">
            <img id="file-preview" src="/camera.png" class="p-3" alt="Upload Image"
                style="max-width:50%; object-fit:cover; border:1px solid #ccc; border-radius:10px;">
            <br>
            <span id="file-text" class="text-muted">Сурет жүктеңіз!</span>
            <br><br>
        </label>
    </div>

    <script>
        document.getElementById('file-input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('file-preview');
                    img.src = e.target.result; // Replace camera image with uploaded file
                    document.getElementById('file-text').innerText = ''; // Remove "Upload Image" text
                }
                reader.readAsDataURL(file);
            }
        });
    </script>


    <?= $form->field($model, 'desc')->textarea(['rows' => 3, 'placeholder' => 'Не шаруа жасалу керек? Соны қысқаша айтып кетсеңіз!'])->label(false) ?>

    <?= $form->field($model, 'whatsapp_group')->textarea(['rows' => 3, 'placeholder' => 'WhatsApp группасын жаратыңыз және сол группаның шақыру сілтемесін осында салыңыз!'])->label(false) ?>

    <?= $form->field($model, 'money')->input('number', [
        'placeholder' => 'Қанша ақша бере аласыз?',
        'min' => 100,
        'step' => 100,
        'class' => 'form-control'

    ])->label(false) ?>


    <!-- Hidden coordinates input -->
    <?= $form->field($model, 'address_coords')->hiddenInput()->label(false) ?>

    <div class="form-group text-center">
        <?= Html::submitButton('Сақтау', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('post-address_coords').value =
                position.coords.latitude + ', ' + position.coords.longitude;
        }, function(error) {
            console.log('Error getting location: ' + error.message);
        });
    } else {
        console.log('Geolocation not supported.');
    }
</script>