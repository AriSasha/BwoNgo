<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'BwoNgo'); ?> · BwoNgo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:wght@400;700&family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700&display=swap">
    <link rel="stylesheet" href="<?php echo e(asset('css/bwongo.css')); ?>">
</head>
<body>
<header class="top">
    <div class="wrap">
        <a class="brand" href="<?php echo e(route('welcome')); ?>">
            <?php echo $__env->make('partials.logo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div><b>BwoNgo</b><span>Mental health check-in &amp; referral · MUBS</span></div>
        </a>
        <nav aria-label="Main">
            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->isStudent()): ?>
                    <?php ($unread = auth()->user()->conversation?->unreadByStudent()); ?>
                    <a href="<?php echo e(route('student.home')); ?>" class="<?php echo e(request()->routeIs('student.home', 'student.screenings.*') ? 'on' : ''); ?>">Check-in</a>
                    <a href="<?php echo e(route('student.messages')); ?>" class="<?php echo e(request()->routeIs('student.messages') ? 'on' : ''); ?>">Talk to a counselor <?php if($unread): ?><span class="dot" aria-label="new reply"></span><?php endif; ?></a>
                    <a href="<?php echo e(route('student.history')); ?>" class="<?php echo e(request()->routeIs('student.history') ? 'on' : ''); ?>">My results</a>
                <?php else: ?>
                    <?php ($newRefs = \App\Models\Referral::where('status', 'new')->count()); ?>
                    <?php ($unreadThreads = \App\Models\Conversation::whereNotNull('last_student_message_at')->where(fn ($q) => $q->whereNull('office_read_at')->orWhereColumn('last_student_message_at', '>', 'office_read_at'))->count()); ?>
                    <a href="<?php echo e(route('office.referrals.index')); ?>" class="<?php echo e(request()->routeIs('office.referrals.*') ? 'on' : ''); ?>">Referrals <?php if($newRefs): ?><span class="dot" aria-label="<?php echo e($newRefs); ?> new"></span><?php endif; ?></a>
                    <a href="<?php echo e(route('office.messages.index')); ?>" class="<?php echo e(request()->routeIs('office.messages.*') ? 'on' : ''); ?>">Messages <?php if($unreadThreads): ?><span class="dot" aria-label="unread"></span><?php endif; ?></a>
                    <a href="<?php echo e(route('office.overview')); ?>" class="<?php echo e(request()->routeIs('office.overview') ? 'on' : ''); ?>">Overview</a>
                    <?php if(auth()->user()->isAdmin()): ?>
                        <a href="<?php echo e(route('office.settings')); ?>" class="<?php echo e(request()->routeIs('office.settings') ? 'on' : ''); ?>">Settings</a>
                    <?php endif; ?>
                <?php endif; ?>
                <form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?><button type="submit">Sign out</button></form>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>">Sign in</a>
                <a href="<?php echo e(route('register')); ?>">Create account</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="wrap">
    <?php if(session('status')): ?>
        <div class="notice narrow" role="status" style="margin-bottom:16px"><?php echo e(session('status')); ?></div>
    <?php endif; ?>
    <?php echo $__env->yieldContent('content'); ?>
</main>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\Laravel\PROJECTS\bwongo\resources\views/layouts/app.blade.php ENDPATH**/ ?>