<?php $__env->startSection('title', 'Create account'); ?>
<?php $__env->startSection('content'); ?>
<div class="auth stack">
    <h2>Create your student account</h2>
    <p class="muted">Your check-in answers stay private to your account. The counseling office only sees your name if you choose to request a referral.</p>
    <form method="POST" action="<?php echo e(route('register')); ?>" class="card stack">
        <?php echo csrf_field(); ?>
        <div class="field"><label for="name">Full name</label><input id="name" name="name" value="<?php echo e(old('name')); ?>" required autocomplete="name"></div>
        <div class="field"><label for="email">Email</label><input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required autocomplete="email"></div>
        <div class="field"><label for="student_number">Student number (optional)</label><input id="student_number" name="student_number" value="<?php echo e(old('student_number')); ?>" inputmode="numeric"></div>
        <div class="field"><label for="password">Password</label><input id="password" name="password" type="password" required autocomplete="new-password"></div>
        <div class="field"><label for="password_confirmation">Confirm password</label><input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"></div>
        <?php if($errors->any()): ?><div class="err" role="alert"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p><?php echo e($e); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div><?php endif; ?>
        <button class="btn primary" type="submit">Create account</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\PROJECTS\bwongo\resources\views/auth/register.blade.php ENDPATH**/ ?>