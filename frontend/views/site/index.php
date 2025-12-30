<?php

/** @var yii\web\View $this */

$this->title = 'iGOV';
?>

<div class="d-flex justify-content-center align-items-center vh-90 mt-3">
    <div class="card p-3" style="max-width: 25rem; height: 90vh;">

        <!-- Scrollable posts container -->
        <div class="overflow-auto">
            <?php for ($i = 1; $i <= 20; $i++): ?>
                <div class="card mb-5 shadow-sm">

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

                    <hr>

                    <div class="d-flex gap-2 mx-3">
                        <button class="btn btn-outline-danger btn-sm flex-fill">
                            📍 Мекен - жайы
                        </button>
                        <button class="btn btn-outline-success btn-sm flex-fill">
                            💵 ₸10,000 жиналды
                        </button>
                    </div>

                    <hr>

                    <div class="d-flex gap-2 mb-1 mx-3">
                        <button class="btn btn-outline-warning btn flex-fill">
                            ✋ Мен жасаймын!
                        </button>
                        <button class="btn btn-outline-success btn flex-fill">
                            💵 Қолдау
                        </button>

                    </div>
                    <div class="d-flex gap-2 mb-3 mx-3">
                        <button
                            class="btn btn-outline-primary flex-fill"
                            onclick="sharePost()">
                            🔗 Бөлісу
                        </button>
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

                </div>
            <?php endfor; ?>

        </div>

        <!-- Floating button INSIDE the card -->
        <div class="position-absolute bottom-0 end-0 m-4">
            <button class="btn btn-primary rounded-circle" style="width: 50px; height: 50px; background-image: url('/plus.png'); background-size: cover; border: none;">
            </button>
        </div>
    </div>
</div>