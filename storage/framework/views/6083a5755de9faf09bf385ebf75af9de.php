<?php ($settings = \App\Models\Setting::values()); ?>
<section class="safety" <?php if(isset($id)): ?> id="<?php echo e($id); ?>" <?php endif; ?> <?php if(!empty($hidden)): ?> hidden <?php endif; ?> aria-label="Support right now">
    <h3><?php echo e($heading ?? 'Please reach out today'); ?></h3>
    <p>You said you've had thoughts of being better off dead or of hurting yourself. Those thoughts deserve support from a real person, today. If you might act on them, call emergency services or go to the nearest hospital now.</p>
    <div class="lines">
        <?php $__currentLoopData = \App\Support\Screening::CRISIS_LINES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="line"><b><?php echo e($line['number']); ?></b><span><?php echo e($line['name']); ?></span><span><?php echo e($line['hours']); ?></span></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if($settings['office_phone']): ?>
            <div class="line"><b><?php echo e($settings['office_phone']); ?></b><span><?php echo e($settings['office_name']); ?></span><span><?php echo e($settings['office_hours']); ?></span></div>
        <?php endif; ?>
    </div>
    <p class="small">You can also tell a friend, roommate, warden or lecturer you trust and ask them to stay with you.</p>
</section>
<?php /**PATH D:\Laravel\PROJECTS\bwongo\resources\views/partials/crisis.blade.php ENDPATH**/ ?>