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
        // Flag to track if the browser allows audio yet
        let audioContextUnlocked = false;

        // Wake up the audio engine on the first user interaction
        function unlockAudioEngine() {
            if (audioContextUnlocked) return;
            
            const sound = document.getElementById('chatNotificationSound');
            if (sound) {
                // Play and immediately pause to verify permissions with the browser
                sound.play()
                    .then(() => {
                        sound.pause();
                        sound.currentTime = 0;
                        audioContextUnlocked = true;
                        console.log('🔊 Chat notification engine successfully unlocked.');
                        
                        // Clean up listeners
                        document.removeEventListener('click', unlockAudioEngine);
                        document.removeEventListener('keydown', unlockAudioEngine);
                    })
                    .catch(err => console.debug('Waiting for a more definitive user action...'));
            }
        }

        // Assign listeners to capture early layout interaction
        document.addEventListener('click', unlockAudioEngine);
        document.addEventListener('keydown', unlockAudioEngine);

        function playNotificationSound() {
            const sound = document.getElementById('chatNotificationSound');
            if (sound) {
                sound.currentTime = 0; 
                
                const playPromise = sound.play();
                if (playPromise !== undefined) {
                    playPromise.catch(error => {
                        console.warn('Playback blocked. Click anywhere on the page to enable sound notifications:', error);
                    });
                }
            }
        }
    </script>

    
    <?php
        $activeChannelId = request('channel', $lobby->channels->first()?->id);
        $currentChannel = $lobby->channels->firstWhere('id', $activeChannelId) ?? $lobby->channels->first();
    ?>

    <style>
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }
        .animate-bounce-slow-1 { animation: bounce-slow 1s infinite 0.1s; }
        .animate-bounce-slow-2 { animation: bounce-slow 1s infinite 0.2s; }
        .animate-bounce-slow-3 { animation: bounce-slow 1s infinite 0.3s; }
        
        @keyframes slide-in-up {
            0% { opacity: 0; transform: translateY(12px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-up { animation: slide-in-up 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

        /* Dynamic CSS variables for instant theme switching */
        .theme-blue {
            --brand-primary: 99 102 241; /* Indigo-500 */
            --brand-primary-hover: 79 70 229; /* Indigo-600 */
            --brand-bg-accent: 30 58 138; /* Blue-950 */
            --brand-border: 30 41 59; /* Slate-800 */
            --brand-text: 129 140 248; /* Indigo-400 */
        }
        .theme-rose {
            --brand-primary: 244 63 94; /* Rose-500 */
            --brand-primary-hover: 225 29 72; /* Rose-600 */
            --brand-bg-accent: 76 5 25; /* Rose-950 */
            --brand-border: 136 19 55; /* Rose-900 */
            --brand-text: 251 113 133; /* Rose-400 */
        }
    </style>

    
    <div id="theme-root" class="theme-blue bg-slate-950 min-h-screen text-stone-100 flex flex-col lg:flex-row selection:bg-rose-500/30 selection:text-rose-300">
        
        <div class="w-full lg:w-80 bg-slate-900 border-b lg:border-b-0 lg:border-r border-[rgb(var(--brand-border))]/60 p-6 flex flex-col justify-between shrink-0 overflow-y-auto lg:h-[calc(100vh-65px)] shadow-lg transition-all duration-300">
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <a href="<?php echo e(route('dashboard')); ?>" class="px-3 py-1.5 bg-slate-950 hover:bg-[rgb(var(--brand-bg-accent))]/20 border border-slate-800 hover:border-[rgb(var(--brand-primary))]/40 text-stone-400 hover:text-[rgb(var(--brand-text))] rounded-xl transition-all duration-200 text-xs font-semibold flex items-center gap-1.5 shadow-inner">
                        ← Dashboard
                    </a>
                    
                    <button id="theme-toggle-btn" class="p-1.5 bg-slate-950 border border-slate-800 hover:border-[rgb(var(--brand-primary))]/60 rounded-xl text-stone-400 hover:text-[rgb(var(--brand-text))] transition-all duration-200" title="Switch Theme">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.098 19.902a3.75 3.75 0 005.304 0l6.401-6.402M4.098 19.902a3.75 3.75 0 015.304-5.304l6.401-6.401m-11.705 11.705l-.71-.71m7.115-7.114l-.71-.71m11.705-11.705a3.75 3.75 0 115.304 5.304l-6.401 6.401m5.304-5.304l.71-.71m-7.115 7.114l.71-.71M11 6.22a6.75 6.75 0 00-6.75 6.75m13.5 0a6.75 6.75 0 01-6.75 6.75m0-13.5A6.75 6.75 0 0117.75 13.5m-13.5 0A6.75 6.75 0 0011 20.25" />
                        </svg>
                    </button>
                </div>

                <div>
                    <h2 class="text-xl font-black text-white tracking-tight drop-shadow-sm"><?php echo e($lobby->name); ?></h2>
                    <p class="text-[11px] text-stone-400 mt-1 leading-relaxed">
                        Goal: <span class="text-[rgb(var(--brand-text))]/90 font-medium"><?php echo e($lobby->project_goal); ?></span>
                    </p>
                </div>

                <div class="h-[1px] bg-gradient-to-r from-[rgb(var(--brand-border))]/60 via-slate-800 to-transparent"></div>

                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xs font-bold text-stone-400 uppercase tracking-wider">
                            Text Channels
                        </h3>
                        <?php if(auth()->id() === $lobby->owner_id): ?>
                            <a href="<?php echo e(route('lobbies.channels.create', $lobby->id)); ?>" class="p-1 hover:bg-[rgb(var(--brand-primary))]/10 rounded text-stone-400 hover:text-[rgb(var(--brand-text))] transition-colors duration-150" title="Create New Channel">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="space-y-1">
                        <?php $__empty_1 = true; $__currentLoopData = $lobby->channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roomChannel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php $isActive = $currentChannel?->id === $roomChannel->id; ?>
                            <a href="<?php echo e(route('chat.index', ['lobby' => $lobby->id, 'channel' => $roomChannel->id])); ?>" 
                               class="flex items-center gap-2 px-3 py-2 rounded-xl transition-all duration-200 text-xs <?php echo e($isActive ? 'bg-[rgb(var(--brand-primary))]/10 text-[rgb(var(--brand-text))] border border-[rgb(var(--brand-primary))]/20 font-bold shadow-sm' : 'text-stone-400 hover:text-stone-200 hover:bg-slate-950/60 border border-transparent hover:border-slate-800 font-medium'); ?>">
                                <span class="<?php echo e($isActive ? 'text-[rgb(var(--brand-primary))]' : 'text-stone-600'); ?> font-mono text-sm">#</span> 
                                <?php echo e($roomChannel->name); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-[11px] text-stone-500 p-3 bg-slate-950/30 rounded-xl text-center border border-dashed border-slate-800">
                                No active channels found.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="h-[1px] bg-gradient-to-r from-[rgb(var(--brand-border))]/60 via-slate-800 to-transparent"></div>

                <div>
                    <h3 class="text-xs font-bold text-stone-400 uppercase tracking-wider mb-3">
                        Workspace Roster (<?php echo e($lobby->members->count()); ?>)
                    </h3>
                    <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                        <?php $__currentLoopData = $lobby->members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-2 bg-slate-950/40 border border-slate-800/60 rounded-xl hover:border-[rgb(var(--brand-border))]/50 transition-colors">
                                <div class="flex items-center gap-2 truncate">
                                    <div class="w-6 h-6 rounded-md text-center flex items-center justify-center font-bold text-[10px] uppercase shrink-0 shadow-inner <?php echo e($member->id == 2 ? 'bg-[rgb(var(--brand-primary))]/20 border border-[rgb(var(--brand-primary))]/40 text-[rgb(var(--brand-text))]' : 'bg-slate-800 border border-slate-700 text-stone-300'); ?>">
                                        <?php echo e(substr($member->name, 0, 2)); ?>

                                    </div>
                                    <div class="truncate">
                                        <h5 class="text-xs font-bold text-stone-200 truncate"><?php echo e($member->name); ?></h5>
                                        <p class="text-[9px] text-stone-500 uppercase tracking-wide">
                                            <?php if($member->id == 2): ?>
                                                AI Companion
                                            <?php else: ?>
                                                <?php echo e($member->id === $lobby->owner_id ? 'Organizer' : 'Partner'); ?>

                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                                <span class="w-1.5 h-1.5 rounded-full shrink-0 shadow-sm <?php echo e($member->id == 2 ? 'bg-[rgb(var(--brand-text))]' : 'bg-emerald-500 shadow-emerald-500/50'); ?>"></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-800/60 mt-6 lg:mt-0 text-[10px] text-stone-500 text-center font-mono tracking-wider uppercase">
                Ref ID: #<?php echo e($lobby->id); ?>

            </div>
        </div>

        <div class="flex-1 flex flex-col min-h-[500px] lg:h-[calc(100vh-65px)] bg-slate-950/40">
            
            <?php if($currentChannel): ?>
                <div class="px-6 py-4 bg-slate-900/40 border-b border-slate-900 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-[rgb(var(--brand-primary))]/10 border border-[rgb(var(--brand-primary))]/20 text-[rgb(var(--brand-text))] rounded-xl shadow-inner">
                            <span class="font-mono font-bold text-sm">#</span>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white tracking-wide"><?php echo e($currentChannel->name); ?></h3>
                            <p class="text-[11px] text-stone-400"><?php echo e($currentChannel->description ?? 'Secure team sync for verified partners'); ?></p>
                        </div>
                    </div>
                </div>

                
                <div id="chat-timeline" class="flex-1 overflow-y-auto p-6 space-y-4 shadow-inner scroll-smooth">
                    <div class="flex items-center justify-center my-2">
                        <div class="bg-[rgb(var(--brand-bg-accent))]/10 border border-[rgb(var(--brand-border))]/40 px-3 py-1 rounded-full text-[10px] text-[rgb(var(--brand-text))]/80 font-mono tracking-wide shadow-sm">
                            ⚡ Channel feed #<?php echo e($currentChannel->name); ?> verified secure
                        </div>
                    </div>

                    
                    <div id="messages-wrapper" class="space-y-4">
                        <?php $__empty_1 = true; $__currentLoopData = $currentChannel->messages ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php 
                                $isMe = $message->user_id === auth()->id(); 
                                $isTimmy = $message->user_id == 2;
                            ?>
                            
                            <div class="message-bubble flex items-start gap-3 max-w-[85%] <?php echo e($isMe ? 'ml-auto flex-row-reverse' : ''); ?> animate-slide-up">
                                <div class="w-8 h-8 rounded-lg text-white flex items-center justify-center font-bold text-xs uppercase shrink-0 select-none shadow-md transition-all duration-300
                                    <?php echo e($isMe ? 'bg-[rgb(var(--brand-primary))] border border-[rgb(var(--brand-primary))]/40' : ($isTimmy ? 'bg-gradient-to-br from-purple-600 to-indigo-700 border border-purple-500/40 text-stone-100' : 'bg-slate-800 border border-slate-700 text-stone-300')); ?>">
                                    <?php echo e(substr($message->user->name ?? '?', 0, 2)); ?>

                                </div>

                                <div class="<?php echo e($isMe ? 'text-right' : ''); ?>">
                                    <div class="flex items-baseline gap-2 <?php echo e($isMe ? 'flex-row-reverse' : ''); ?>">
                                        <span class="sender-name-label text-xs font-bold <?php echo e($isTimmy ? 'text-[rgb(var(--brand-text))]' : 'text-stone-200'); ?>">
                                            <?php echo e($isMe ? 'You' : ($message->user->name ?? 'Anonymous')); ?>

                                        </span>
                                        <span class="text-[9px] text-stone-500 font-mono"><?php echo e($message->created_at->format('g:i A')); ?></span>
                                    </div>

                                    <div class="mt-1 px-4 py-2.5 rounded-2xl text-sm transition-all duration-300 transform shadow-sm font-normal leading-relaxed
                                        <?php echo e($isMe ? 'bg-[rgb(var(--brand-primary))]/10 border border-[rgb(var(--brand-primary))]/20 text-stone-100 rounded-tr-none text-left hover:bg-[rgb(var(--brand-primary))]/20' : ($isTimmy ? 'bg-slate-900 border border-purple-500/30 text-stone-100 rounded-tl-none font-medium' : 'bg-slate-900 border border-slate-800 text-stone-300 rounded-tl-none hover:border-slate-700')); ?>">
                                        <?php echo e($message->content); ?>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div id="empty-history-notice" class="text-center py-12 text-stone-500 text-xs font-mono tracking-wide">
                                #<?php echo e($currentChannel->name); ?> is entirely quiet. Send a query or tag <span class="text-[rgb(var(--brand-text))]">@timmy</span> to open up discussion!
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div id="typing-container" class="px-6 py-1 hidden">
                    <div class="flex items-center gap-2 text-stone-400 bg-slate-900/60 border border-[rgb(var(--brand-border))]/40 w-fit px-3 py-1.5 rounded-xl shadow-md animate-slide-up">
                        <div class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-[rgb(var(--brand-text))] rounded-full animate-bounce-slow-1"></span>
                            <span class="w-1.5 h-1.5 bg-[rgb(var(--brand-text))] rounded-full animate-bounce-slow-2"></span>
                            <span class="w-1.5 h-1.5 bg-[rgb(var(--brand-text))] rounded-full animate-bounce-slow-3"></span>
                        </div>
                        <span id="typing-text" class="text-[10px] font-mono tracking-wide text-[rgb(var(--brand-text))]">You are typing...</span>
                    </div>
                </div>

                <div class="p-4 bg-slate-900/40 border-t border-slate-900">
                    <form id="chat-form" action="<?php echo e(route('messages.store', ['channel' => $currentChannel->id])); ?>" method="POST" class="flex items-center gap-2 relative">
                        <?php echo csrf_field(); ?>
                        <input id="message-input" name="content" type="text" autocomplete="off" required placeholder="Message #<?php echo e($currentChannel->name); ?> or tag @timmy..." 
                               class="w-full bg-slate-950 border border-slate-800 focus:border-[rgb(var(--brand-primary))]/60 focus:ring focus:ring-[rgb(var(--brand-primary))]/10 text-stone-200 text-sm pl-4 pr-16 py-3 rounded-xl transition-all duration-200 placeholder-stone-600 shadow-inner" />
                        <div class="absolute right-2">
                            <button type="submit" class="bg-[rgb(var(--brand-primary))] hover:bg-[rgb(var(--brand-primary-hover))] text-white font-bold p-2 rounded-lg transition-all duration-200 active:scale-95 shadow-md">
                                <svg class="w-4 h-4 transform rotate-90" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9-7-9-7v14z"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <div class="flex-1 flex flex-col items-center justify-center text-stone-500 text-sm p-6">
                    <svg class="w-12 h-12 text-slate-800 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                    <span>This workspace has no active feeds. Click the <strong class="text-[rgb(var(--brand-text))] font-bold">+</strong> button above to deploy one.</span>
                </div>
            <?php endif; ?>

        </div>

    </div>

    <script>
        // --- 1. Immediate Theme Engine Initialization ---
        const themeRoot = document.getElementById('theme-root');
        const themeToggleBtn = document.getElementById('theme-toggle-btn');
        
        const savedTheme = localStorage.getItem('chat-workspace-theme') || 'theme-blue';
        if (themeRoot) {
            themeRoot.className = themeRoot.className.replace('theme-blue', savedTheme);
        }

        if (themeToggleBtn && themeRoot) {
            themeToggleBtn.addEventListener('click', () => {
                if (themeRoot.classList.contains('theme-blue')) {
                    themeRoot.classList.remove('theme-blue');
                    themeRoot.classList.add('theme-rose');
                    localStorage.setItem('chat-workspace-theme', 'theme-rose');
                } else {
                    themeRoot.classList.remove('theme-rose');
                    themeRoot.classList.add('theme-blue');
                    localStorage.setItem('chat-workspace-theme', 'theme-blue');
                }
            });
        }

        // --- 2. Chat Timeline Layout Listeners ---
        document.addEventListener('DOMContentLoaded', () => {
            const chatForm = document.getElementById('chat-form');
            const messageInput = document.getElementById('message-input');
            const typingContainer = document.getElementById('typing-container');
            const typingText = document.getElementById('typing-text');
            const chatTimeline = document.getElementById('chat-timeline');

            if (!chatTimeline) return;

            // Lock initial viewport viewing focus directly onto the bottom entries
            chatTimeline.scrollTop = chatTimeline.scrollHeight;

            // --- 🔄 1-SECOND BACKGROUND AUTO-REFRESH ENGINE ---
            const currentUrl = window.location.href;
            
            setInterval(async () => {
                try {
                    // Fetch current workspace snapshot silently
                    const response = await fetch(currentUrl, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    
                    if (response.ok) {
                        const htmlText = await response.text();
                        
                        // Parse incoming string to access nodes cleanly
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(htmlText, 'text/html');
                        const incomingWrapper = doc.getElementById('messages-wrapper');
                        const currentWrapper = document.getElementById('messages-wrapper');
                        
                        if (incomingWrapper && currentWrapper) {
                            if (incomingWrapper.innerHTML.trim() !== currentWrapper.innerHTML.trim()) {
                                
                                // 🔊 FIXED AUDIO RING ENGINE (By message count difference)
                                const currentCount = currentWrapper.querySelectorAll('.message-bubble').length;
                                const incomingBubbles = incomingWrapper.querySelectorAll('.message-bubble');
                                const incomingCount = incomingBubbles.length;

                                if (incomingCount > currentCount) {
                                    const lastIncomingBubble = incomingBubbles[incomingCount - 1];
                                    const nameSpan = lastIncomingBubble.querySelector('.sender-name-label');
                                    
                                    // Read text value directly. If it says "You", do not make sound.
                                    const isMessageFromMe = nameSpan ? nameSpan.innerText.trim() === 'You' : false;
                                    
                                    if (!isMessageFromMe) {
                                        playNotificationSound();
                                    }
                                }

                                // Detect if user is reading older history logs
                                const isScrolledToBottom = (chatTimeline.scrollHeight - chatTimeline.clientHeight - chatTimeline.scrollTop) < 60;
                                
                                // Inject new messages node
                                currentWrapper.innerHTML = incomingWrapper.innerHTML;
                                
                                // Snap down if they were already at the bottom
                                if (isScrolledToBottom) {
                                    chatTimeline.scrollTop = chatTimeline.scrollHeight;
                                }
                            }
                        }
                    }
                } catch (err) {
                    console.debug('Background sync cycle paused temporarily.');
                }
            }, 1000); // 1000ms = 1 Second Loop Rate

            // --- AJAX FORM MESSAGE SUBMISSION ---
            if (chatForm && messageInput) {
                chatForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    
                    const textValue = messageInput.value.trim();
                    if (!textValue) return;

                    const formData = new FormData(chatForm);
                    const actionUrl = chatForm.getAttribute('action');

                    if (textValue.toLowerCase().includes('@timmy') && typingText && typingContainer) {
                        typingText.innerText = "Timmy is thinking...";
                        typingContainer.classList.remove('hidden');
                    }

                    messageInput.value = '';

                    try {
                        await fetch(actionUrl, {
                            method: 'POST',
                            body: formData,
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        
                        chatTimeline.scrollTop = chatTimeline.scrollHeight;
                    } catch (error) {
                        console.error('Failed to dispatch feed entry data package.', error);
                    }
                });
            }

            // Monitor keyboard interactions for typing indicators
            let typingTimeout;
            if (messageInput && typingContainer && typingText) {
                messageInput.addEventListener('input', () => {
                    if (messageInput.value.trim().length > 0) {
                        const isTimmy = messageInput.value.toLowerCase().includes('@timmy');
                        typingText.innerText = isTimmy ? "Timmy is listening..." : "You are typing...";
                        typingContainer.classList.remove('hidden');
                    } else {
                        typingContainer.classList.add('hidden');
                    }

                    clearTimeout(typingTimeout);
                    typingTimeout = setTimeout(() => {
                        typingContainer.classList.add('hidden');
                    }, 2000);
                });
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
<?php endif; ?><?php /**PATH C:\Users\Pongo\Desktop\TEAMAP\TeaMap\resources\views/chat/index.blade.php ENDPATH**/ ?>