<?php
/**
 * @var \App\Models\Offer $offer
 */
?>

<tr>
    <td style="width: 200px;">
        <?php echo $offer->name() ?>
    </td>
    <td><span class="badge bg-warning warn__badge">
            <?php echo $offer->price() ?>
        </span></td>
    <td style="width: 200px;">
        <?php echo $offer->url() ?? '' ?>
    </td>
    <td>
        <div class="d-flex justify-content-end">
            <a class="btn btn-secondary" href="/admin/offers/unzip?id=<?php echo $offer->id() ?>"
                role="button">Разархивировать</a>
        </div>
    </td>
</tr>