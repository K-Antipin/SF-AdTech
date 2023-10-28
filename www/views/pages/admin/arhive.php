<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var array<\App\Models\Subscribe> $subscribers
 * @var array<\App\Models\Offer> $offers
 */
?>

<?php $view->component('start'); ?>

<main>
    <div class="container text-white">
        <h3 class="mt-3">Панель администрирования</h3>
        <hr>
        <!-- <div class="d-flex align-items-center justify-content-between mb-4">
            <h4>Offers</h4>
            <a href="/admin/offers/add" class="btn btn-primary d-flex align-items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                </svg>
                <span>Добавить</span>
            </a>
        </div> -->
        <table class="table table-dark table-hover">
            <thead>
                <tr>
                    <th scope="col">Название</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Целевой URL</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($offers as $offer) {
                    if ($offer->isActive()) continue;
                    $view->component('admin/offer', ['offer' => $offer]);
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<?php $view->component('end'); ?>