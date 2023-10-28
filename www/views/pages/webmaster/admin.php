<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var \App\Kernel\Http\RequestInterface $request
 * @var array<\App\Models\Subscribe> $subscribers
 * @var array<\App\Models\Offer> $offers
 */

//  dd($subscribers);
?>

<?php $view->component('start'); ?>

<main>
    <div class="container text-white">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4>Subscribers</h4>
        </div>
        <div class="table">
            <div class="table_column">
                <span>Активные</span>
                <div class="items droppable" id="activ_offers">
                    <?php
                    foreach ($subscribers as $subscribe) {
                        if (!$subscribe->isActive())
                            continue;
                        $view->component('subscribe', [
                            'subscribe' => $subscribe,
                            'request' => $request
                        ]);
                    }
                    ?>
                </div>
            </div>
            <div class="table_column">
                <span>Архивные</span>
                <div class="items droppable">
                    <?php
                    foreach ($subscribers as $subscribe) {
                        if ($subscribe->isActive())
                            continue;
                        $view->component('subscribe', [
                            'subscribe' => $subscribe,
                            'request' => $request
                        ]);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        DragManager.onDragCancel = function (dragObject) {
            dragObject.avatar.rollback();
        };
    </script>
    <!-- Pop Up Form Start -->
    <div class="add_offer" id="add_offer">
        <div class="add_offer_close cl-btn-2" id="add_offer_close">
            <div>
                <div class="leftright"></div>
                <div class="rightleft"></div>
                <span class="close-btn">закрыть</span>
            </div>
        </div>
        <div class="container text-white">
            <h3 class="mt-3">Добавление оффера</h3>
            <hr>
        </div>
        <div class="container">
            <form action="/admin/offers/add" method="post"
                class="d-flex flex-column justify-content-center w-50 gap-2 mt-5 mb-5" name="add_offer">
                <div class="row g-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text"
                                class="form-control <?php echo $session->has('name') ? 'is-invalid' : '' ?>" id="name"
                                name="name" placeholder="Имя">
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
                            <input type="text"
                                class="form-control <?php echo $session->has('price') ? 'is-invalid' : '' ?>" id="price"
                                name="price" placeholder="Цена">
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
                            <input type="text"
                                class="form-control <?php echo $session->has('url') ? 'is-invalid' : '' ?>" id="url"
                                name="url" placeholder="Целевой URL">
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
    </div>
    <!-- Pop Up Form End -->
</main>
<?php $view->component('end'); ?>