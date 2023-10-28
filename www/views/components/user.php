<?php
/**
 * @var \App\Kernel\Http\RequestInterface $request
 * @var \App\Controllers\UserController $user
 */
// dd($request);
?>

<div class="card offers__item">
    <div class="card-body">
        <a href="/user?id=<?php echo $user->id() ?>" class="text-decoration-none offer_hover">
            <h5 class="card-title">
                Имя: <?php echo $user->name() ?>
            </h5>
        </a>        
        <p class="card-text">
            Почта: <?php echo $user->email() ?>
        </p>
        <p class="card-text">
            Кто это: <?php echo $user->role() ?> 
        </p>
        <p class="card-text">
            Статус: <?php echo $user->status() ?>
        </p>
    </div>
</div>