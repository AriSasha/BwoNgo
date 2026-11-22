<?php $__env->startSection('title', 'Sign in'); ?>
<?php $__env->startSection('content'); ?>
<div class="auth stack">
    <div class="row"><?php echo $__env->make('partials.logo', ['class' => 'logo-big'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>
    <h2>Sign in to BwoNgo</h2>
    <form method="POST" action="<?php echo e(route('login')); ?>" class="card stack">
        <?php echo csrf_field(); ?>
        <div class="field"><label for="email">Email</label><input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="email"></div>
        <div class="field"><label for="password">Password</label><input id="password" name="password" type="password" required autocomplete="current-password"></div>
        <label class="check"><input type="checkbox" name="remember" value="1"><span>Keep me signed in</span></label>
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="err" role="alert"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <button class="btn primary" type="submit">Sign in</button>
    </form>
    <p class="small muted">New here? <a href="<?php echo e(route('register')); ?>">Create a student account</a>. Counselors get their account from the BwoNgo admin.</p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\PROJECTS\bwongo\resources\views/auth/login.blade.php ENDPATH**/ ?>