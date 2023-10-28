<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var \App\Kernel\Session\SessionInterface $session
 * @var \App\Controllers\UserController $user
 */
// dd($user);
?>

<?php $view->component('start'); ?>
<main>
    <div class="container text-white">
        <h3 class="mt-3">
            <?php echo isset($user) && $user->name() ? 'Редактирование данных' : 'Регистрация' ?>
        </h3>
        <hr>
    </div>
    <div class="container d-flex justify-content-center">
        <form action="<?php echo isset($user) && $user->name() ? 'user' : 'register' ?>" method="post"
            class="d-flex flex-column justify-content-center w-50 gap-2 mt-5 mb-5" id="register_form">
            <?php if (isset($user) && $user->id()) { ?>
                <input type="hidden" name="id" value="<?php echo $user->id() ?>">
            <?php } ?>
            <div class="row g-2">
                <div class="col-md">
                    <div class="form-floating">
                        <input type="text" class="form-control <?php echo $session->has('name') ? 'is-invalid' : '' ?>"
                            id="name" name="name" placeholder="Иван Иванов"
                            value="<?php echo isset($user) && $user->name() ? $user->name() : '' ?>">
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
                        <input type="email"
                            class="form-control <?php echo $session->has('email') ? 'is-invalid' : '' ?>" name="email"
                            id="email" placeholder="name@areaweb.su"
                            value="<?php echo isset($user) && $user->email() ? $user->email() : '' ?>">
                        <label for="email">E-mail</label>
                        <?php if ($session->has('email')) { ?>
                            <div id="email" class="invalid-feedback">
                                <?php echo $session->getFlash('email')[0] ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row g-2">
                <div class="col-md">
                    <div class="form-floating">
                        <select class="form-select <?php echo $session->has('role') ? 'is-invalid' : '' ?>" name="role"
                            style="padding-top: 0;padding-bottom: 0;">
                            <option value="advertiser" <?php echo isset($user) && $user->role() == 'advertiser' ? 'selected' : '' ?>>
                                Рекламодатель</option>
                            <option value="webmaster" <?php echo isset($user) && $user->role() == 'webmaster' ? 'selected' : '' ?>>
                                Веб-мастер</option>
                        </select>
                        <?php if ($session->has('role')) { ?>
                            <div id="role" class="invalid-feedback">
                                <?php echo $session->getFlash('role')[0] ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php if (isset($user) && $user->status()) { ?>
                <div class="row g-2">
                <div class="col-md">
                    <div class="form-floating">
                        <select class="form-select" name="status"
                            style="padding-top: 0;padding-bottom: 0;">
                            <option value="active" <?php echo isset($user) && $user->status() == 'active' ? 'selected' : '' ?>>
                                Активный</option>
                            <option value="ban" <?php echo isset($user) && $user->status() == 'ban' ? 'selected' : '' ?>>
                                Заблокирован</option>
                        </select>
                        <?php if ($session->has('role')) { ?>
                            <div id="status" class="invalid-feedback">
                                <?php echo $session->getFlash('status')[0] ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="row g-2">
                <div class="col-md">
                    <div class="form-floating">
                        <input type="password"
                            class="form-control <?php echo $session->has('password') ? 'is-invalid' : '' ?>"
                            id="password" name="password" placeholder="*********">
                        <label for="password">Пароль</label>
                        <?php if ($session->has('password')) { ?>
                            <div id="password" class="invalid-feedback">
                                <?php echo $session->getFlash('password')[0] ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" placeholder="*********">
                        <label for="password_confirmation">Подтверждение</label>
                    </div>
                </div>
            </div>
            <div class="row g-2">
                <button class="btn btn-primary">
                    <?php echo isset($user) && $user->name() ? 'Сохранить' : 'Зарегистрироваться' ?>
                </button>
            </div>
        </form>
    </div>
</main>

<?php $view->component('end'); ?>