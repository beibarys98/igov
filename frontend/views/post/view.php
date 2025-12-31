<?php

use yii\helpers\Html;
use common\helpers\DateHelper;

/** @var yii\web\View $this */
/** @var common\models\Post $model */

$this->title = 'iGOV';
?>
<div class="d-flex justify-content-center align-items-center vh-90 mt-3">

    <div class="card p-3" style="width: 25rem;">

        <!-- Post Image -->
        <img
            src="<?= Html::encode($model->img_path) ?>"
            class="card-img-top"
            alt="Post image">

        <!-- Post Content -->
        <div class="card-body">
            <p class="card-text text-muted">
                <?= Html::encode($model->desc) ?>
            </p>
            <div class="d-flex justify-content-between">
                <small class="text-muted" style="font-size: 0.8rem;">
                    <?= DateHelper::relativeTimeKk($model->created_at) ?>
                </small>
                <small class="text-muted" style="font-size: 0.8rem;">
                    <?= Yii::$app->formatter->asDatetime($model->created_at) ?>
                </small>

            </div>
        </div>

        <hr class="mx-3 mt-0">

        <!-- Location & Money -->
        <div class="d-flex gap-2 mx-3">
            <button
                class="btn btn-outline-danger btn-sm flex-fill"
                data-bs-toggle="modal"
                data-bs-target="#mapModal">
                📍<br>Мекен - жайы
            </button>



            <button class="btn btn-outline-success btn-sm flex-fill"
                data-bs-toggle="modal"
                data-bs-target="#donatorsModal<?= $model->id ?>">
                ₸<?= number_format($model->money, 0, '.', ' ') ?><br>жиналды
            </button>
            <!-- Donators Modal -->
            <div class="modal fade" id="donatorsModal<?= $model->id ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mx-auto" style="width: 21rem; max-width: 100%;">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Демеушілер</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">

                            <?php if (!empty($model->donations)): ?>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($model->donations as $donation): ?>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span><?= Html::encode($donation->whatsapp_number) ?></span>
                                            <strong>₸<?= number_format($donation->amount, 0, '.', ' ') ?></strong>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <div class="text-muted text-center">Әзірше демеуші жоқ!</div>
                            <?php endif; ?>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <hr class="mx-3">

        <!-- Action buttons -->
        <div class="d-flex gap-2 mb-1 mx-3">
            <a
                href="<?= Html::encode($model->whatsapp_group) ?>"
                target="_blank"
                class="btn btn-outline-warning flex-fill">
                ✋<br>Мен жасаймын!
            </a>

            <a
                href="<?= \yii\helpers\Url::to(['post/donate', 'id' => $model->id]) ?>"
                class="btn btn-outline-success flex-fill">
                💵<br>Қолдау
            </a>


        </div>

        <div class="d-flex gap-2 mb-3 mx-3">
            <button
                class="btn btn-outline-primary flex-fill"
                onclick="sharePost()">
                🔗 Бөлісу
            </button>
        </div>

    </div>
</div>

<script>
    function sharePost() {
        const url = window.location.href;

        window.open(
            `https://wa.me/?text=${encodeURIComponent(url)}`,
            '_blank'
        );
    }
</script>

<?php
[$lat, $lng] = explode(',', $model->address_coords);
?>

<div class="modal fade" id="mapModal" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Мекен - жайы</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-0">
                <div id="map" style="width:100%; height:400px;"></div>
            </div>

        </div>
    </div>
</div>

<script>
    let map;

    document.getElementById('mapModal').addEventListener('shown.bs.modal', function() {

        if (map) return;

        const lat = <?= (float)$lat ?>;
        const lng = <?= (float)$lng ?>;

        map = L.map('map').setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map);
    });
</script>