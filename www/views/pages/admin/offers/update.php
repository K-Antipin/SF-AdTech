<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var \App\Kernel\Session\SessionInterface $session
 * @var array<\App\Models\Category> $categories
 * @var \App\Models\Offer $offer
 */
?>

<?php $view->component('start'); ?>
<main>
    <div class="container">
        <h3 class="mt-3">Изменение фильма</h3>
        <hr>
    </div>
    <div class="container">
        <form action="/admin/offers/update" method="post" enctype="multipart/form-data"
            class="d-flex flex-column justify-content-center w-50 gap-2 mt-5 mb-5">
            <input type="hidden" value="<?php echo $offer->id() ?>" name="id">
            <div class="row g-2">
                <div class="col-md">
                    <div class="form-floating">
                        <input type="text" class="form-control <?php echo $session->has('name') ? 'is-invalid' : '' ?>"
                            id="name" value="<?php echo $offer->name() ?>" name="name" placeholder="Имя">
                        <label for="name">Имя</label>
                        <?php if ($session->has('name')) { ?>
                            <div id="name" class="invalid-feedback">
                                <?php echo $session->getFlash('name')[0] ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row g-2">
                <div class="col-md">
                    <div class="form-floating">
                        <textarea style="height: 100px" type="text"
                            class="form-control <?php echo $session->has('description') ? 'is-invalid' : '' ?>"
                            id="description" name="description"
                            placeholder="Крутой фильм про..."><?php echo $offer->description() ?></textarea>
                        <label for="name">Описание</label>
                        <?php if ($session->has('description')) { ?>
                            <div id="name" class="invalid-feedback">
                                <?php echo $session->getFlash('description')[0] ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row g-2">
                <div class="col-md">
                    <input type="text" class="form-control <?php echo $session->has('price') ? 'is-invalid' : '' ?>"
                        placeholder="Цена" name="price" value="<?php echo $offer->price() ?>">
                    <?php if ($session->has('price')) { ?>
                        <div id="name" class="invalid-feedback">
                            <?php echo $session->getFlash('price')[0] ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row g-2">
                <div class="col-md">
                    <div class="form-floating">
                        <input type="text" class="form-control <?php echo $session->has('url') ? 'is-invalid' : '' ?>"
                            id="url" value="<?php echo $offer->url() ?>" name="url" placeholder="Пацаны">
                        <label for="url">Целевой URL</label>
                        <?php if ($session->has('url')) { ?>
                            <div id="url" class="invalid-feedback">
                                <?php echo $session->getFlash('url')[0] ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row g-2">
                <button class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div>
</main>

<?php $view->component('end'); ?>