<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var \App\Kernel\Session\SessionInterface $session
 */
?>

<?php $view->component('start'); ?>

<main class="form-signin w-100 m-auto">
    <form action="/login" method="post">
            <?php if ($session->has('error')) { ?>
                <div class="alert alert-danger">
                    <?php echo $session->getFlash('error') ?>
                </div>
            <?php } ?>
            <div class="d-flex" style="align-items: center; justify-content: space-between">
                <h2 class="text-white">Вход</h2>
                <a href="/" class="d-flex align-items-center mb-5 mb-lg-0 text-white text-decoration-none">
                    <h5 class="m-0">SF-AdTech</span></h5>
                </a>
            </div>
            <div class="form-floating mt-3">
                <input
                    type="email"
                    class="form-control"
                    name="email"
                    id="floatingInput"
                    placeholder="name@areaweb.su"
                >
                <label for="floatingInput">E-mail</label>
            </div>
            <div class="form-floating">
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    id="floatingPassword"
                    placeholder="Пароль"
                >
                <label for="floatingPassword">Пароль</label>
            </div>
            <input type="hidden" name="CSRF" value="<?php echo $_SESSION['CSRF'] ?>">
            <button class="btn btn-primary w-100 py-2" type="submit">Войти</button>
        </form>
    </main>

<?php $view->component('end'); ?>