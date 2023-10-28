<?php
/**
 * @var \App\Kernel\Auth\User $user
 */
?>

<tr>
    <td style="width: 200px;">
        <a href="/offer?id=<?php echo $offer->id() ?>"><?php echo $offer->name() ?></a>
    </td>
    <td><span class="badge bg-warning warn__badge">
            <?php echo $offer->price() ?>
        </span></td>
    <td style="width: 200px;">
        <?php echo $offer->url() ?? '' ?>
    </td>
    <td style="width: 200px;">
        <?php echo $offer->isActive() ? 'Активен' : 'Не активен' ?>
    </td>
    <td style="width: 200px;">
        <?php echo count($offer->subscribers())?>
    </td>
</tr>