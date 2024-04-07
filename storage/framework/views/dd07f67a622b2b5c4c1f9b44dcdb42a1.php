<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <?php if(Route::has('login')): ?>
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(url('/dashboard')); ?>"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                    in</a>

                <?php if(Route::has('register')): ?>
                    <a href="<?php echo e(route('register')); ?>"
                        class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <ul>
        <li><a href="<?php echo e(url('aluno')); ?>">Aluno</a></li>
        <li><a href="<?php echo e(url('professor')); ?>">Professor</a></li>
    </ul>

</body>

</html>
<?php /**PATH C:\laragon\www\pweb2_2024_1\resources\views/inicio.blade.php ENDPATH**/ ?>