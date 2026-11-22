
<div class="scale">
    <?php $__currentLoopData = $segments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$from, $to, $tone]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <i class="fill-<?php echo e($tone); ?>" style="flex: <?php echo e($to - $from + 1); ?>"></i>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <span class="pin" style="left: <?php echo e(round($score / $max * 100, 1)); ?>%"></span>
</div>
<div class="scale-labels">
    <span>0</span>
    <?php $__currentLoopData = array_slice($segments, 1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><span><?php echo e($seg[0]); ?></span><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <span><?php echo e($max); ?></span>
</div>
<?php /**PATH D:\Laravel\PROJECTS\bwongo\resources\views/partials/scale.blade.php ENDPATH**/ ?>