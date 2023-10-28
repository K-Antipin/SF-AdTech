<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var \App\Kernel\Http\RequestInterface $request
 * @var array <\App\Controllers\StatisticsController> $statistics
 */
?>

<?php $view->component('start'); ?>

<main>
    <div class="container text-white">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4>Статистика</h4>
        </div>
        <table class="table table-dark table-hover" style="display: table !important">
            <thead>
                <tr>
                    <th scope="col">Выдано ссылок</th>
                    <th scope="col">Количество переходов</th>
                    <th scope="col">Отказы</th>
                    <th scope="col">Общий доход</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $view->component('admin/statistic', [
                    'urls' => $urls,
                    'clicks' => $clicks,
                    'rejection' => $rejection,
                    'cost' => $cost,
                ]);
                ?>
            </tbody>
        </table>
    </div>
</main>

<?php $view->component('end'); ?>