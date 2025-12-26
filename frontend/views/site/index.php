<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'iGOV';
?>

<div class="d-flex justify-content-center align-items-center vh-90 mt-3">
    <div class="card p-3" style="max-width: 90vw; height: 90vh;">

        <!-- Scrollable posts container -->
        <div class="overflow-auto">
            <?php for ($i = 1; $i <= 20; $i++): ?>
                <div class="card mb-4 shadow-sm">

                    <!-- Post Image -->
                    <img
                        src="https://picsum.photos/800/400?random=<?= $i ?>"
                        class="card-img-top"
                        alt="Post image <?= $i ?>">

                    <!-- Post Content -->
                    <div class="card-body">
                        <p class="card-text text-muted">
                            This is a sample post description. It looks clean, readable,
                            and well-spaced for better UX.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-primary btn-sm">
                                👍 Like
                            </button>
                            <button class="btn btn-outline-secondary btn-sm">
                                💬 Comment
                            </button>
                            <button class="btn btn-outline-success btn-sm">
                                🔗 Share
                            </button>
                        </div>
                    </div>

                </div>
            <?php endfor; ?>

        </div>

        <!-- Floating button INSIDE the card -->
        <div class="position-absolute bottom-0 end-0 m-5">
            <button class="btn btn-primary rounded-circle" style="width: 50px; height: 50px; background-image: url('/plus.png'); background-size: cover; border: none;">
            </button>
        </div>
    </div>
</div>