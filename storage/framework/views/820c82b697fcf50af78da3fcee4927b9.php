<?php $__env->startSection('title', $r->ticket); ?>
<?php ($S = \App\Support\Screening::class); ?>
<?php ($tone = ['urgent' => 'high', 'high' => 'warn', 'routine' => 'neutral']); ?>
<?php $__env->startSection('content'); ?>
<div class="narrow stack">
    <a class="btn ghost" href="<?php echo e(route('office.referrals.index')); ?>" style="align-self:flex-start">← All referrals</a>
    <div class="card stack">
        <div class="row between">
            <div><p class="eyebrow"><?php echo e($r->ticket); ?> · <?php echo e($r->created_at->format('j M Y, H:i')); ?></p><h2><?php echo e($r->full_name); ?></h2></div>
            <span class="chip bg-<?php echo e($tone[$r->urgency]); ?>"><?php echo e(ucfirst($r->urgency)); ?></span>
        </div>
        <?php if($r->screening->hasSelfHarmAnswer()): ?>
            <div class="alert"><b>Self-harm item answered:</b> PHQ-9 question 9 scored <?php echo e($r->screening->phq9_item9); ?> (<?php echo e(strtolower($S::OPTIONS[$r->screening->phq9_item9])); ?>). Contact this student today.</div>
        <?php endif; ?>
        <dl class="kv">
            <dt>Student no.</dt><dd><?php echo e($r->student_number ?: 'Not given'); ?></dd>
            <dt>Contact</dt><dd><b><?php echo e($r->contact); ?></b> · <?php echo e($r->contact_method); ?></dd>
            <dt>Best time</dt><dd><?php echo e($r->preferred_time ?: 'Not given'); ?></dd>
            <dt>PHQ-9</dt><dd><?php if($r->screening->phq9_score !== null): ?><?php echo e($r->screening->phq9_score); ?> / 27 <?php echo $__env->make('partials.band', ['band' => $r->screening->phq9_band], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php else: ?> Not taken <?php endif; ?></dd>
            <dt>GAD-7</dt><dd><?php if($r->screening->gad7_score !== null): ?><?php echo e($r->screening->gad7_score); ?> / 21 <?php echo $__env->make('partials.band', ['band' => $r->screening->gad7_band], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php else: ?> Not taken <?php endif; ?></dd>
            <?php if($r->screening->difficulty !== null): ?><dt>Daily life</dt><dd><?php echo e($S::DIFFICULTY[$r->screening->difficulty]); ?></dd><?php endif; ?>
            <dt>Their note</dt><dd><?php echo e($r->note ?: 'None'); ?></dd>
            <?php if($r->user->conversation): ?>
                <dt>Messages</dt><dd><a href="<?php echo e(route('office.messages.show', $r->user->conversation)); ?>">Open conversation with <?php echo e($r->user->alias()); ?></a></dd>
            <?php endif; ?>
        </dl>
    </div>

    <details class="card">
        <summary style="cursor:pointer;font-weight:700">Answers to each question</summary>
        <div class="scroll-x" style="margin-top:12px"><table class="data">
            <tbody>
            <?php $__currentLoopData = ['phq9' => $S::PHQ9, 'gad7' => $S::GAD7]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scale => $questions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $r->screening->answers[$scale] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr><td class="small muted"><?php echo e($scale === 'phq9' ? 'PHQ-9' : 'GAD-7'); ?> Q<?php echo e($i + 1); ?></td><td><?php echo e($questions[$i]); ?></td><td><?php echo e($S::OPTIONS[$v]); ?></td></tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table></div>
    </details>

    <form method="POST" action="<?php echo e(route('office.referrals.update', $r)); ?>" class="card stack">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="field"><label for="status">Status</label>
            <select id="status" name="status">
                <?php $__currentLoopData = \App\Models\Referral::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($k); ?>" <?php if($r->status === $k): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="field"><label for="counselor_notes">Office notes (never shown to the student)</label><textarea id="counselor_notes" name="counselor_notes"><?php echo e(old('counselor_notes', $r->counselor_notes)); ?></textarea></div>
        <div class="row">
            <button class="btn primary" type="submit">Save</button>
            <?php if($r->handler): ?><span class="small muted">Last updated by <?php echo e($r->handler->name); ?> <?php echo e($r->updated_at->diffForHumans()); ?></span><?php endif; ?>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\PROJECTS\bwongo\resources\views/office/referrals/show.blade.php ENDPATH**/ ?>