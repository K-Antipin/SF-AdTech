<?php
/**
 * @var \App\Kernel\Auth\AuthInterface $auth
 */
?>

<script src="/assets/js/main.js"></script>
<header class="p-3 text-bg-dark">
    <noscript>
        <h1>Ваш браузер не поддерживает JavaScript или он откючен! Для работы приложения необходим JavaScript!</h1>
    </noscript>
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none logo">
                <h5 class="m-0">SF-AdTech</h5>
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li>
                    <a href="/" class="nav-link px-2 text-info d-flex align-items-center column-gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-house" viewBox="0 0 16 16">
                            <path
                                d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z" />
                        </svg>
                        <span>Главная</span>
                    </a>
                </li>
                <?php if ($auth->check() && $auth->user()->role() !== 'admin') { ?>
                    <li>
                        <a href="/admin" class="nav-link px-2 text-white d-flex align-items-center column-gap-2">
                            <span>Админка</span>
                        </a>
                    </li>
                    <!-- <li>
                        <a href="/statistics" class="nav-link px-2 text-white d-flex align-items-center column-gap-2">
                            <span>Статистика</span>
                        </a>
                    </li> -->
                <?php } ?>
                <?php if ($auth->check() && $auth->user()->role() === 'admin') { ?>
                    <li>
                        <a href="/users" class="nav-link px-2 text-white d-flex align-items-center column-gap-2">
                            <span>Пользователи</span>
                        </a>
                    </li>
                    <li>
                        <a href="/offers" class="nav-link px-2 text-white d-flex align-items-center column-gap-2">
                            <span>Офферы</span>
                        </a>
                    </li>
                    <li>
                        <a href="/subscribers" class="nav-link px-2 text-white d-flex align-items-center column-gap-2">
                            <span>Подписки</span>
                        </a>
                    </li>
                    <li>
                        <a href="/statistics" class="nav-link px-2 text-white d-flex align-items-center column-gap-2">
                            <span>Статистика</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>

            <div class="d-flex align-items-center text-end">
                <?php if ($auth->check()) { ?>
                    <div class="d-flex align-items-center column-gap-4">
                        <p class="m-0">
                            <?php echo $auth->user()->name() ?>
                        </p>
                        <form action="/logout" method="post">
                            <button class="btn btn-danger d-flex align-items-center column-gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z" />
                                    <path fill-rule="evenodd"
                                        d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                                </svg>
                                <span>Выйти</span>
                            </button>
                        </form>
                    </div>
                <?php } else { ?>
                    <a href="/login" type="button"
                        class="btn btn-outline-light me-2 d-flex align-items-center column-gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z" />
                            <path fill-rule="evenodd"
                                d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                        </svg>
                        <span>Войти</span>
                    </a>
                    <a href="/register" type="button" class="btn btn-warning d-flex align-items-center column-gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-person-add" viewBox="0 0 16 16">
                            <path
                                d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" />
                            <path
                                d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z" />
                        </svg>
                        <span>Создать аккаунт</span>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</header>