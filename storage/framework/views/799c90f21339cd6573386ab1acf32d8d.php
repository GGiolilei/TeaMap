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
    <div class="py-10 bg-slate-950 min-h-screen text-slate-100 flex flex-col justify-between">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex-1 flex flex-col">
            
            <div class="bg-slate-900 border border-slate-800 p-4 rounded-2xl shadow-xl flex items-center justify-between mb-6">
                <div class="flex items-center gap-4">
                    <a href="<?php echo e(route('dashboard')); ?>" class="p-2 bg-slate-950 hover:bg-slate-800 border border-slate-800 text-slate-400 hover:text-white rounded-xl transition text-xs font-semibold flex items-center gap-1">
                        ← Back
                    </a>
                    <div>
                        <h2 class="text-sm font-bold text-slate-100"><?php echo e($lobby->name); ?> Channel</h2>
                        <p class="text-[11px] text-indigo-400 font-medium">Active Workspace Chat Space</p>
                    </div>
                </div>
                <span class="text-[11px] font-mono bg-slate-950 border border-slate-800 px-3 py-1 rounded-lg text-slate-400">
                    <?php echo e($lobby->members->count()); ?> active channels connected
                </span>
            </div>

            <div class="flex-1 bg-slate-900 border border-slate-800/80 rounded-2xl shadow-inner p-6 overflow-y-auto space-y-4 min-h-[450px] max-h-[600px]" id="chatBox">
                <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-start gap-3.5 <?php echo e($message->user_id === auth()->id() ? 'flex-row-reverse' : ''); ?>">
                        <div class="w-8 h-8 rounded-xl bg-slate-950 border border-slate-800 text-indigo-400 flex items-center justify-center font-bold text-xs uppercase tracking-wider shrink-0">
                            <?php echo e(substr($message->user->name, 0, 2)); ?>

                        </div>
                        
                        <div class="flex flex-col max-w-[70%] <?php echo e($message->user_id === auth()->id() ? 'items-end' : ''); ?>">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-bold text-slate-300"><?php echo e($message->user->name); ?></span>
                                <span class="text-[9px] text-slate-500 font-medium"><?php echo e($message->created_at->diffForHumans()); ?></span>
                            </div>
                            
                            <div class="p-3.5 text-sm leading-relaxed rounded-2xl shadow-sm <?php echo e($message->user_id === auth()->id() ? 'bg-indigo-600 text-white rounded-tr-none' : 'bg-slate-950 text-slate-300 border border-slate-800 rounded-tl-none'); ?>">
                                <?php echo e($message->content); ?>

                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="h-full flex flex-col items-center justify-center text-center p-12 text-slate-500 space-y-2">
                        <svg class="w-8 h-8 text-slate-600 animate-pulse" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <p class="text-sm">Secure terminal channel established. Send the first greeting node to initialize communication.</p>
                    </div>
                <?php endif; ?>
            </div>

            <form action="<?php echo e(route('lobby.chat.send', $lobby->id)); ?>" method="POST" class="mt-4 flex items-center gap-3">
                <?php echo csrf_field(); ?>
                <div class="relative flex-1 flex items-center">
                    <input type="text" name="content" required autocomplete="off" placeholder="Transmit workspace messages to team nodes..." 
                           class="w-full bg-slate-900 border border-slate-800 focus:border-indigo-500 focus:ring focus:ring-indigo-500/10 text-slate-200 placeholder-slate-500 text-sm px-4 py-3 rounded-xl shadow-inner transition" />
                </div>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm px-6 py-3 rounded-xl transition duration-150 shadow shadow-indigo-950/50 flex items-center gap-1">
                    Send
                </button>
            </form>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var chatBox = document.getElementById("chatBox");
            if (chatBox) {
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\Pongo\Desktop\TEAMAP\TeaMap\resources\views/chat.blade.php ENDPATH**/ ?>