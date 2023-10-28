<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var array<\App\Models\Category> $categories
 * @var array<\App\Models\Offer> $offers
 */
// dd(get_defined_vars());
?>

<?php $view->component('start'); ?>

<main>
    <div class="container text-white">
        <h3 class="mt-3">Панель администрирования</h3>
        <hr>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4>Offers</h4>
        </div>
        <table class="table table-dark table-hover" style="display: table !important">
            <thead>
                <tr>
                    <th scope="col">Название</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Целевой URL</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Подписки</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($offers as $offer) {
                    $view->component('admin/offer', ['offer' => $offer]);
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<?php $view->component('end'); ?>