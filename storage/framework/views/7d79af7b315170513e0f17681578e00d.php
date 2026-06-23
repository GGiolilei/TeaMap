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
    <div class="py-10 bg-slate-950 min-h-screen text-slate-100">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <div>
                <a href="<?php echo e(route('dashboard')); ?>" class="text-xs font-semibold text-slate-400 hover:text-indigo-400 transition inline-flex items-center gap-1.5 mb-2">
                    ← Back to Dashboard
                </a>
                <h2 class="text-2xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-violet-400">
                    Profile Configuration & CV Verification
                </h2>
                <p class="text-sm text-slate-400 mt-0.5">
                    Upload your latest resume or professional portfolio to unlock verified applications and show team leads your background.
                </p>
            </div>

            <?php if(session('success')): ?>
                <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl text-sm font-medium shadow-sm">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <div class="bg-slate-900 border border-slate-800 p-5 rounded-2xl shadow-lg flex items-center justify-between gap-4 relative overflow-hidden">
                <div class="flex items-center gap-3.5">
                    <div class="p-3 rounded-xl <?php echo e(auth()->user()->profile?->cv_path ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-amber-500/10 text-amber-400 border border-amber-500/20'); ?>">
                        <?php if(auth()->user()->profile?->cv_path): ?>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <?php else: ?>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <?php endif; ?>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Current Verification Status</div>
                        <h4 class="text-sm font-bold <?php echo e(auth()->user()->profile?->cv_path ? 'text-emerald-400' : 'text-amber-400'); ?> mt-0.5">
                            <?php echo e(auth()->user()->profile?->cv_path ? 'CV Successfully Verified' : 'No CV Found On System Record'); ?>

                        </h4>
                    </div>
                </div>

                <?php if(auth()->user()->profile?->cv_path): ?>
                    <a href="<?php echo e(asset('storage/' . auth()->user()->profile->cv_path)); ?>" target="_blank" 
                       class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 bg-slate-950 border border-slate-800 px-3.5 py-2 rounded-xl transition shadow-inner">
                        Review Active File ↗
                    </a>
                <?php endif; ?>
            </div>

            <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-xl relative">
                
                <form method="POST" action="<?php echo e(route('profile.cv.update')); ?>" enctype="multipart/form-data" class="space-y-5">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Upload New Document</label>
                        
                        <div class="border-2 border-dashed border-slate-800 hover:border-indigo-500/50 bg-slate-950/40 rounded-2xl p-8 text-center transition cursor-pointer relative group">
                            <input type="file" name="cv" id="cv_input_file" required
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />
                            
                            <div class="space-y-2 pointer-events-none">
                                <div class="mx-auto w-10 h-10 text-slate-500 group-hover:text-indigo-400 transition flex items-center justify-center">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/></svg>
                                </div>
                                <div class="text-sm font-medium text-slate-300">
                                    <span class="text-indigo-400 font-semibold">Click to browse</span> or drag your document here
                                </div>
                                <div class="text-xs text-slate-500">
                                    Supported Formats: PDF, DOCX (Max size: 5MB)
                                </div>
                            </div>
                        </div>
                        
                        <div id="file_name_display" class="mt-2 text-xs text-indigo-400 hidden font-medium"></div>
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-2 text-xs text-rose-400','messages' => $errors->get('cv')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2 text-xs text-rose-400','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('cv'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>

                    <div class="pt-4 border-t border-slate-800/80 flex items-center justify-end gap-3">
                        <a href="<?php echo e(route('dashboard')); ?>" class="text-xs font-semibold text-slate-400 hover:text-slate-200 transition bg-slate-800/40 border border-slate-800/60 px-4 py-2.5 rounded-xl">
                            Cancel
                        </a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm py-2.5 px-5 rounded-xl transition duration-200 shadow-md shadow-indigo-950/40">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('cv_input_file').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const displayDiv = document.getElementById('file_name_display');
            if (fileName) {
                displayDiv.textContent = `Selected file: ${fileName}`;
                displayDiv.classList.remove('hidden');
            } else {
                displayDiv.classList.add('hidden');
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
<?php endif; ?><?php /**PATH C:\Users\Pongo\Desktop\TEAMAP\TeaMap\resources\views/profile/edit.blade.php ENDPATH**/ ?>