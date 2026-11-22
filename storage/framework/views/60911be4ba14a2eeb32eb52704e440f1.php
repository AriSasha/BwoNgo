<fieldset class="q">
    <legend><span><?php echo e($n); ?>.</span><?php echo e($text); ?></legend>
    <div class="opts">
        <?php $__currentLoopData = $labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label class="opt">
                <input type="radio" name="<?php echo e($name); ?>" value="<?php echo e($v); ?>" <?php if((string) $old === (string) $v): echo 'checked'; endif; ?> <?php if(empty($unscored)): ?> required <?php endif; ?>>
                <span><?php echo e($label); ?><?php if(empty($unscored)): ?><small><?php echo e($v); ?> <?php echo e($v === 1 ? 'point' : 'points'); ?></small><?php endif; ?></span>
            </label>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</fieldset>
<?php /**PATH D:\Laravel\PROJECTS\bwongo\resources\views/student/partials/question.blade.php ENDPATH**/ ?>