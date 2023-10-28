<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var \App\Kernel\Http\RequestInterface $request
 * @var array<\App\Controllers\UserController> $users
 */
?>

<?php $view->component('start'); ?>

<main>
    <div class="container text-white">
        <div class="items">
            <?php
            foreach ($users as $user) {
                if ($user->role() === 'admin') continue;
                $view->component('user', [
                    'user' => $user
                ]);
            }
            ?>
        </div>
    </div>
</main>

<?php $view->component('end'); ?>