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
    <div class="py-12 bg-slate-950 min-h-screen text-slate-100 flex items-center justify-center">
        <div class="max-w-md w-full bg-slate-900 border border-slate-800 p-8 rounded-2xl shadow-xl">
            
            <div class="mb-6">
                <h2 class="text-xl font-black text-slate-100">Create Text Channel</h2>
                <p class="text-xs text-slate-400 mt-1">Adding a new stream inside <strong class="text-indigo-400"><?php echo e($lobby->name); ?></strong></p>
            </div>

            <form method="POST" action="<?php echo e(route('lobbies.channels.store', $lobby->id)); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Channel Name</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 text-slate-500 font-mono text-lg">#</span>
                        <input type="text" name="name" placeholder="e.g. marketing-sync" required
                               class="w-full bg-slate-950 border border-slate-800 focus:border-indigo-500 focus:ring focus:ring-indigo-500/10 text-slate-200 text-sm pl-9 pr-4 py-3 rounded-xl transition" />
                    </div>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-rose-400 text-xs mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Description (Optional)</label>
                    <input type="text" name="description" placeholder="What is this channel for?" 
                           class="w-full bg-slate-950 border border-slate-800 focus:border-indigo-500 focus:ring focus:ring-indigo-500/10 text-slate-200 text-sm px-4 py-3 rounded-xl transition" />
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800/60">
                    <a href="<?php echo e(route('chat.index', $lobby->id)); ?>" class="text-xs font-semibold text-slate-400 hover:text-white px-4 py-2.5 rounded-xl transition">
                        Cancel
                    </a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs px-5 py-2.5 rounded-xl transition shadow">
                        Create Channel
                    </button>
                </div>
            </form>

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
<?php endif; ?><?php /**PATH C:\Users\Pongo\Desktop\TEAMAP\TeaMap\resources\views/channel/create.blade.php ENDPATH**/ ?>