<?php
/**
 * @var \App\Kernel\Auth\AuthInterface $auth
 * @var \App\Kernel\View\ViewInterface $view
 * @var \App\Kernel\Session\SessionInterface $session
 * @var \App\Models\Offer $offer
 */
?>

<?php $view->component('start'); ?>

<main>
    <div class="container">
        <div>
            <div class="card mb-3 mt-3">
                <div class="card-body">
                    <h1 class="card-title">
                        <?php echo $offer->name() ?>
                    </h1>
                    <p class="card-text">Цена <span class="badge bg-warning warn__badge">
                            <?php echo $offer->price() ?>
                        </span></p>
                    <p class="card-text">Темы <span class="badge bg-warning warn__badge">
                            <?php echo $offer->description() ?>
                        </span></p>
                    <p class="card-text">Целевой URL <span class="badge bg-warning warn__badge">
                            <?php echo $offer->url() ?>
                        </span></p>
                    <p class="card-text">Подпищиков <span class="badge bg-warning warn__badge">
                            <?php echo count($offer->subscribers()) ?>
                        </span></p>
                    <p class="card-text"><small class="text-body-secondary">Добавлен
                            <?php echo $offer->createdAt() ?>
                        </small></p>
                </div>
                <?php if (!$auth->check()) { ?>
                    <div class="alert alert-warning m-3 w-80">
                        Для того, чтобы подписаться на offer, необходимо <a href="/login">авторизоваться</a>
                    </div>
                <?php } else if ($auth->user()->role() === 'webmaster') { ?>
                    <?php foreach ($offer->subscribers() as $subscriber) { ?>
                            <?php
                            if ($auth->user()->id() != $subscriber->userId())
                                continue;
                            if ($auth->user()->id() == $subscriber->userId()) { ?>
                                <div class="m-3" style="max-width: fit-content">
                                    <h5>Вы подписаны</h5>
                                </div>
                                <div class="ms-3" style="max-width: fit-content">
                                    <h5>Статистика:</h5>
                                </div>
                                <div id="statistics"></div>
                                <div class="m-3" style="max-width: fit-content">
                                    <form action="admin/statistics" method="post" name="statistics_form">
                                        <input type="date" name="date_from" required>
                                        <input class="mb-2" type="date" name="date_to" required>
                                        <input type="hidden" name="offer_id" value="<?php echo $offer->id() ?>">
                                        <button class="btn btn-primary d-flex align-items-center gap-2" id="statistics_form_button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                class="bi bi-plus-lg" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                                            </svg>
                                            <span>Показать</span>
                                        </button>
                                    </form>
                                    <div class="d-flex mt-3">
                                        <button class="btn btn-primary d-flex align-items-center gap-2  me-3" id="day">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                class="bi bi-plus-lg" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                                            </svg>
                                            <span>За сегодня</span>
                                        </button>
                                        <button class="btn btn-primary d-flex align-items-center gap-2  me-3" id="month">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                class="bi bi-plus-lg" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                                            </svg>
                                            <span>За месяц</span>
                                        </button>
                                        <button class="btn btn-primary d-flex align-items-center gap-2" id="year">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                class="bi bi-plus-lg" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                                            </svg>
                                            <span>За год</span>
                                        </button>
                                    </div>
                                </div>
                                <?php
                                goto skip;
                            } ?>

                    <?php } ?>
                        <div class="m-3" style="max-width: fit-content">
                            <form action="admin/offers/subscribe" method="post" name="subscribe_form">
                                <input type="hidden" value="<?php echo $offer->id() ?>" name="id">
                                <input type="hidden" value="<?php echo $offer->name() ?>" name="name">
                                <input type="hidden" value="<?php echo $offer->price() ?>" name="price">
                                <input type="hidden" value="<?php echo $offer->url() ?>" name="url">
                                <input type="hidden" value="<?php echo $offer->isActive() ?>" name="active">
                                <input type="hidden" value="<?php echo $offer->createdAt() ?>" name="createdAt">
                                <button class="btn btn-primary d-flex align-items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-plus-lg" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                                    </svg>
                                    <span>Подписаться</span>
                                </button>
                            </form>
                        </div>
                    <?php skip: ?>
                <?php } else { ?>
                        <div class="ms-3" style="max-width: fit-content">
                            <h5>Статистика:</h5>
                        </div>
                        <div id="statistics"></div>
                        <div class="m-3" style="max-width: fit-content">
                            <form action="admin/statistics" method="post" name="statistics_form">
                                <input type="date" name="date_from" required>
                                <input class="mb-2" type="date" name="date_to" required>
                                <input type="hidden" name="offer_id" value="<?php echo $offer->id() ?>">
                                <button class="btn btn-primary d-flex align-items-center gap-2" id="statistics_form_button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-plus-lg" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                                    </svg>
                                    <span>Показать</span>
                                </button>
                            </form>
                            <div class="d-flex mt-3">
                                <button class="btn btn-primary d-flex align-items-center gap-2  me-3" id="day">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-plus-lg" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                                    </svg>
                                    <span>За сегодня</span>
                                </button>
                                <button class="btn btn-primary d-flex align-items-center gap-2  me-3" id="month">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-plus-lg" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                                    </svg>
                                    <span>За месяц</span>
                                </button>
                                <button class="btn btn-primary d-flex align-items-center gap-2" id="year">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-plus-lg" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                                    </svg>
                                    <span>За год</span>
                                </button>
                            </div>
                        </div>
                <?php } ?>
            </div>
        </div>
    </div>
</main>

<?php $view->component('end'); ?>