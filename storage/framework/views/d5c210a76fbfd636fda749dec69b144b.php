<?php $__env->startSection('title', 'Talk to a counselor'); ?>
<?php $__env->startSection('content'); ?>
<div class="narrow stack">
    <div><p class="eyebrow">Anonymous messages</p><h2>Talk to the <?php echo e($settings['office_name']); ?></h2></div>
    <p class="muted">The office sees you as <b><?php echo e($alias); ?></b>. Your name is not shared unless you write it. Counselors reply during office hours<?php echo e($settings['office_hours'] ? ' ('.$settings['office_hours'].')' : ''); ?>, so this is not for emergencies.</p>
    <div class="chat" id="chat">
        <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bubble <?php echo e($m->sender === 'student' ? 'me' : 'them'); ?>"><?php echo e($m->body); ?><small><?php echo e($m->sender === 'student' ? 'You' : 'Counselor'); ?> · <?php echo e($m->created_at->format('j M, H:i')); ?></small></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty">No messages yet. Say what's on your mind, ask a question, or ask how to book a session.</div>
        <?php endif; ?>
    </div>
    <form method="POST" action="<?php echo e(route('student.messages.store')); ?>" class="composer">
        <?php echo csrf_field(); ?>
        <textarea name="body" aria-label="Message" placeholder="Write a message…" required></textarea>
        <button class="btn primary" type="submit">Send</button>
    </form>
    <?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="err"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <p class="small muted">In danger right now? Call 999 or 112, or Butabika Hospital toll-free on 0800 211 306.</p>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?><script>const c=document.getElementById('chat');c.scrollTop=c.scrollHeight;</script><?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\PROJECTS\bwongo\resources\views/student/messages.blade.php ENDPATH**/ ?>