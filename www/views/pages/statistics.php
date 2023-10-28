<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var \App\Kernel\Http\RequestInterface $request
 * @var \App\Controllers\StatisticsController $statistics
 */
?>

<?php $view->component('start'); ?>

<main>
    <div class="container text-white">
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Ра</th>
                    </tr>
                </thead>
                <?php foreach ($statistics as $data) { ?>

                <?php } ?>
            </table>
        </div>
    </div>
</main>

<?php $view->component('end'); ?>