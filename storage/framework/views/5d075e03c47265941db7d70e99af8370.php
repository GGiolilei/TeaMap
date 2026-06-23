<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'TeaMap')); ?></title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        
        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                letter-spacing: -0.01em;
            }
            @keyframes slide-in-up {
                0% { opacity: 0; transform: translateY(12px); }
                100% { opacity: 1; transform: translateY(0); }
            }
            .animate-slide-up { animation: slide-in-up 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        </style>
    </head>
    <body class="bg-slate-950 text-slate-100 antialiased selection:bg-indigo-500 selection:text-white">
        <div class="min-h-screen flex flex-col">
            
            <nav class="bg-slate-900/80 border-b border-slate-800/60 sticky top-0 z-50 backdrop-blur-md">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center gap-6">
                            <a href="<?php echo e(route('dashboard')); ?>" class="text-xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-violet-400">
                                TeaMap.IO
                            </a>
                            
                            <div class="hidden sm:flex space-x-1">
                                <a href="<?php echo e(route('dashboard')); ?>" class="text-sm font-medium px-4 py-2 rounded-lg bg-indigo-500/10 text-indigo-400 transition">
                                    Dashboard
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="text-right hidden sm:block">
                                <div class="text-sm font-semibold text-slate-200"><?php echo e(Auth::user()->name); ?></div>
                                <div class="text-xs text-slate-400">Verified Member</div>
                            </div>
                            
                            <a href="<?php echo e(route('profile.edit')); ?>" class="p-2 bg-slate-800 hover:bg-slate-700 border border-slate-700/50 rounded-xl text-slate-300 hover:text-indigo-400 transition shadow-sm" title="Account Settings">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </a>

                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="text-xs font-semibold text-slate-400 hover:text-rose-400 transition bg-slate-800/40 border border-slate-700/30 px-3 py-2 rounded-xl">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="flex-1">
                <?php echo e($slot); ?>

            </main>
        </div>

        <audio id="notification-sound" src="https://assets.mixkit.co/active_storage/sfx/2357/2357-84.wav" preload="auto"></audio>

        <div id="global-notification-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 hidden">
            <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm" onclick="closeNotificationModal()"></div>
            
            <div class="relative w-full max-w-sm bg-slate-900 border border-slate-800 rounded-2xl p-5 shadow-2xl animate-slide-up text-slate-100 z-10">
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-indigo-600/10 border border-indigo-500/20 text-indigo-400 rounded-xl shrink-0">
                        <span class="font-mono font-bold text-sm">#</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 id="notif-room-name" class="text-sm font-bold text-slate-100 truncate">New Notification</h4>
                        <p class="text-xs text-slate-400 mt-0.5">From: <span id="notif-sender" class="font-semibold text-indigo-400"></span></p>
                        <p id="notif-content" class="text-xs text-slate-300 mt-2 bg-slate-950/60 p-3 rounded-xl border border-slate-800/60 italic break-words max-h-24 overflow-y-auto"></p>
                    </div>
                </div>
                
                <div class="mt-5 flex items-center justify-end gap-2 text-xs">
                    <button onclick="closeNotificationModal()" class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-slate-200 rounded-xl transition font-medium">
                        Dismiss
                    </button>
                    <a id="notif-jump-link" href="#" class="px-3 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl transition font-bold shadow-md shadow-indigo-600/20">
                        Join Channel →
                    </a>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const currentUserId = <?php echo json_encode(auth()->id(), 15, 512) ?>;
                
                // Fallback Engine: Explicitly read active channel if it exists in current Blade view scope context
                let activeChannelId = null;
                const urlParams = new URLSearchParams(window.location.search);
                
                if (urlParams.has('channel')) {
                    activeChannelId = urlParams.get('channel');
                } else if (typeof window.currentActiveChannelId !== 'undefined') {
                    activeChannelId = window.currentActiveChannelId;
                }

                if (window.Echo && currentUserId) {
                    window.Echo.private(`User.${currentUserId}`)
                        // Handles both .MessageSent and full namespace fallback string resolutions cleanly
                        .listen('.MessageSent', handleIncomingMessage)
                        .listen('MessageSent', handleIncomingMessage);
                }

                function handleIncomingMessage(e) {
                    // Safety check: Prevent ringing if the user is already actively reading this room's thread 
                    if (activeChannelId && (activeChannelId == e.message.channel_id || activeChannelId == e.message?.channel?.id)) {
                        return;
                    }

                    // 1. Fire audio node frame logic safely
                    const chime = document.getElementById('notification-sound');
                    if (chime) {
                        chime.currentTime = 0;
                        chime.play().catch(() => {
                            console.log('Audio autoplay prevented by user interaction loop restriction policy.');
                        });
                    }

                    // 2. Hydrate modal content selectors safely
                    document.getElementById('notif-room-name').innerText = `#${e.channel_name || e.message?.channel?.name || 'Workspace'}`;
                    document.getElementById('notif-sender').innerText = e.sender_name || e.message?.user?.name || 'Partner';
                    document.getElementById('notif-content').innerText = e.message.content;

                    // 3. Build dynamic redirection navigation target route fallback
                    const lobbyId = e.lobby_id || e.message?.channel?.lobby_id || '';
                    const channelId = e.message.channel_id || e.message?.channel?.id;
                    const roomUrl = `/chat?lobby=${lobbyId}&channel=${channelId}`;
                    
                    document.getElementById('notif-jump-link').setAttribute('href', roomUrl);

                    // 4. Reveal the Modal Layer
                    document.getElementById('global-notification-modal').classList.remove('hidden');
                }
            });

            function closeNotificationModal() {
                document.getElementById('global-notification-modal').classList.add('hidden');
            }
        </script>
    </body>
</html><?php /**PATH C:\Users\Pongo\Desktop\TEAMAP\TeaMap\resources\views/layouts/app.blade.php ENDPATH**/ ?>