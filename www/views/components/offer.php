<?php
/**
 * @var \App\Kernel\Http\RequestInterface $request
 * @var \App\Models\Offer $offer
 */
?>

<div class="card offers__item move draggable">
    <div class="card-body">
        <a href="/offer?id=<?php echo $offer->id() ?>" class="text-decoration-none offer_hover"
            data-offer-id="<?php echo $offer->id() ?>" data-offer-status="<?php echo (int) $offer->isActive() ?>"
            data-table="offers">
            <h5 class="card-title">
                <?php echo $offer->name() ?>
            </h5>
        </a>
        <p class="card-text">Цена <span class="badge bg-warning warn__badge">
                <?php echo $offer->price() ?>
            </span></p>
        <?php if ($offer->ban()) { ?>
            <p class="card-text"><span class="badge bg-warning warn__badge">
                    Забанен
                </span></p>
        <?php } ?>
        <p class="card-text">
            <?php echo $offer->url() ?>
        </p>
    </div>
</div>