<?php $__env->startSection('title', 'Overview'); ?>
<?php ($phqBands = ['Minimal' => 'ok', 'Mild' => 'mild', 'Moderate' => 'warn', 'Moderately severe' => 'high', 'Severe' => 'high']); ?>
<?php ($gadBands = ['Minimal' => 'ok', 'Mild' => 'mild', 'Moderate' => 'warn', 'Severe' => 'high']); ?>
<?php $__env->startSection('content'); ?>
<div class="stack">
    <div><h2>Overview</h2><p class="small muted">Check-in figures are totals only. Names appear only on referrals, where the student gave consent.</p></div>
    <div class="tiles">
        <div class="tile"><b><?php echo e($total); ?></b><span>Check-ins in total</span></div>
        <div class="tile"><b><?php echo e($lastWeek); ?></b><span>In the last 7 days</span></div>
        <div class="tile"><b><?php echo e($referralRate); ?></b><span>Reached the referral level</span></div>
        <div class="tile"><b><?php echo e($newReferrals); ?></b><span>New referrals waiting</span></div>
        <div class="tile"><b class="<?php echo e($selfHarm ? 't-high' : ''); ?>"><?php echo e($selfHarm); ?></b><span>Reported self-harm thoughts</span></div>
    </div>
    <div class="scores">
        <?php $__currentLoopData = [['Mood · PHQ-9', $phq9, $phqBands], ['Anxiety · GAD-7', $gad7, $gadBands]]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$title, $counts, $bands]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php ($n = max(1, $counts->sum())); ?>
            <div class="card stack">
                <h3><?php echo e($title); ?></h3>
                <div class="bars">
                    <?php $__currentLoopData = $bands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $band => $tone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="hbar"><span><?php echo e($band); ?></span><span class="track"><i class="fill-<?php echo e($tone); ?>" style="width: <?php echo e(round(($counts[$band] ?? 0) / $n * 100, 1)); ?>%"></i></span><span class="n"><?php echo e($counts[$band] ?? 0); ?></span></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php if(! $total): ?><p class="muted">Charts fill in as students complete check-ins.</p><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\PROJECTS\bwongo\resources\views/office/overview.blade.php ENDPATH**/ ?>