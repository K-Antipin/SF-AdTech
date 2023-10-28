<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var \App\Kernel\Http\RequestInterface $request
 * @var array<\App\Models\Offer> $offers
 */
?>

<?php $view->component('start'); ?>

<main>
    <div class="container text-white">
        <div class="items">
            <?php foreach ($offers as $offer) { ?>
                <?php
                if (!$offer->isActive())
                    continue;
                $view->component('offer', [
                    'offer' => $offer,
                    'request' => $request,
                ]);
                ?>
            <?php } ?>
        </div>
    </div>
</main>

<?php $view->component('end'); ?>