<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var \App\Kernel\Session\SessionInterface $session
 * @var array<\App\Models\Category> $categories
 */
?>

<?php $view->component('start'); ?>
<main>
    <div class="container text-white">
        <h3 class="mt-3">Добавление оффера</h3>
        <hr>
    </div>
    <div class="container">
        <form action="/admin/offers/add" method="post"
            class="d-flex flex-column justify-content-center w-50 gap-2 mt-5 mb-5">
            <div class="row g-2">
                <div class="col-md">
                    <div class="form-floating">
                        <input type="text" class="form-control <?php echo $session->has('name') ? 'is-invalid' : '' ?>"
                            id="name" name="name" placeholder="Имя">
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
                            id="description" name="description" placeholder="Темы сайта"></textarea>
                        <label for="name">Темы сайта</label>
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
                    <div class="form-floating">
                        <input type="text" class="form-control <?php echo $session->has('price') ? 'is-invalid' : '' ?>"
                            id="price" name="price" placeholder="Цена">
                        <label for="price">Цена</label>
                        <?php if ($session->has('price')) { ?>
                            <div id="price" class="invalid-feedback">
                                <?php echo $session->getFlash('price')[0] ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row g-2">
                <div class="col-md">
                    <div class="form-floating">
                        <input type="text" class="form-control <?php echo $session->has('url') ? 'is-invalid' : '' ?>"
                            id="url" name="url" placeholder="Целевой URL">
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
                <button class="btn btn-primary">Добавить</button>
            </div>
        </form>
    </div>
</main>

<?php $view->component('end'); ?>