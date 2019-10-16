<?php $__env->startSection('body'); ?>
    <main>
        <div class="login">
            <p class="login__title">Log in to your account</p>

            <form action="" method="POST">
                <?php echo e(csrf_field()); ?>

                <div class="login__item">
                    <div class="login__icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5 5a5 5 0 0 1 10 0v2A5 5 0 0 1 5 7V5zM0 16.68A19.9 19.9 0 0 1 10 14c3.64 0 7.06.97 10 2.68V20H0v-3.32z"></path></svg>
                    </div>
                    <input class="login__input" type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="Email address">
                </div>
                <div class="login__item">
                    <div class="login__icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="zondicon text-dark-muted text-xs"><path d="M4 8V6a6 6 0 1 1 12 0v2h1a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h1zm5 6.73V17h2v-2.27a2 2 0 1 0-2 0zM7 6v2h6V6a3 3 0 0 0-6 0z"></path></svg>
                    </div>
                    <input class="login__input" type="password" name="password" value=""  placeholder="Password">
                </div>

                <input class="login__submit" type="submit" value="Log in">
            </form>

            <?php if($errors->any()): ?>
            <p class="login__warning">
                These credentials do not match our records.
            </p>
            <?php endif; ?>
        </div>
    </main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\ticket_booking\resources\views/auth/login.blade.php ENDPATH**/ ?>