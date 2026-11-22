<?php $__env->startSection('title', 'Welcome'); ?>
<?php $__env->startSection('content'); ?>
<div class="stack">
    <section class="hero">
        <div class="stack">
            <p class="eyebrow">Makerere University Business School</p>
            <h1>A private check-in on how you've been feeling</h1>
            <p class="lead">BwoNgo helps MUBS students check their mood and anxiety in a few minutes, see what their answers suggest, and reach the counseling office when they want support.</p>
            <div class="row">
                <a class="btn primary" href="<?php echo e(route('register')); ?>">Create a student account</a>
                <a class="btn" href="<?php echo e(route('login')); ?>">Sign in</a>
            </div>
        </div>
        <?php echo $__env->make('partials.logo', ['class' => 'logo-big'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </section>
    <div class="features">
        <div class="card stack"><h3>Check in</h3><p class="muted">The PHQ-9 and GAD-7 questionnaires, scored straight away.</p></div>
        <div class="card stack"><h3>Get support</h3><p class="muted">Ask the counseling office to contact you. Your details are shared only with your consent.</p></div>
        <div class="card stack"><h3>Talk anonymously</h3><p class="muted">Message a counselor without giving your name.</p></div>
    </div>
    <?php echo $__env->make('partials.disclaimer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
     <p class="small muted">If you are in danger right now, <b>call Dr.Sharif Muyingo - Head of Psychotherapy services MUBS Healthcentre on 0752988221.</b></p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\PROJECTS\bwongo\resources\views/welcome.blade.php ENDPATH**/ ?>