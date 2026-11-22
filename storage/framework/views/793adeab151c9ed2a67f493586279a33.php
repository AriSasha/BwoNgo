<?php $__env->startSection('title', \App\Support\Screening::KINDS[$kind]); ?>
<?php ($S = \App\Support\Screening::class); ?>
<?php $__env->startSection('content'); ?>
<form method="POST" action="<?php echo e(route('student.screenings.store')); ?>" id="checkin" class="narrow stack">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="kind" value="<?php echo e($kind); ?>">
    <div>
        <p class="eyebrow"><?php echo e($S::KINDS[$kind]); ?></p>
        <h2><?php echo e($S::STEM); ?></h2>
    </div>
    <div class="progress"><div class="bar"><i></i></div><p class="small muted" id="progress-label"></p></div>
    <?php if($errors->any()): ?><div class="alert" role="alert">Please answer every question before seeing your results.</div><?php endif; ?>

    <?php if($S::includesPhq9($kind)): ?>
        <div class="section-head"><h3>Mood</h3><span class="small muted">PHQ-9</span></div>
        <?php $__currentLoopData = $S::PHQ9; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('student.partials.question', ['name' => "phq9[$i]", 'n' => $i + 1, 'text' => $q, 'labels' => $S::OPTIONS, 'old' => old("phq9.$i")], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php if($i === 8): ?>
                <?php echo $__env->make('partials.crisis', ['id' => 'crisis-inline', 'hidden' => old('phq9.8', '0') === '0', 'heading' => "Thank you for telling us. You don't have to carry this alone."], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('student.partials.question', ['name' => 'difficulty', 'n' => 10, 'text' => $S::DIFFICULTY_QUESTION, 'labels' => $S::DIFFICULTY, 'old' => old('difficulty'), 'unscored' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    <?php if($S::includesGad7($kind)): ?>
        <div class="section-head"><h3>Anxiety</h3><span class="small muted">GAD-7</span></div>
        <?php $__currentLoopData = $S::GAD7; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('student.partials.question', ['name' => "gad7[$i]", 'n' => $i + 1, 'text' => $q, 'labels' => $S::OPTIONS, 'old' => old("gad7.$i")], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <?php echo $__env->make('partials.disclaimer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="row"><button class="btn primary" type="submit">See my results</button><a class="btn ghost" href="<?php echo e(route('student.home')); ?>">Cancel</a></div>
</form>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?><script src="<?php echo e(asset('js/checkin.js')); ?>"></script><?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\PROJECTS\bwongo\resources\views/student/screening.blade.php ENDPATH**/ ?>