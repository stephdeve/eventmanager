<style>
    /* Creative Light Background */
    .creative-light-bg {
        background:
            radial-gradient(ellipse at top left, rgba(79, 70, 229, 0.08) 0%, transparent 50%),
            radial-gradient(ellipse at bottom right, rgba(139, 92, 246, 0.06) 0%, transparent 50%),
            linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%);
        min-height: 100vh;
        position: relative;
        overflow: hidden;
    }

    /* Floating Bubbles Background */
    .floating-bubbles {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 0;
    }

    .bubble {
        position: absolute;
        border-radius: 50%;
        background:
            radial-gradient(circle,
                rgba(255, 255, 255, 0.9) 0%,
                rgba(255, 255, 255, 0.6) 50%,
                transparent 70%);
        box-shadow:
            0 8px 32px rgba(79, 70, 229, 0.1),
            inset 0 2px 4px rgba(255, 255, 255, 0.8);
        animation: bubbleFloat 8s ease-in-out infinite;
    }

    @keyframes bubbleFloat {

        0%,
        100% {
            transform: translateY(0px) translateX(0px) scale(1) rotate(0deg);
        }

        25% {
            transform: translateY(-20px) translateX(10px) scale(1.1) rotate(90deg);
        }

        50% {
            transform: translateY(-10px) translateX(-5px) scale(0.9) rotate(180deg);
        }

        75% {
            transform: translateY(-25px) translateX(8px) scale(1.05) rotate(270deg);
        }
    }

    /* Creative Chat Container */
    .creative-chat-container {
        background:
            linear-gradient(135deg,
                rgba(255, 255, 255, 0.95) 0%,
                rgba(255, 255, 255, 0.9) 100%);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 32px;
        box-shadow:
            0 25px 50px rgba(0, 0, 0, 0.08),
            0 15px 30px rgba(79, 70, 229, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.6);
        overflow: hidden;
        position: relative;
    }

    .creative-chat-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.4),
                transparent);
        transition: left 0.6s ease;
    }

    .creative-chat-container:hover::before {
        left: 100%;
    }

    /* Creative Header */
    .creative-header {
        background:
            linear-gradient(135deg, #4F46E5 0%, #6366f1 50%, #8B5CF6 100%);
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .creative-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.6),
                transparent);
        animation: headerShine 3s ease-in-out infinite;
    }

    @keyframes headerShine {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }

    .dancing-avatar {
        width: 80px;
        height: 80px;
        border-radius: 24px;
        background:
            linear-gradient(135deg, #F59E0B 0%, #fbbf24 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 800;
        color: white;
        box-shadow:
            0 15px 30px rgba(245, 158, 11, 0.3),
            0 8px 16px rgba(245, 158, 11, 0.2);
        animation: avatarDance 4s ease-in-out infinite;
        position: relative;
        overflow: hidden;
    }

    @keyframes avatarDance {

        0%,
        100% {
            transform: translateY(0px) rotate(0deg) scale(1);
        }

        25% {
            transform: translateY(-5px) rotate(2deg) scale(1.05);
        }

        50% {
            transform: translateY(0px) rotate(-1deg) scale(1);
        }

        75% {
            transform: translateY(-3px) rotate(1deg) scale(1.02);
        }
    }

    .dancing-avatar::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent);
        transform: rotate(45deg);
        animation: avatarShimmer 4s ease-in-out infinite;
    }

    @keyframes avatarShimmer {
        0% {
            transform: translateX(-100%) translateY(-100%) rotate(45deg);
        }

        100% {
            transform: translateX(100%) translateY(100%) rotate(45deg);
        }
    }

    /* Dancing Messages Area */
    .dancing-messages {
        height: 60vh;
        overflow-y: auto;
        padding: 2rem;
        background:
            linear-gradient(180deg,
                rgba(248, 250, 252, 0.9) 0%,
                rgba(241, 245, 249, 0.9) 100%);
        position: relative;
    }

    .dancing-messages::-webkit-scrollbar {
        width: 8px;
    }

    .dancing-messages::-webkit-scrollbar-track {
        background: rgba(226, 232, 240, 0.5);
        border-radius: 10px;
    }

    .dancing-messages::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #4F46E5 0%, #8B5CF6 100%);
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(79, 70, 229, 0.2);
    }

    /* Dancing Message Bubbles */
    .dancing-message {
        animation: messageDanceIn 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    @keyframes messageDanceIn {
        0% {
            opacity: 0;
            transform: translateY(20px) scale(0.9) rotateX(10deg);
        }

        100% {
            opacity: 1;
            transform: translateY(0) scale(1) rotateX(0deg);
        }
    }

    .dancing-own {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 1.5rem;
    }

    .dancing-bubble-own {
        max-width: 70%;
        background:
            linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
        color: white;
        padding: 1.25rem 1.5rem;
        border-radius: 24px;
        position: relative;
        overflow: hidden;
        box-shadow:
            0 12px 24px rgba(79, 70, 229, 0.2),
            0 6px 12px rgba(79, 70, 229, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        animation: bubbleDance 3s ease-in-out infinite;
    }

    @keyframes bubbleDance {

        0%,
        100% {
            transform: translateY(0px) scale(1);
        }

        50% {
            transform: translateY(-3px) scale(1.01);
        }
    }

    .dancing-bubble-own::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent);
        transition: left 0.6s ease;
    }

    .dancing-bubble-own:hover::before {
        left: 100%;
    }

    .dancing-bubble-own:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow:
            0 20px 40px rgba(79, 70, 229, 0.3),
            0 10px 20px rgba(79, 70, 229, 0.2);
    }

    .dancing-other {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .dancing-user-avatar {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        background:
            linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow:
            0 10px 20px rgba(79, 70, 229, 0.2),
            0 5px 10px rgba(79, 70, 229, 0.15);
        transition: all 0.3s ease;
        flex-shrink: 0;
        animation: avatarBounce 2s ease-in-out infinite;
    }

    @keyframes avatarBounce {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    .dancing-user-avatar:hover {
        transform: scale(1.1) rotate(5deg);
        animation: none;
    }

    .dancing-bubble-other {
        max-width: 70%;
        background: white;
        color: #1e293b;
        padding: 1.25rem 1.5rem;
        border-radius: 24px;
        box-shadow:
            0 8px 24px rgba(0, 0, 0, 0.08),
            0 4px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid #e2e8f0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        animation: otherBubbleDance 3s ease-in-out infinite 0.5s;
    }

    @keyframes otherBubbleDance {

        0%,
        100% {
            transform: translateY(0px) scale(1);
        }

        50% {
            transform: translateY(-2px) scale(1.005);
        }
    }

    .dancing-bubble-other:hover {
        transform: translateY(-3px) scale(1.01);
        box-shadow:
            0 15px 30px rgba(0, 0, 0, 0.12),
            0 6px 12px rgba(0, 0, 0, 0.06);
    }

    .message-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }

    .message-author {
        font-weight: 700;
        font-size: 0.95rem;
        color: inherit;
        opacity: 0.9;
    }

    .message-time {
        font-size: 0.8rem;
        opacity: 0.7;
    }

    .message-content {
        line-height: 1.6;
        word-wrap: break-word;
    }

    /* Creative Input Area */
    .creative-input {
        padding: 2rem;
        background: white;
        border-top: 1px solid #f1f5f9;
        position: relative;
    }

    .creative-input::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg,
                transparent,
                #4F46E5,
                transparent);
        opacity: 0.3;
    }

    .creative-input-wrapper {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 20px;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

 
    .creative-chat-input {
        flex: 1;
        background-color: none !important;
        border: none;
        outline: none;
        color: #1e293b;
        font-size: 1rem;
        font-weight: 500;
        padding: 1rem 1rem;
        font-family: inherit;
        border-radius: 16px;

    }

    .creative-chat-input::placeholder {
        color: #94a3b8;
    }

    .creative-chat-input:focus{
        border: none !important;
        box-shadow: none !important;
    }

    .dancing-send {
        background:
            linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 16px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
        box-shadow:
            0 8px 20px rgba(79, 70, 229, 0.2),
            0 4px 10px rgba(79, 70, 229, 0.15);
        animation: sendPulse 2s ease-in-out infinite;
    }

    @keyframes sendPulse {

        0%,
        100% {
            transform: scale(1);
            box-shadow:
                0 8px 20px rgba(79, 70, 229, 0.2),
                0 4px 10px rgba(79, 70, 229, 0.15);
        }

        50% {
            transform: scale(1.02);
            box-shadow:
                0 10px 25px rgba(79, 70, 229, 0.3),
                0 6px 15px rgba(79, 70, 229, 0.2);
        }
    }

    .dancing-send::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent);
        transition: left 0.5s ease;
    }

    .dancing-send:hover::before {
        left: 100%;
    }

    .dancing-send:hover {
        background:
            linear-gradient(135deg, #4338CA 0%, #5853DF 100%);
        transform: translateY(-3px) scale(1.05);
        animation: none;
        box-shadow:
            0 15px 30px rgba(79, 70, 229, 0.3),
            0 8px 16px rgba(79, 70, 229, 0.2);
    }

    .dancing-send:active {
        transform: translateY(0) scale(0.98);
    }

    /* Creative Back Button */
    .creative-back {
        background: white;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 0.75rem 1.5rem;
        border-radius: 16px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 600;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow:
            0 4px 12px rgba(0, 0, 0, 0.05),
            0 2px 6px rgba(0, 0, 0, 0.02);
        animation: backFloat 3s ease-in-out infinite;
    }

    @keyframes backFloat {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-2px);
        }
    }

    .creative-back::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg,
                transparent,
                rgba(79, 70, 229, 0.05),
                transparent);
        transition: left 0.5s ease;
    }

    .creative-back:hover::before {
        left: 100%;
    }

    .creative-back:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        transform: translateY(-3px) scale(1.02);
        animation: none;
        box-shadow:
            0 8px 24px rgba(0, 0, 0, 0.1),
            0 4px 12px rgba(0, 0, 0, 0.05);
    }

    /* Dancing Online Indicator */
    .dancing-online {
        background: white;
        border: 1px solid #dcfce7;
        padding: 0.75rem 1.5rem;
        border-radius: 16px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #15803d;
        font-weight: 600;
        box-shadow:
            0 4px 12px rgba(34, 197, 94, 0.1),
            0 2px 6px rgba(34, 197, 94, 0.05);
        animation: onlineGlow 2s ease-in-out infinite;
    }

    @keyframes onlineGlow {

        0%,
        100% {
            box-shadow:
                0 4px 12px rgba(34, 197, 94, 0.1),
                0 2px 6px rgba(34, 197, 94, 0.05);
        }

        50% {
            box-shadow:
                0 6px 18px rgba(34, 197, 94, 0.15),
                0 3px 9px rgba(34, 197, 94, 0.08);
        }
    }

    .online-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #22C55E;
        box-shadow: 0 0 15px rgba(34, 197, 94, 0.6);
        animation: dotPulse 2s ease-in-out infinite;
    }

    @keyframes dotPulse {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.2);
            opacity: 0.8;
        }
    }

    /* Creative Empty State */
    .creative-empty {
        text-align: center;
        padding: 4rem 2rem;
        animation: creativeFadeIn 1s ease-out;
    }

    @keyframes creativeFadeIn {
        0% {
            opacity: 0;
            transform: translateY(20px) scale(0.95);
        }

        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .creative-empty-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 2rem;
        border-radius: 28px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        box-shadow:
            0 12px 24px rgba(0, 0, 0, 0.05),
            0 6px 12px rgba(0, 0, 0, 0.02);
        animation: emptyIconDance 4s ease-in-out infinite;
    }

    @keyframes emptyIconDance {

        0%,
        100% {
            transform: translateY(0px) rotate(0deg);
        }

        25% {
            transform: translateY(-8px) rotate(2deg);
        }

        50% {
            transform: translateY(-4px) rotate(-1deg);
        }

        75% {
            transform: translateY(-6px) rotate(1deg);
        }
    }

    .creative-empty-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 0.75rem;
    }

    .creative-empty-desc {
        color: #64748b;
        font-size: 1.125rem;
        line-height: 1.6;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .creative-chat-container {
            border-radius: 20px;
            margin: 1rem;
        }

        .creative-header {
            padding: 1.5rem;
        }

        .dancing-avatar {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }

        .dancing-messages {
            padding: 1.5rem;
            height: 50vh;
        }

        .creative-input {
            padding: 1.5rem;
        }

        .dancing-bubble-own,
        .dancing-bubble-other {
            max-width: 85%;
            padding: 1rem 1.25rem;
        }

        .dancing-user-avatar {
            width: 48px;
            height: 48px;
            font-size: 1.25rem;
        }
    }

    /* Dark mode neutral overrides */
    .dark .creative-light-bg {
        background:
            radial-gradient(ellipse at top left, rgba(38, 38, 38, 0.6) 0%, transparent 50%),
            radial-gradient(ellipse at bottom right, rgba(23, 23, 23, 0.5) 0%, transparent 50%),
            linear-gradient(135deg, #0a0a0a 0%, #0f0f0f 50%, #171717 100%);
    }

    .dark .creative-chat-container {
        background: linear-gradient(135deg, rgba(10, 10, 10, 0.95) 0%, rgba(10, 10, 10, 0.9) 100%);
        border: 1px solid #262626;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.35);
    }

    .dark .dancing-bubble-other {
        background: #0a0a0a;
        color: #e5e5e5;
        border: 1px solid #262626;
    }

    .dark .creative-input {
        background: #0a0a0a;
        border-top: 1px solid #262626;
    }

    .dark .creative-input-wrapper {
        background: #0a0a0a;
        border: 2px solid #262626;
    }

    .dark .creative-input-wrapper:focus-within {
        background: #0f0f0f;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.2), 0 12px 32px rgba(79, 70, 229, 0.25);
    }

    .dark .creative-chat-input {
        color: #e5e5e5;
    }

    .dark .creative-chat-input::placeholder {
        color: #a3a3a3;
    }

    .dark .creative-back {
        background: #0a0a0a;
        border: 1px solid #262626;
        color: #a3a3a3;
    }

    .dark .creative-back:hover {
        background: #171717;
        border-color: #404040;
        color: #e5e5e5;
    }

    .dark .dancing-online {
        background: rgba(6, 95, 70, 0.08);
        border: 1px solid #064e3b;
        color: #34d399;
    }

    .dark .creative-empty-icon {
        background: #0a0a0a;
        color: #9ca3af;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.35), 0 6px 12px rgba(0, 0, 0, 0.25);
    }
</style>

<div class="min-h-screen py-8 bg-[#0B1220] text-slate-200 relative">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Enhanced Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-6">
                    <div class="event-avatar">
                        {{ mb_strtoupper(mb_substr($event->title, 0, 1, 'UTF-8'), 'UTF-8') }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $event->title }}</h1>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">Chat communautaire</p>
                    </div>
                </div>
                <div
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-300 dark:border-emerald-900/40">
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <span>En ligne: <span id="online-count" class="font-semibold">0</span></span>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('interactive.events.show', ['event' => $event->slug ?? $event->id]) }}"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border border-slate-200 text-slate-700 bg-white hover:bg-slate-50 transition-colors dark:bg-neutral-900 dark:border-neutral-800 dark:text-neutral-300 dark:hover:bg-neutral-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour à l'événement
                </a>
            </div>
        </div>

        @if ($readOnly)
            <div class="warning-banner"
                style="background: linear-gradient(135deg, #fef3c7 0%, #fef7cd 100%); border: 1px solid #fcd34d; border-radius: 16px; padding: 1.25rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem;">
                <svg class="warning-icon" style="width: 24px; height: 24px; color: #d97706;" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                <span class="text-amber-800 font-semibold">Conversation archivée - Lecture seule</span>
            </div>
        @endif

        <!-- Enhanced Chat Container -->
        <div class="chat-container">
            <!-- Enhanced Chat Header -->
            <div class="chat-header">
                <div class="flex items-center gap-4">
                    <div class="event-avatar" style="width: 48px; height: 48px; font-size: 1.25rem;">
                        {{ mb_strtoupper(mb_substr($event->title, 0, 1, 'UTF-8'), 'UTF-8') }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">{{ $event->title }}</h2>
                        <span class="text-slate-200 text-sm font-medium">Communauté de discussion en temps réel</span>
                    </div>
                </div>
            </div>

            <!-- Enhanced Messages Area -->
            <div id="messages" wire:ignore class="messages-area">
                @forelse($this->messages as $m)
                    @php $own = auth()->check() && auth()->id() === $m->user_id; @endphp
                    @if ($own)
                        <!-- Own Message -->
                        <div class="dancing-message flex justify-end mb-3">
                            <div
                                class="max-w-[70%] rounded-2xl px-4 py-3 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white shadow">
                                <div class="flex items-center justify-between gap-3 mb-1">
                                    <span
                                        class="text-xs font-medium opacity-90">{{ optional($m->user)->name ?? 'Vous' }}</span>
                                    <span
                                        class="text-xs opacity-75">{{ $m->created_at?->translatedFormat('d/m H:i') }}</span>
                                </div>
                                <div class="whitespace-pre-wrap break-words">{{ $m->message }}</div>
                            </div>
                        </div>
                    @else
                        <!-- Other Message -->
                        <div class="dancing-message flex items-start gap-3 mb-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-purple-600 text-white font-semibold flex items-center justify-center flex-shrink-0">
                                {{ mb_strtoupper(mb_substr(optional($m->user)->name ?? 'U', 0, 1, 'UTF-8'), 'UTF-8') }}
                            </div>
                            <div
                                class="max-w-[70%] rounded-2xl px-4 py-3 bg-white border border-slate-200 text-neutral-800 shadow-sm dark:bg-neutral-900 dark:border-neutral-800 dark:text-neutral-100">
                                <div class="flex items-center justify-between gap-3 mb-1">
                                    <span
                                        class="text-xs font-medium opacity-90">{{ optional($m->user)->name ?? 'Utilisateur' }}</span>
                                    <span
                                        class="text-xs opacity-70">{{ $m->created_at?->translatedFormat('d/m H:i') }}</span>
                                </div>
                                <div class="whitespace-pre-wrap break-words">{{ $m->message }}</div>
                            </div>
                        </div>
                    @endif
                @empty
                    <!-- Empty State -->
                    <div id="empty-state" class="text-center py-12">
                        <div
                            class="w-20 h-20 mx-auto mb-4 rounded-2xl bg-white border border-slate-200 text-neutral-400 flex items-center justify-center shadow-sm dark:bg-neutral-900 dark:border-neutral-800">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4-.8L3 20l.8-4A8.993 8.993 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Lancez la conversation
                            !</h3>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">Soyez le premier à partager un message
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- Input -->
            <div class="border-t border-slate-200 p-4 bg-white dark:border-neutral-800 dark:bg-neutral-900">
                <div
                    class="creative-input-wrapper flex items-center gap-3 rounded-xl border border-slate-300 bg-white dark:bg-neutral-900 dark:border-neutral-800 focus-within:ring-2 focus-within:ring-indigo-500">
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4-.8L3 20l.8-4A8.993 8.993 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <input
                        type="text"
                        wire:model="messageText"
                        placeholder="Écrivez votre message..."
                        class="chat-input"
                        @if($readOnly) disabled @endif
                    >
                    <button wire:click="send" class="send-button" @if($readOnly) disabled @endif>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Envoyer
                    </button>
                </div>
                @if ($readOnly)
                    <p class="mt-3 text-sm text-neutral-500 text-center font-medium dark:text-neutral-400">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Mode lecture seule activé
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced interactive mouse effects
    let mouseX = 0;
    let mouseY = 0;
    
    // Mouse glow trail removed for performance

    // Enhanced message animations
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                mutation.addedNodes.forEach(function(node) {
                    if (node.classList && node.classList.contains('message-bubble')) {
                        // Add entrance animation to new messages
                        node.style.animation = 'messageSlideIn 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                        
                        // Add pulse effect to new messages
                        setTimeout(() => {
                            node.style.animation = 'messagePulse 0.6s ease-out';
                            setTimeout(() => {
                                node.style.animation = '';
                            }, 600);
                        }, 500);
                    }
                });
            }
        });
    });

        // Add pop animation
        const popStyle = document.createElement('style');
        popStyle.textContent = `
        @keyframes messagePop {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    `;
        document.head.appendChild(popStyle);

        // Observe messages container
        const messagesContainer = document.getElementById('messages');
        if (messagesContainer) {
            observer.observe(messagesContainer, {
                childList: true,
                subtree: true
            });

            // Scroll to bottom initially
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Creative input interactions
        const creativeInput = document.querySelector('.creative-chat-input');
        const creativeWrapper = document.querySelector('.creative-input-wrapper');

        if (creativeInput && creativeWrapper) {
            creativeInput.addEventListener('focus', function() {
                creativeWrapper.style.transform = 'translateY(-3px)';
            });

            creativeInput.addEventListener('blur', function() {
                creativeWrapper.style.transform = 'translateY(0)';
            });

            // Typing indicator
            creativeInput.addEventListener('input', function() {
                if (this.value.length > 0) {
                    creativeWrapper.style.borderColor = '#4F46E5';
                } else {
                    creativeWrapper.style.borderColor = '#e2e8f0';
                }
            });
        }

        // Dancing send button effects
        const dancingSend = document.querySelector('.dancing-send');
        if (dancingSend) {
            dancingSend.addEventListener('click', function() {
                if (!this.disabled) {
                    // Create ripple effect
                    createRippleEffect(this);
                }
            });
        }

        // Ripple effect
        function createRippleEffect(element) {
            const ripple = document.createElement('div');
            const rect = element.getBoundingClientRect();

            ripple.style.position = 'fixed';
            ripple.style.left = rect.left + rect.width / 2 + 'px';
            ripple.style.top = rect.top + rect.height / 2 + 'px';
            ripple.style.width = '0px';
            ripple.style.height = '0px';
            ripple.style.background = 'radial-gradient(circle, rgba(79, 70, 229, 0.2) 0%, transparent 70%)';
            ripple.style.borderRadius = '50%';
            ripple.style.pointerEvents = 'none';
            ripple.style.zIndex = '9998';
            ripple.style.transform = 'translate(-50%, -50%)';
            ripple.style.animation = 'rippleExpand 0.6s ease-out forwards';

            document.body.appendChild(ripple);

            setTimeout(() => ripple.remove(), 600);
        }

        // Add ripple animation
        const rippleStyle = document.createElement('style');
        rippleStyle.textContent = `
        @keyframes rippleExpand {
            0% {
                width: 0px;
                height: 0px;
                opacity: 1;
            }
            100% {
                width: 200px;
                height: 200px;
                opacity: 0;
            }
        }
    `;
        document.head.appendChild(rippleStyle);

        // Enter key to send
        if (creativeInput) {
            creativeInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && !dancingSend.disabled) {
                    dancingSend.click();
                }
            });
        }

    // Add entrance animations to elements
    const elementsToAnimate = document.querySelectorAll('.chat-container, .back-button, .warning-banner');
    elementsToAnimate.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        element.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
        
        setTimeout(() => {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, 100 + (index * 200));
    });
});

// Add message pulse animation
const style = document.createElement('style');
style.textContent = `
    @keyframes messagePulse {
        0% {
            box-shadow: 0 12px 24px rgba(79, 70, 229, 0.3);
        }
        50% {
            box-shadow: 0 16px 32px rgba(79, 70, 229, 0.5);
        }
        100% {
            box-shadow: 0 12px 24px rgba(79, 70, 229, 0.3);
        }
    }
`;
document.head.appendChild(style);
</script>

<script>
// Real-time presence + message listener (Echo)
(function() {
    const eventId = {{ (int) $event->id }};
    const readOnly = @json($readOnly);
    const userId = Number(@json(Auth::id() ?? 0));
    const userName = @json(Auth::user()->name ?? 'Participant');

    function showToast(type, text) {
        const el = document.createElement('div');
        el.className = 'fixed right-4 bottom-4 z-50 px-4 py-3 rounded shadow text-white ' + (type === 'error' ? 'bg-red-600' : (type === 'warning' ? 'bg-amber-600' : 'bg-indigo-600'));
        el.textContent = text;
        document.body.appendChild(el);
        setTimeout(() => el.remove(), 4000);
    }

    const online = new Set();
    function updateOnlineCount() {
        const el = document.getElementById('online-count');
        if (el) el.textContent = String(online.size);
    }

    function esc(s) {
        return (s || '').toString().replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'}[c]));
    }

    function appendMessage(payload) {
        try {
            const container = document.getElementById('messages');
            if (!container) return;
            const empty = document.getElementById('empty-state');
            if (empty) empty.remove();

            const msg = (payload && payload.message) ? String(payload.message) : '';
            const author = (payload && payload.user && payload.user.name) ? String(payload.user.name) : 'Participant';
            const uid = Number(payload && payload.user && payload.user.id ? payload.user.id : 0);
            const isOwn = Number(uid) === Number(userId);
            const createdAt = payload && payload.created_at ? new Date(payload.created_at) : new Date();
            const timeStr = createdAt.toLocaleString();

            const wrapper = document.createElement('div');
            wrapper.className = (isOwn ? 'own-message' : 'other-message') + ' message-bubble';

            if (isOwn) {
                wrapper.innerHTML = `
                    <div class="own-bubble">
                        <div class="message-header">
                            <span class="message-author">${esc(author)}</span>
                            <span class="message-time">${esc(timeStr)}</span>
                        </div>
                        <div class="message-content">${esc(msg)}</div>
                    </div>
                `;
            } else {
                const initial = esc(author.charAt(0).toUpperCase());
                wrapper.innerHTML = `
                    <div class="user-avatar">${initial}</div>
                    <div class="other-bubble">
                        <div class="message-header">
                            <span class="message-author">${esc(author)}</span>
                            <span class="message-time">${esc(timeStr)}</span>
                        </div>
                        <div class="message-content">${esc(msg)}</div>
                    </div>
                `;
            }

            container.appendChild(wrapper);
            container.scrollTop = container.scrollHeight;
        } catch (e) {
            // ignore
        }
    }

    function setupPresence() {
        if (typeof Echo === 'undefined') {
            showToast('warning', 'Temps réel indisponible (Echo non initialisé).');
            return;
        }
        try {
            Echo.join(`event.${eventId}`)
                .here((users) => {
                    online.clear();
                    (users || []).forEach(u => online.add(Number(u.id)));
                    updateOnlineCount();
                })
                .joining((user) => {
                    if (user && typeof user.id !== 'undefined') {
                        online.add(Number(user.id));
                        updateOnlineCount();
                    }
                })
                .leaving((user) => {
                    if (user && typeof user.id !== 'undefined') {
                        online.delete(Number(user.id));
                        updateOnlineCount();
                    }
                })
                .listen('.message.sent', (e) => {
                    appendMessage(e);
                });
        } catch (e) {
            showToast('error', 'Impossible de rejoindre le canal en temps réel.');
        }
    }

    const chatInput = document.querySelector('.chat-input');
    const sendBtn = document.querySelector('.send-button');

    // Enter to send
    if (chatInput) {
        chatInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey && !readOnly) {
                e.preventDefault();
                sendBtn?.click();
            }
        });
    }

    // Listen to Livewire-dispatched toasts
    window.addEventListener('toast', (e) => {
        const d = e.detail || {};
        if (d.message) showToast(d.type || 'info', d.message);
    });

    // Append locally when Livewire confirms save (fallback if Echo is down)
    window.addEventListener('message-sent', (e) => {
        try {
            const payload = (e && e.detail) ? e.detail.message || e.detail : null;
            if (payload) appendMessage(payload);
        } catch (_) {}
    });

    setupPresence();
})();
</script>
