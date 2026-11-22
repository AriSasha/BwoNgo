<?php ($o = \App\Models\Setting::values()); ?>
<?php ($bits = array_filter(['Where' => $o['office_location'], 'Hours' => $o['office_hours'], 'Phone' => $o['office_phone'], 'Email' => $o['office_email']])); ?>
<?php if($bits): ?>
    <p class="small"><?php $__currentLoopData = $bits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><b><?php echo e($k); ?>:</b> <?php echo e($v); ?><?php if(!$loop->last): ?> · <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></p>
<?php endif; ?>
<?php /**PATH D:\Laravel\PROJECTS\bwongo\resources\views/student/partials/office.blade.php ENDPATH**/ ?>