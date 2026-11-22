
<?php ($logo = collect(['images/mubs-logo.svg', 'images/mubs-logo.png'])->first(fn ($p) => file_exists(public_path($p)))); ?>
<?php if($logo): ?>
    <img src="<?php echo e(asset($logo)); ?>" alt="Makerere University Business School logo" class="<?php echo e($class ?? ''); ?>">
<?php endif; ?>
<?php /**PATH D:\Laravel\PROJECTS\bwongo\resources\views/partials/logo.blade.php ENDPATH**/ ?>