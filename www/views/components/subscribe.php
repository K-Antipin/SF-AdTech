<?php
/**
 * @var \App\Models\Subscribe $subscribe
 * @var \App\Kernel\Http\RequestInterface $request
 */
?>

<div class="card offers__item move draggable">
    <div class="card-body">
        <a href="/offer?id=<?php echo $subscribe->offer()->id() ?>" class="text-decoration-none"
            data-offer-id="<?php echo $subscribe->id() ?>" data-offer-status="<?php echo $subscribe->isActive() ?>"
            data-table="subscribe">
            <h5 class="card-title">
                <?php echo $subscribe->name() ?>
            </h5>
        </a>
        <p class="card-text">Цена <span class="badge bg-warning warn__badge">
                <?php echo $subscribe->offer()->price() ?>
            </span>
        </p>
        <?php if ($subscribe->ban()) { ?>
            <p class="card-text"><span class="badge bg-warning warn__badge">
                    Забанен
                </span>
            </p>
        <?php } ?>
        <?php if (!$subscribe->offer()->isActive()) { ?>
            <p class="card-text"><span class="badge bg-warning warn__badge">
                    Не активен
                </span>
            </p>
        <?php } ?>
        <p class="card-text">URL <span class="badge bg-warning warn__badge url_hash">
                <?php echo 'http://' . $request->domain() . '/redirector?hash=' . $subscribe->hash() ?>
            </span>
        </p>
    </div>
</div>