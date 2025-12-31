<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\DateHelper;

/** @var yii\web\View $this */

$this->title = 'iGOV';
?>

<div class="d-flex justify-content-center align-items-center vh-90 mt-3">
    <div class="card p-3" style="max-width: 25rem; height: 90vh;">

        <!-- Scrollable posts container -->
        <div class="overflow-auto">
            <?php foreach ($posts as $post): ?>
                <div class="card mb-5 shadow-sm">

                    <!-- Post Image -->
                    <img
                        src="<?= Yii::getAlias('@web') . $post->img_path ?>"
                        class="card-img-top"
                        alt="Post image">

                    <!-- Post Content (3 lines + ellipsis) -->
                    <div class="card-body">
                        <p class="card-text text-muted post-desc">
                            <?= Html::encode($post->desc) ?>
                        </p>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted" style="font-size: 0.8rem;">
                                <?= DateHelper::relativeTimeKk($post->created_at) ?>
                            </small>
                            <small class="text-muted" style="font-size: 0.8rem;">
                                <?= Yii::$app->formatter->asDatetime($post->created_at) ?>
                            </small>

                        </div>



                    </div>

                    <hr class="mx-3 mt-0">

                    <!-- Location + Money -->
                    <?php
                    [$lat, $lng] = explode(',', $post->address_coords);
                    $modalId = 'mapModal-' . $post->id;
                    $mapId   = 'map-' . $post->id;
                    ?>

                    <div class="d-flex gap-2 mx-3">
                        <button
                            class="btn btn-outline-danger btn-sm flex-fill"
                            data-bs-toggle="modal"
                            data-bs-target="#<?= $modalId ?>">
                            📍<br>Мекен - жайы
                        </button>

                        <!-- Map Modal -->
                        <div class="modal fade" id="<?= $modalId ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Мекен - жайы</h5>
                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body p-0">
                                        <div id="<?= $mapId ?>" style="height:400px;"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <script>
                            document.getElementById('<?= $modalId ?>').addEventListener('shown.bs.modal', function() {

                                if (this.dataset.mapLoaded) return;
                                this.dataset.mapLoaded = "1";

                                const lat = <?= (float)$lat ?>;
                                const lng = <?= (float)$lng ?>;

                                const map = L.map('<?= $mapId ?>').setView([lat, lng], 15);

                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; OpenStreetMap contributors'
                                }).addTo(map);

                                L.marker([lat, lng]).addTo(map);
                            });
                        </script>

                        <button class="btn btn-outline-success btn-sm flex-fill"
                            data-bs-toggle="modal"
                            data-bs-target="#donatorsModal<?= $post->id ?>">
                            ₸<?= number_format($post->money, 0, '.', ' ') ?><br>жиналды
                        </button>
                        <!-- Donators Modal -->
                        <div class="modal fade" id="donatorsModal<?= $post->id ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mx-auto" style="width: 21rem; max-width: 100%;">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Демеушілер</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">

                                        <?php if (!empty($post->donations)): ?>
                                            <ul class="list-group list-group-flush">
                                                <?php foreach ($post->donations as $donation): ?>
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
                            href="<?= Html::encode($post->whatsapp_group) ?>"
                            target="_blank"
                            class="btn btn-outline-warning flex-fill">
                            ✋<br>Мен жасаймын!
                        </a>

                        <a
                            href="<?= \yii\helpers\Url::to(['post/donate', 'id' => $post->id]) ?>"
                            class="btn btn-outline-success flex-fill">
                            💵<br>Қолдау
                        </a>
                    </div>

                    <div class="d-flex gap-2 mb-3 mx-3">
                        <button
                            class="btn btn-outline-primary flex-fill"
                            onclick="sharePost<?= $post->id ?>()">
                            🔗 Бөлісу
                        </button>
                    </div>

                </div>

                <!-- Share function (unique per post) -->
                <script>
                    function sharePost<?= $post->id ?>() {
                        const url = "<?= Url::to(['post/view', 'id' => $post->id], true) ?>";
                        window.open(
                            `https://wa.me/?text=${encodeURIComponent(url)}`,
                            '_blank'
                        );
                    }
                </script>

            <?php endforeach; ?>

        </div>

        <!-- Floating button INSIDE the card -->
        <div class="position-absolute bottom-0 end-0 m-4">
            <a href="/post/create"
                class="btn btn-primary rounded-circle shadow"
                style="width: 60px; height: 60px; background-image: url('/add-button.png'); background-size: cover; border: none; display: inline-block;">

            </a>

        </div>

        <?php
        // Determine next sort
        $nextSort = ($sort === 'money') ? 'latest' : 'money';
        ?>

        <div class="position-absolute bottom-0 start-0 m-4">
            <a href="<?= \yii\helpers\Url::to(['site/index', 'sort' => $nextSort]) ?>"
                class="btn btn-secondary rounded-circle shadow"
                style="width: 60px; height: 60px; background-image: url('/filter.png'); background-size: cover; border: none; display: inline-block;">
            </a>
        </div>
    </div>
</div>