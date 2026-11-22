<?php $__env->startSection('title', 'Your results'); ?>
<?php ($S = \App\Support\Screening::class); ?>
<?php $__env->startSection('content'); ?>
<div class="narrow stack">
    <div>
        <p class="eyebrow">Your results · <?php echo e($s->created_at->format('j M Y, H:i')); ?></p>
        <h2><?php echo e($s->referral_suggested ? 'It looks like things have been hard lately' : 'Thanks for checking in'); ?></h2>
    </div>

    <?php if($s->hasSelfHarmAnswer()): ?>
        <?php echo $__env->make('partials.crisis', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    <div class="scores">
        <?php if($s->phq9_score !== null): ?>
            <div class="card score">
                <div class="row between"><span class="eyebrow">Mood · PHQ-9</span><?php echo $__env->make('partials.band', ['band' => $s->phq9_band], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>
                <div class="num"><?php echo e($s->phq9_score); ?><small> / 27</small></div>
                <?php echo $__env->make('partials.scale', ['score' => $s->phq9_score, 'max' => 27, 'segments' => [[0,4,'ok'],[5,9,'mild'],[10,14,'warn'],[15,19,'high'],[20,27,'high']]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <p class="small muted"><?php echo e($S::interpretation('phq9', $s->phq9_band)); ?></p>
            </div>
        <?php endif; ?>
        <?php if($s->gad7_score !== null): ?>
            <div class="card score">
                <div class="row between"><span class="eyebrow">Anxiety · GAD-7</span><?php echo $__env->make('partials.band', ['band' => $s->gad7_band], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>
                <div class="num"><?php echo e($s->gad7_score); ?><small> / 21</small></div>
                <?php echo $__env->make('partials.scale', ['score' => $s->gad7_score, 'max' => 21, 'segments' => [[0,4,'ok'],[5,9,'mild'],[10,14,'warn'],[15,21,'high']]], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <p class="small muted"><?php echo e($S::interpretation('gad7', $s->gad7_band)); ?></p>
            </div>
        <?php endif; ?>
    </div>
    <?php if($s->difficulty !== null): ?>
        <p class="small muted">You said these problems made daily life <b><?php echo e(strtolower($S::DIFFICULTY[$s->difficulty])); ?></b>.</p>
    <?php endif; ?>

    <?php if($s->referral): ?>
        <section class="ticket">
            <span class="eyebrow">Referral sent</span>
            <code><?php echo e($s->referral->ticket); ?></code>
            <p>The <?php echo e($settings['office_name']); ?> has your request and will contact you by <?php echo e(strtolower($s->referral->contact_method)); ?>. Status: <span class="chip bg-neutral"><?php echo e($s->referral->statusLabel()); ?></span></p>
            <?php echo $__env->make('student.partials.office', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </section>
    <?php elseif($s->referral_suggested): ?>
        <section class="card stack">
            <h3>Ask the counseling office to reach out</h3>
            <p class="muted">Your results are at a level where talking to a counselor can really help. Share how they can reach you and they will contact you. Nothing is sent until you press the button.</p>
            <?php echo $__env->make('student.partials.referral-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </section>
    <?php else: ?>
        <section class="stack">
            <h3>Things that may help</h3>
            <div class="res">
                <?php $__currentLoopData = $resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card stack"><b><?php echo e($res->title); ?></b><p class="small muted"><?php echo e($res->body); ?></p></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>
        <details class="card" <?php if($errors->any()): ?> open <?php endif; ?>>
            <summary style="cursor:pointer;font-weight:700">I'd still like to talk to a counselor</summary>
            <div class="stack" style="margin-top:14px"><?php echo $__env->make('student.partials.referral-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>
        </details>
    <?php endif; ?>

    <div class="card row between">
        <div style="flex:1 1 260px;min-width:0"><b>Prefer to stay anonymous?</b><p class="small muted">Send a private message to the counseling office without giving your name.</p></div>
        <a class="btn" href="<?php echo e(route('student.messages')); ?>">Message anonymously</a>
    </div>
    <?php echo $__env->make('partials.disclaimer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="row"><a class="btn ghost" href="<?php echo e(route('student.home')); ?>">Start a new check-in</a></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\PROJECTS\bwongo\resources\views/student/result.blade.php ENDPATH**/ ?>