<form method="POST" action="<?php echo e(route('student.referrals.store', $s)); ?>" class="form">
    <?php echo csrf_field(); ?>
    <div class="field"><label for="full_name">Full name</label><input id="full_name" name="full_name" value="<?php echo e(old('full_name', auth()->user()->name)); ?>" required autocomplete="name"></div>
    <div class="field"><label for="student_number">Student number</label><input id="student_number" name="student_number" value="<?php echo e(old('student_number', auth()->user()->student_number)); ?>" inputmode="numeric"></div>
    <div class="field"><label for="contact">Phone or email</label><input id="contact" name="contact" value="<?php echo e(old('contact', auth()->user()->phone)); ?>" required placeholder="07XX XXX XXX"></div>
    <div class="field"><label for="contact_method">How should they contact you?</label>
        <select id="contact_method" name="contact_method">
            <?php $__currentLoopData = $contactMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option <?php if(old('contact_method') === $m): echo 'selected'; endif; ?>><?php echo e($m); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="field full"><label for="preferred_time">Best time to reach you</label><input id="preferred_time" name="preferred_time" value="<?php echo e(old('preferred_time')); ?>" placeholder="e.g. weekdays after 4pm"></div>
    <div class="field full"><label for="note">Anything you'd like the counselor to know (optional)</label><textarea id="note" name="note"><?php echo e(old('note')); ?></textarea></div>
    <label class="check full"><input type="checkbox" name="consent" value="1" <?php if(old('consent')): echo 'checked'; endif; ?>><span>I agree that the <?php echo e($settings['office_name']); ?> may see my name, contact details and these scores, and contact me<?php echo e($s->hasSelfHarmAnswer() ? ' as soon as possible' : ''); ?>.</span></label>
    <?php if($errors->any()): ?><div class="err full" role="alert"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p><?php echo e($e); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div><?php endif; ?>
    <div class="row full"><button class="btn primary" type="submit">Send referral request</button></div>
</form>
<?php /**PATH D:\Laravel\PROJECTS\bwongo\resources\views/student/partials/referral-form.blade.php ENDPATH**/ ?>