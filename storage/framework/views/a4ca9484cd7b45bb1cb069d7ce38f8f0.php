<?php $__env->startSection('title', 'Messages'); ?>
<?php $__env->startSection('content'); ?>
<div class="stack">
    <h2>Anonymous messages</h2>
    <div class="bench">
        <div class="list">
            <?php $__empty_1 = true; $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php ($last = $c->messages->last()); ?>
                <a class="item <?php echo e($current?->id === $c->id ? 'on' : ''); ?>" href="<?php echo e(route('office.messages.show', $c)); ?>">
                    <span class="stripe fill-ok" style="opacity: <?php echo e($c->unreadByOffice() ? 1 : 0); ?>"></span>
                    <div><span class="who"><?php echo e($c->user->alias()); ?><?php if($c->unreadByOffice()): ?><span class="dot" aria-label="unread"></span><?php endif; ?></span><span class="meta"><?php echo e($last->sender === 'office' ? 'You: ' : ''); ?><?php echo e($last->body); ?></span></div>
                    <span class="small muted"><?php echo e($c->lastActivity()?->diffForHumans(short: true)); ?></span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="empty">No messages yet. Students can write to the office anonymously from "Talk to a counselor".</div>
            <?php endif; ?>
        </div>
        <div>
            <?php if($current): ?>
                <div class="stack">
                    <div class="row between">
                        <h3><?php echo e($current->user->alias()); ?></h3>
                        <?php if($current->user->referrals->isNotEmpty()): ?>
                            <span class="chip bg-mild"><?php echo e($current->user->referrals->count()); ?> referral(s) on file</span>
                        <?php else: ?>
                            <span class="chip bg-neutral">Anonymous</span>
                        <?php endif; ?>
                    </div>
                    <div class="chat" id="chat">
                        <?php $__currentLoopData = $current->messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bubble <?php echo e($m->sender === 'office' ? 'me' : 'them'); ?>"><?php echo e($m->body); ?><small><?php echo e($m->sender === 'office' ? 'Office' : 'Student'); ?> · <?php echo e($m->created_at->format('j M, H:i')); ?></small></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <form method="POST" action="<?php echo e(route('office.messages.reply', $current)); ?>" class="composer">
                        <?php echo csrf_field(); ?>
                        <textarea name="body" aria-label="Reply" placeholder="Write a reply…" required></textarea>
                        <button class="btn primary" type="submit">Reply</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="card empty">Select a conversation.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?><script>const c=document.getElementById('chat');if(c)c.scrollTop=c.scrollHeight;</script><?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\PROJECTS\bwongo\resources\views/office/messages/index.blade.php ENDPATH**/ ?>