<?php $__env->startSection('title', 'Referrals'); ?>
<?php ($tone = ['urgent' => 'high', 'high' => 'warn', 'routine' => 'neutral']); ?>
<?php $__env->startSection('content'); ?>
<div class="stack">
    <div class="row between">
        <h2>Referrals</h2>
        <nav class="filters" aria-label="Filter by status">
            <a href="?status=open" class="<?php echo e($filter === 'open' ? 'on' : ''); ?>">Open <?php echo e($openCount); ?></a>
            <?php $__currentLoopData = \App\Models\Referral::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="?status=<?php echo e($k); ?>" class="<?php echo e($filter === $k ? 'on' : ''); ?>"><?php echo e($label); ?> <?php echo e($counts[$k] ?? 0); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <a href="?status=all" class="<?php echo e($filter === 'all' ? 'on' : ''); ?>">All <?php echo e($allCount); ?></a>
        </nav>
    </div>
    <?php if($referrals->isEmpty()): ?>
        <div class="card empty"><?php echo e($allCount ? 'No referrals match this filter.' : 'No referrals yet. When a student asks to be contacted, their request appears here with their scores and contact details.'); ?></div>
    <?php else: ?>
        <div class="card scroll-x" style="padding:0">
            <table class="data">
                <thead><tr><th>Priority</th><th>Student</th><th>Ticket</th><th>PHQ-9</th><th>GAD-7</th><th>Sent</th><th>Status</th></tr></thead>
                <tbody>
                <?php $__currentLoopData = $referrals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><span class="chip bg-<?php echo e($tone[$r->urgency]); ?>"><?php echo e(ucfirst($r->urgency)); ?></span></td>
                        <td><a href="<?php echo e(route('office.referrals.show', $r)); ?>"><b><?php echo e($r->full_name); ?></b></a><br><span class="small muted"><?php echo e($r->student_number); ?></span></td>
                        <td><code><?php echo e($r->ticket); ?></code></td>
                        <td><?php echo e($r->screening->phq9_score ?? '·'); ?></td>
                        <td><?php echo e($r->screening->gad7_score ?? '·'); ?></td>
                        <td><?php echo e($r->created_at->diffForHumans()); ?></td>
                        <td><?php echo e($r->statusLabel()); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php if($referrals->hasPages()): ?>
            <div class="pagination">
                <?php if($referrals->previousPageUrl()): ?><a class="btn" href="<?php echo e($referrals->previousPageUrl()); ?>">Newer</a><?php endif; ?>
                <?php if($referrals->nextPageUrl()): ?><a class="btn" href="<?php echo e($referrals->nextPageUrl()); ?>">Older</a><?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\PROJECTS\bwongo\resources\views/office/referrals/index.blade.php ENDPATH**/ ?>