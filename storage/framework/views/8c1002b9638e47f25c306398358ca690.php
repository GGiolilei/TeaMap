<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>


<audio id="chatNotificationSound" src="<?php echo e(asset('sounds/notification.mp3')); ?>" preload="auto"></audio>

<script>
function playNotificationSound() {
    const sound = document.getElementById('chatNotificationSound');
    if (!sound) return;
    sound.currentTime = 0;
    sound.play().catch(() => {});
}
</script>

<div class="py-8 bg-slate-950 min-h-screen text-slate-100">

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

    
    <?php if(session('success')): ?>
        <div class="p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="p-3 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-sm">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>


    
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">

        <div class="flex flex-wrap gap-2 items-center">
            <span class="text-xs text-slate-500">Focus:</span>

            <?php $__empty_1 = true; $__currentLoopData = auth()->user()->interests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <span class="px-2 py-1 text-xs rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400">
                    <?php echo e($interest->name); ?>

                </span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <span class="text-xs text-slate-500">No interests selected</span>
            <?php endif; ?>
        </div>

        <div class="flex items-center gap-2">

            <span class="px-3 py-1 text-xs rounded-full border border-slate-800 bg-slate-950 text-slate-400">
                CV:
                <span class="<?php echo e(auth()->user()->profile?->cv_path ? 'text-emerald-400' : 'text-amber-400'); ?>">
                    <?php echo e(auth()->user()->profile?->cv_path ? 'Ready' : 'Missing'); ?>

                </span>
            </span>

            <a href="<?php echo e(route('profile.edit')); ?>"
               class="px-3 py-1 text-xs rounded-lg bg-slate-800 hover:bg-slate-700 border border-slate-700 transition">
                Edit Profile
            </a>

        </div>

    </div>


    
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-3 flex flex-wrap items-center justify-between gap-2">

        <div class="flex flex-wrap gap-2">

            <a href="<?php echo e(route('lobby.create')); ?>"
               class="px-3 py-1.5 text-xs rounded-lg bg-indigo-600 hover:bg-indigo-500 font-semibold">
                + New Lobby
            </a>

            <a href="<?php echo e(route('lobbies.index')); ?>"
               class="px-3 py-1.5 text-xs rounded-lg bg-slate-950 border border-slate-800 hover:border-indigo-500/30 text-slate-300">
                Explore
            </a>

            <?php if($joinedLobbies->count() > 0): ?>
                <a href="<?php echo e(route('chat.index', $joinedLobbies->first()->id)); ?>"
                   class="px-3 py-1.5 text-xs rounded-lg bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 hover:bg-indigo-600 hover:text-white">
                    Open Chat
                </a>
            <?php endif; ?>

        </div>

        <div class="text-xs px-3 py-1 rounded-full bg-slate-950 border border-slate-800 text-slate-400">
            Joined <span class="text-indigo-400 font-bold"><?php echo e($joinedLobbies->count()); ?></span>
        </div>

    </div>


    
    <?php if(isset($ownedLobbiesWithRequests) && $ownedLobbiesWithRequests->count()): ?>

    <div class="bg-slate-900 border border-indigo-500/20 rounded-2xl p-5 space-y-3">

        <div class="flex justify-between items-center">
            <h3 class="text-sm font-semibold">Incoming Requests</h3>
            <span class="text-xs text-indigo-400">Action Needed</span>
        </div>

        <div class="space-y-3 max-h-72 overflow-y-auto">

            <?php $__currentLoopData = $ownedLobbiesWithRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lobby): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $lobby->members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $applicant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <div class="flex justify-between items-center p-3 bg-slate-950 border border-slate-800 rounded-xl">

                    <div class="min-w-0">
                        <p class="text-xs text-slate-400"><?php echo e($lobby->name); ?></p>
                        <p class="text-sm font-semibold truncate"><?php echo e($applicant->name); ?></p>
                    </div>

                    <div class="flex gap-2">

                        <?php if($applicant->profile?->cv_path): ?>
                            <a href="<?php echo e(route('lobby.member.cv', [$lobby->id, $applicant->id])); ?>"
                               class="text-xs px-3 py-1 rounded-lg bg-slate-800 border border-slate-700">
                                CV
                            </a>
                        <?php endif; ?>

                        <form class="accept-form" method="POST"
                              action="<?php echo e(route('membership.update', [$applicant->pivot->id ?? $applicant->id, 'accepted'])); ?>">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <button class="text-xs px-3 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-500">
                                Accept
                            </button>
                        </form>

                        <form method="POST"
                              action="<?php echo e(route('membership.update', [$applicant->pivot->id ?? $applicant->id, 'rejected'])); ?>">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <button class="text-xs px-3 py-1 rounded-lg bg-slate-800 hover:bg-rose-500/20">
                                Reject
                            </button>
                        </form>

                    </div>

                </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

    </div>

    <?php endif; ?>


    
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4">

        <form method="GET" action="<?php echo e(route('dashboard')); ?>" class="space-y-3">

            <input type="text"
                   name="search"
                   value="<?php echo e(request('search')); ?>"
                   placeholder="Search lobbies..."
                   class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2 text-sm">

            <div class="flex flex-wrap gap-2 text-xs">

                <a href="<?php echo e(route('dashboard')); ?>"
                   class="px-3 py-1 rounded-lg border <?php echo e(!request('interest') ? 'bg-indigo-500/10 text-indigo-400' : 'border-slate-800'); ?>">
                    All
                </a>

                <?php $__currentLoopData = \App\Models\Interest::take(5)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('dashboard', ['interest' => $tag->id])); ?>"
                       class="px-3 py-1 rounded-lg border <?php echo e(request('interest') == $tag->id ? 'bg-indigo-500/10 text-indigo-400' : 'border-slate-800'); ?>">
                        #<?php echo e($tag->name); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

        </form>

    </div>


    
    <?php if($joinedLobbies->count()): ?>

    <div class="space-y-3">

        <h3 class="text-sm text-slate-300 font-semibold">Active Lobbies</h3>

        <div class="grid md:grid-cols-2 gap-4">

            <?php $__currentLoopData = $joinedLobbies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lobby): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4">

                <div class="flex justify-between">
                    <div>
                        <p class="font-semibold text-sm"><?php echo e($lobby->name); ?></p>
                        <p class="text-xs text-slate-500 truncate"><?php echo e($lobby->project_goal); ?></p>
                    </div>

                    <a href="<?php echo e(route('chat.index', $lobby->id)); ?>"
                       class="text-xs px-3 py-1 rounded-lg bg-indigo-600/20 text-indigo-400">
                        Chat
                    </a>
                </div>

                <p class="text-xs text-slate-500 mt-2">
                    <?php echo e($lobby->members->count()); ?> members
                </p>

            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

    </div>

    <?php endif; ?>


    
    <div class="space-y-3">

        <div class="flex items-center gap-3">
            <h3 class="text-sm font-bold text-slate-200">Recommended For You</h3>
            <div class="h-[1px] flex-1 bg-gradient-to-r from-slate-800 to-transparent"></div>
            <span class="text-[10px] text-indigo-400 bg-indigo-500/5 border border-indigo-500/10 px-2.5 py-0.5 rounded-full">
                Smart Match
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

            <?php $__empty_1 = true; $__currentLoopData = $recommendedLobbies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lobby): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <div
                class="group relative p-5 rounded-xl bg-slate-900/40 border border-slate-800
                       hover:border-indigo-500/30
                       transition-all duration-300
                       hover:-translate-y-1 hover:rotate-[0.4deg] hover:shadow-xl hover:shadow-indigo-500/10">

                <div class="flex justify-between mb-2">
                    <h4 class="text-sm font-bold group-hover:text-indigo-400 truncate">
                        <?php echo e($lobby->name); ?>

                    </h4>

                    <span class="text-[10px] px-2 py-0.5 rounded bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                        <?php echo e($lobby->matching_score ?? 0); ?>%
                    </span>
                </div>

                <p class="text-xs text-slate-400 line-clamp-2 mb-3">
                    <?php echo e($lobby->description); ?>

                </p>

                <div class="flex flex-wrap gap-1 mb-4">
                    <?php $__currentLoopData = $lobby->interests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="text-[10px] px-2 py-0.5 rounded bg-slate-950 border border-slate-800 text-slate-500">
                            #<?php echo e($interest->name); ?>

                        </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="flex justify-between items-center pt-3 border-t border-slate-800/60">

                    <span class="text-[11px] text-slate-500 truncate">
                        Goal: <span class="text-slate-300"><?php echo e($lobby->project_goal); ?></span>
                    </span>

                    <?php if(Auth::id() !== $lobby->owner_id): ?>
                    <form method="POST" action="<?php echo e(route('lobbies.join', $lobby->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="text-[11px] px-3 py-1.5 rounded-lg bg-slate-950 border border-slate-800 text-indigo-400 hover:bg-indigo-600 hover:text-white transition">
                            Join
                        </button>
                    </form>
                    <?php else: ?>
                        <span class="text-[10px] text-indigo-400 bg-indigo-500/10 px-2 py-1 rounded-md">
                            Your Lobby
                        </span>
                    <?php endif; ?>

                </div>

            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-xs text-slate-500">No recommendations yet.</p>
            <?php endif; ?>

        </div>

    </div>


</div>
</div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\Pongo\Desktop\TEAMAP\TeaMap\resources\views/dashboard.blade.php ENDPATH**/ ?>