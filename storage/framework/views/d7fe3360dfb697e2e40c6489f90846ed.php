<?php $__env->startSection('title', 'Settings'); ?>
<?php $__env->startSection('content'); ?>
<div class="narrow stack">
    <div><h2>Settings</h2><p class="muted">Office details appear to students on their results and referral confirmation.</p></div>
    <?php if($errors->any()): ?><div class="alert" role="alert"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p><?php echo e($e); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div><?php endif; ?>
    <form method="POST" action="<?php echo e(route('office.settings.update')); ?>" class="card form">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="field full"><label for="office_name">Office name</label><input id="office_name" name="office_name" value="<?php echo e(old('office_name', $settings['office_name'])); ?>" required></div>
        <div class="field"><label for="office_location">Location</label><input id="office_location" name="office_location" value="<?php echo e(old('office_location', $settings['office_location'])); ?>" placeholder="e.g. Main Building, Room 12"></div>
        <div class="field"><label for="office_hours">Opening hours</label><input id="office_hours" name="office_hours" value="<?php echo e(old('office_hours', $settings['office_hours'])); ?>" placeholder="e.g. Mon to Fri, 8am to 5pm"></div>
        <div class="field"><label for="office_phone">Office phone</label><input id="office_phone" name="office_phone" value="<?php echo e(old('office_phone', $settings['office_phone'])); ?>"></div>
        <div class="field"><label for="office_email">Office email</label><input id="office_email" name="office_email" type="email" value="<?php echo e(old('office_email', $settings['office_email'])); ?>"></div>
        <div class="field"><label for="phq9_threshold">Refer at PHQ-9 score of</label><input id="phq9_threshold" name="phq9_threshold" type="number" min="1" max="27" value="<?php echo e(old('phq9_threshold', $settings['phq9_threshold'])); ?>"></div>
        <div class="field"><label for="gad7_threshold">Refer at GAD-7 score of</label><input id="gad7_threshold" name="gad7_threshold" type="number" min="1" max="21" value="<?php echo e(old('gad7_threshold', $settings['gad7_threshold'])); ?>"></div>
        <p class="small muted full">10 is the usual cut-off for moderate symptoms on both scales. Any answer above zero on PHQ-9 question 9 always shows crisis contacts and the referral form.</p>
        <div class="field full">
            <label>Self-help ideas shown below the referral level</label>
            <p class="small muted">Leave a row empty to remove it.</p>
            <?php $__currentLoopData = $resources->concat([null, null]); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="resrow field">
                    <input name="resources[<?php echo e($i); ?>][title]" value="<?php echo e($res?->title); ?>" aria-label="Title <?php echo e($i + 1); ?>" placeholder="Title">
                    <textarea name="resources[<?php echo e($i); ?>][body]" aria-label="Text <?php echo e($i + 1); ?>" placeholder="Short tip" style="min-height:44px"><?php echo e($res?->body); ?></textarea>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="row full"><button class="btn primary" type="submit">Save settings</button></div>
    </form>

    <section class="card stack">
        <h3>Counseling staff</h3>
        <div class="scroll-x"><table class="data">
            <thead><tr><th>Name</th><th>Email</th><th>Role</th></tr></thead>
            <tbody><?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr><td><?php echo e($u->name); ?></td><td><?php echo e($u->email); ?></td><td><?php echo e(ucfirst($u->role)); ?></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></tbody>
        </table></div>
        <form method="POST" action="<?php echo e(route('office.settings.staff')); ?>" class="form">
            <?php echo csrf_field(); ?>
            <div class="field"><label for="s_name">Name</label><input id="s_name" name="name" required></div>
            <div class="field"><label for="s_email">Email</label><input id="s_email" name="email" type="email" required></div>
            <div class="field"><label for="s_role">Role</label><select id="s_role" name="role"><option value="counselor">Counselor</option><option value="admin">Admin</option></select></div>
            <div class="field"><label for="s_password">Temporary password</label><input id="s_password" name="password" type="text" required minlength="8"></div>
            <div class="row full"><button class="btn" type="submit">Add staff account</button></div>
        </form>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Laravel\PROJECTS\bwongo\resources\views/office/settings.blade.php ENDPATH**/ ?>