<?php $__env->startSection('title', 'My results'); ?>
<?php $__env->startSection('content'); ?>
<div class="narrow stack">
    <div><p class="eyebrow">Only you can see this page</p><h2>My results</h2></div>
    <section class="card stack">
        <h3>Referral requests</h3>
        <?php if($referrals->isEmpty()): ?>
            <p class="muted">You haven't requested a referral.</p>
        <?php else: ?>
            <div class="scroll-x"><table class="data">
                <thead><tr><th>Ticket</th><th>Sent</th><th>Status</th></tr></thead>
                <tbody>
                <?php $__currentLoopData = $referrals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr><td><code><?php echo e($r->ticket); ?></code></td><td><?php echo e($r->created_at->format('j M Y')); ?></td><td><span class="chip bg-neutral"><?php echo e($r->statusLabel()); ?></span></td></tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table></div>
        <?php endif; ?>
    </section>
    <section class="card stack">
        <h3>Past check-ins</h3>
        <?php if($screenings->isEmpty()): ?>
            <p class="muted">Your check-ins will appear here so you can see how you're doing over time.</p>
        <?php else: ?>
            <div class="scroll-x"><table class="data">
                <thead><tr><th>Date</th><th>Mood (PHQ-9)</th><th>Anxiety (GAD-7)</th><th></th></tr></thead>
                <tbody>
                <?php $__currentLoopData = $screenings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($s->created_at->format('j M Y, H:i')); ?></td>
                        <td><?php if($s->phq9_score !== null): ?><?php echo e($s->phq9_score); ?> <?php echo $__env->make('partials.band', ['band' => $s->phq9_band], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php else: ?> · <?php endif; ?></td>
                        <td><?php if($s->gad7_score !== null): ?><?php echo e($s->gad7_score); ?> <?php echo $__env->make('partials.band', ['band' => $s->gad7_band], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php else: ?> · <?php endif; ?></td>
                        <td><a href="<?php echo e(route('student.screenings.show', $s)); ?>">View</a></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table></div>
        <?php endif; ?>
    </section>
    <a class="btn primary" href="<?php echo e(route('student.home')); ?>" style="align-self:flex-start">Take a check-in</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\PROJECTS\bwongo\resources\views/student/history.blade.php ENDPATH**/ ?>