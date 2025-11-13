<style>
/* Enhanced Animated Background System */
.community-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: 
        radial-gradient(ellipse at top left, rgba(79, 70, 229, 0.15) 0%, transparent 50%),
        radial-gradient(ellipse at bottom right, rgba(139, 92, 246, 0.15) 0%, transparent 50%),
        radial-gradient(ellipse at center, rgba(236, 72, 153, 0.1) 0%, transparent 50%),
        linear-gradient(135deg, #0a0a0f 0%, #1a1a2e 50%, #16213e 100%);
    z-index: -2;
}

.community-background::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: 
        linear-gradient(135deg, rgba(79, 70, 229, 0.2) 0%, transparent 30%),
        linear-gradient(225deg, rgba(139, 92, 246, 0.2) 0%, transparent 30%),
        linear-gradient(45deg, rgba(236, 72, 153, 0.15) 0%, transparent 40%);
    animation: backgroundPulse 8s ease-in-out infinite;
}

@keyframes backgroundPulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* Enhanced Floating Elements */
.floating-element {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.3;
    animation: complexFloat 15s ease-in-out infinite;
    mix-blend-mode: screen;
}

.float-1 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(79, 70, 229, 0.8) 0%, rgba(99, 102, 241, 0.4) 50%, transparent 70%);
    top: -10%;
    left: -10%;
    animation-delay: 0s;
    animation-duration: 20s;
}

.float-2 {
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(139, 92, 246, 0.8) 0%, rgba(167, 139, 250, 0.4) 50%, transparent 70%);
    top: 40%;
    right: -5%;
    animation-delay: 5s;
    animation-duration: 25s;
}

.float-3 {
    width: 350px;
    height: 350px;
    background: radial-gradient(circle, rgba(236, 72, 153, 0.8) 0%, rgba(244, 114, 182, 0.4) 50%, transparent 70%);
    bottom: -5%;
    left: 20%;
    animation-delay: 10s;
    animation-duration: 22s;
}

@keyframes complexFloat {
    0%, 100% {
        transform: translateY(0px) translateX(0px) scale(1) rotate(0deg);
    }
    25% {
        transform: translateY(-40px) translateX(30px) scale(1.15) rotate(90deg);
    }
    50% {
        transform: translateY(-20px) translateX(-15px) scale(0.85) rotate(180deg);
    }
    75% {
        transform: translateY(-50px) translateX(20px) scale(1.1) rotate(270deg);
    }
}

/* Enhanced Particle System */
.chat-particles {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    pointer-events: none;
}

.chat-particle {
    position: absolute;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.4) 50%, transparent 70%);
    border-radius: 50%;
    animation: particleFloat 25s linear infinite;
    box-shadow: 0 0 15px rgba(255, 255, 255, 0.6);
}

@keyframes particleFloat {
    0% {
        transform: translateY(100vh) translateX(0px) rotate(0deg) scale(0);
        opacity: 0;
    }
    10% {
        transform: translateY(80vh) translateX(20px) rotate(36deg) scale(1);
        opacity: 1;
    }
    90% {
        transform: translateY(20vh) translateX(-20px) rotate(324deg) scale(1);
        opacity: 1;
    }
    100% {
        transform: translateY(0vh) translateX(0px) rotate(360deg) scale(0);
        opacity: 0;
    }
}

/* Interactive Light Orbs */
.light-orb {
    position: absolute;
    width: 8px;
    height: 8px;
    background: radial-gradient(circle, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0.6) 40%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
    animation: orbFloat 30s linear infinite;
    box-shadow: 
        0 0 25px rgba(255, 255, 255, 0.9),
        0 0 50px rgba(255, 255, 255, 0.5),
        0 0 75px rgba(255, 255, 255, 0.3);
}

@keyframes orbFloat {
    0% {
        transform: translateY(100vh) translateX(0px) scale(0);
        opacity: 0;
    }
    10% {
        transform: translateY(80vh) translateX(10px) scale(1);
        opacity: 1;
    }
    90% {
        transform: translateY(20vh) translateX(-10px) scale(1);
        opacity: 1;
    }
    100% {
        transform: translateY(-100vh) translateX(30px) scale(0);
        opacity: 0;
    }
}

/* Chat Container with Enhanced Glassmorphism */
.chat-container {
    background: 
        linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.08) 100%),
        rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(30px) saturate(200%);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 32px;
    overflow: hidden;
    box-shadow: 
        0 40px 80px rgba(0, 0, 0, 0.4),
        0 20px 40px rgba(79, 70, 229, 0.15),
        inset 0 1px 0 rgba(255, 255, 255, 0.3);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    animation: chatEntrance 1.2s ease-out;
}

@keyframes chatEntrance {
    0% {
        opacity: 0;
        transform: translateY(60px) scale(0.9) rotateX(15deg);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1) rotateX(0deg);
    }
}

.chat-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.6), transparent);
    animation: topShimmer 4s ease-in-out infinite;
}

@keyframes topShimmer {
    0%, 100% { opacity: 0.3; }
    50% { opacity: 0.8; }
}

/* Enhanced Header */
.chat-header {
    background: 
        linear-gradient(135deg, rgba(79, 70, 229, 0.95) 0%, rgba(99, 102, 241, 0.9) 50%, rgba(139, 92, 246, 0.85) 100%);
    backdrop-filter: blur(20px);
    padding: 2rem;
    position: relative;
    overflow: hidden;
}

.chat-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: 
        linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.2), transparent),
        linear-gradient(-45deg, transparent, rgba(255, 255, 255, 0.15), transparent);
    transform: rotate(45deg);
    animation: headerShimmer 5s ease-in-out infinite;
}

@keyframes headerShimmer {
    0% {
        transform: translateX(-100%) translateY(-100%) rotate(45deg);
    }
    50% {
        transform: translateX(50%) translateY(50%) rotate(45deg);
    }
    100% {
        transform: translateX(100%) translateY(100%) rotate(45deg);
    }
}

.event-avatar {
    width: 64px;
    height: 64px;
    border-radius: 20px;
    background: 
        linear-gradient(135deg, #4F46E5 0%, #6366F1 50%, #8B5CF6 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 800;
    color: white;
    box-shadow: 
        0 12px 24px rgba(79, 70, 229, 0.4),
        0 6px 12px rgba(79, 70, 229, 0.2);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.event-avatar::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transform: rotate(45deg);
    animation: avatarShimmer 3s ease-in-out infinite;
}

@keyframes avatarShimmer {
    0% {
        transform: translateX(-100%) translateY(-100%) rotate(45deg);
    }
    100% {
        transform: translateX(100%) translateY(100%) rotate(45deg);
    }
}

.event-title {
    font-size: 1.75rem;
    font-weight: 800;
    color: white;
    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    animation: titleGlow 3s ease-in-out infinite alternate;
}

@keyframes titleGlow {
    0% { text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3), 0 0 20px rgba(255, 255, 255, 0.3); }
    100% { text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3), 0 0 40px rgba(255, 255, 255, 0.6); }
}

.online-indicator {
    background: 
        linear-gradient(135deg, rgba(34, 197, 94, 0.2) 0%, rgba(34, 197, 94, 0.1) 100%);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(34, 197, 94, 0.4);
    padding: 0.75rem 1.5rem;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    transition: all 0.3s ease;
}

.online-indicator:hover {
    background: 
        linear-gradient(135deg, rgba(34, 197, 94, 0.3) 0%, rgba(34, 197, 94, 0.15) 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(34, 197, 94, 0.2);
}

.online-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #22C55E;
    box-shadow: 0 0 20px rgba(34, 197, 94, 0.8);
    animation: onlinePulse 2s ease-in-out infinite;
}

@keyframes onlinePulse {
    0%, 100% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.2);
        opacity: 0.7;
    }
}

/* Enhanced Messages Area */
.messages-area {
    height: 60vh;
    overflow-y: auto;
    padding: 2rem;
    background: 
        linear-gradient(180deg, rgba(10, 10, 15, 0.8) 0%, rgba(26, 26, 46, 0.8) 100%);
    position: relative;
}

.messages-area::-webkit-scrollbar {
    width: 8px;
}

.messages-area::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
}

.messages-area::-webkit-scrollbar-thumb {
    background: 
        linear-gradient(135deg, rgba(79, 70, 229, 0.6) 0%, rgba(139, 92, 246, 0.6) 100%);
    border-radius: 10px;
    transition: all 0.3s ease;
}

.messages-area::-webkit-scrollbar-thumb:hover {
    background: 
        linear-gradient(135deg, rgba(79, 70, 229, 0.8) 0%, rgba(139, 92, 246, 0.8) 100%);
}

/* Enhanced Message Bubbles */
.message-bubble {
    animation: messageSlideIn 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    transition: all 0.3s ease;
}

@keyframes messageSlideIn {
    0% {
        opacity: 0;
        transform: translateY(20px) scale(0.9);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.own-message {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 1.5rem;
}

.own-bubble {
    max-width: 85%;
    background: 
        linear-gradient(135deg, #4F46E5 0%, #6366F1 50%, #8B5CF6 100%);
    color: white;
    padding: 1rem 1.5rem;
    border-radius: 24px;
    box-shadow: 
        0 12px 24px rgba(79, 70, 229, 0.3),
        0 6px 12px rgba(79, 70, 229, 0.2);
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.own-bubble::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s ease;
}

.own-bubble:hover::before {
    left: 100%;
}

.own-bubble:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 
        0 16px 32px rgba(79, 70, 229, 0.4),
        0 8px 16px rgba(79, 70, 229, 0.3);
}

.other-message {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.user-avatar {
    width: 48px;
    height: 48px;
    border-radius: 16px;
    background: 
        linear-gradient(135deg, #4F46E5 0%, #6366F1 50%, #8B5CF6 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    font-weight: 700;
    color: white;
    box-shadow: 0 8px 16px rgba(79, 70, 229, 0.3);
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.user-avatar:hover {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 12px 24px rgba(79, 70, 229, 0.4);
}

.other-bubble {
    max-width: 85%;
    background: 
        linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.08) 100%),
        rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    padding: 1rem 1.5rem;
    border-radius: 24px;
    box-shadow: 
        0 8px 16px rgba(0, 0, 0, 0.2),
        0 4px 8px rgba(79, 70, 229, 0.1);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.other-bubble:hover {
    background: 
        linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.12) 100%),
        rgba(255, 255, 255, 0.08);
    transform: translateY(-2px) scale(1.02);
    box-shadow: 
        0 12px 24px rgba(0, 0, 0, 0.3),
        0 6px 12px rgba(79, 70, 229, 0.2);
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
    color: rgba(255, 255, 255, 0.95);
}

.message-time {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.7);
}

.message-content {
    line-height: 1.6;
    word-wrap: break-word;
}

/* Enhanced Input Area */
.input-area {
    padding: 2rem;
    background: 
        linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.04) 100%),
        rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(20px);
    border-top: 1px solid rgba(255, 255, 255, 0.15);
}

.input-wrapper {
    background: 
        linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.08) 100%),
        rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(15px);
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.input-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.6s ease;
}

.input-wrapper:focus-within::before {
    left: 100%;
}

.input-wrapper:focus-within {
    border-color: rgba(79, 70, 229, 0.6);
    background: 
        linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.1) 100%),
        rgba(255, 255, 255, 0.08);
    box-shadow: 
        0 0 0 4px rgba(79, 70, 229, 0.2),
        0 8px 32px rgba(79, 70, 229, 0.15);
    transform: translateY(-2px);
}

.chat-input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    color: white;
    font-size: 1rem;
    font-weight: 500;
    padding: 0.5rem 1rem;
}

.chat-input::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.send-button {
    background: 
        linear-gradient(135deg, #4F46E5 0%, #6366F1 50%, #8B5CF6 100%);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 16px;
    font-weight: 700;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    position: relative;
    overflow: hidden;
}

.send-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.5s ease;
}

.send-button:hover::before {
    left: 100%;
}

.send-button:hover {
    background: 
        linear-gradient(135deg, #4338CA 0%, #5853DF 50%, #7C3AED 100%);
    transform: translateY(-2px) scale(1.05);
    box-shadow: 
        0 12px 24px rgba(79, 70, 229, 0.4),
        0 6px 12px rgba(79, 70, 229, 0.3);
}

.send-button:active {
    transform: translateY(0) scale(0.98);
}

/* Enhanced Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    animation: emptyStateFadeIn 1s ease-out;
}

@keyframes emptyStateFadeIn {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.empty-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 2rem;
    border-radius: 24px;
    background: 
        linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255, 255, 255, 0.7);
    animation: emptyIconFloat 3s ease-in-out infinite;
}

@keyframes emptyIconFloat {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 0.5rem;
}

.empty-description {
    color: rgba(255, 255, 255, 0.6);
    font-size: 1rem;
}

/* Enhanced Back Button */
.back-button {
    background: 
        linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.08) 100%),
        rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 16px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.back-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.5s ease;
}

.back-button:hover::before {
    left: 100%;
}

.back-button:hover {
    background: 
        linear-gradient(135deg, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0.15) 100%);
    transform: translateY(-2px) scale(1.02);
    box-shadow: 
        0 12px 24px rgba(0, 0, 0, 0.3),
        0 6px 12px rgba(255, 255, 255, 0.1);
}

/* Warning Banner */
.warning-banner {
    background: 
        linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(245, 158, 11, 0.1) 100%);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(245, 158, 11, 0.4);
    border-radius: 20px;
    padding: 1.25rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    animation: warningSlideIn 0.6s ease-out;
}

@keyframes warningSlideIn {
    0% {
        opacity: 0;
        transform: translateY(-20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.warning-icon {
    width: 24px;
    height: 24px;
    color: #F59E0B;
    animation: warningPulse 2s ease-in-out infinite;
}

@keyframes warningPulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}

/* Responsive Design */
@media (max-width: 768px) {
    .chat-container {
        border-radius: 20px;
        margin: 1rem;
    }
    
    .chat-header {
        padding: 1.5rem;
    }
    
    .event-avatar {
        width: 48px;
        height: 48px;
        font-size: 1.25rem;
    }
    
    .event-title {
        font-size: 1.25rem;
    }
    
    .messages-area {
        padding: 1rem;
        height: 50vh;
    }
    
    .input-area {
        padding: 1rem;
    }
    
    .own-bubble, .other-bubble {
        max-width: 90%;
        padding: 0.75rem 1rem;
    }
    
    .user-avatar {
        width: 36px;
        height: 36px;
        font-size: 1rem;
    }
}

/* Loading Animation */
.loading-dots {
    display: inline-flex;
    gap: 0.25rem;
}

.loading-dots span {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.8);
    animation: loadingDot 1.4s ease-in-out infinite;
}

.loading-dots span:nth-child(1) { animation-delay: 0s; }
.loading-dots span:nth-child(2) { animation-delay: 0.2s; }
.loading-dots span:nth-child(3) { animation-delay: 0.4s; }

@keyframes loadingDot {
    0%, 80%, 100% {
        transform: scale(0.8);
        opacity: 0.5;
    }
    40% {
        transform: scale(1.2);
        opacity: 1;
    }
}
</style>

<div class="min-h-screen py-8 bg-[#0B1220] text-slate-200 relative">
    <!-- Enhanced Animated Background -->
    <div class="community-background">
        <div class="floating-element float-1"></div>
        <div class="floating-element float-2"></div>
        <div class="floating-element float-3"></div>
        
        <!-- Enhanced Particle System -->
        <div class="chat-particles">
            <div class="chat-particle" style="width: 8px; height: 8px; left: 5%; animation-delay: 0s; animation-duration: 20s;"></div>
            <div class="chat-particle" style="width: 6px; height: 6px; left: 15%; animation-delay: 4s; animation-duration: 25s;"></div>
            <div class="chat-particle" style="width: 10px; height: 10px; left: 25%; animation-delay: 8s; animation-duration: 18s;"></div>
            <div class="chat-particle" style="width: 4px; height: 4px; left: 35%; animation-delay: 12s; animation-duration: 30s;"></div>
            <div class="chat-particle" style="width: 7px; height: 7px; left: 45%; animation-delay: 16s; animation-duration: 22s;"></div>
            <div class="chat-particle" style="width: 9px; height: 9px; left: 55%; animation-delay: 20s; animation-duration: 19s;"></div>
            <div class="chat-particle" style="width: 5px; height: 5px; left: 65%; animation-delay: 24s; animation-duration: 26s;"></div>
            <div class="chat-particle" style="width: 8px; height: 8px; left: 75%; animation-delay: 28s; animation-duration: 21s;"></div>
            <div class="chat-particle" style="width: 6px; height: 6px; left: 85%; animation-delay: 32s; animation-duration: 24s;"></div>
            <div class="chat-particle" style="width: 7px; height: 7px; left: 95%; animation-delay: 36s; animation-duration: 23s;"></div>
        </div>

        <!-- Interactive Light Orbs -->
        <div class="light-orb" style="left: 10%; animation-delay: 0s; animation-duration: 35s;"></div>
        <div class="light-orb" style="left: 30%; animation-delay: 10s; animation-duration: 40s;"></div>
        <div class="light-orb" style="left: 50%; animation-delay: 20s; animation-duration: 32s;"></div>
        <div class="light-orb" style="left: 70%; animation-delay: 5s; animation-duration: 38s;"></div>
        <div class="light-orb" style="left: 90%; animation-delay: 15s; animation-duration: 30s;"></div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Enhanced Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-6">
                    <div class="event-avatar">
                        {{ mb_strtoupper(mb_substr($event->title, 0, 1, 'UTF-8'), 'UTF-8') }}
                    </div>
                    <div>
                        <h1 class="event-title">
                            {{ $event->title }}
                        </h1>
                        <p class="text-slate-300 text-lg mt-1 font-medium">Communauté de l'événement</p>
                    </div>
                </div>

                <div class="online-indicator">
                    <div class="online-dot"></div>
                    <span class="text-white font-semibold">Participants en ligne: <span id="online-count" class="font-bold">0</span></span>
                </div>
            </div>

            <div>
                <a href="{{ route('interactive.events.show', ['event' => $event->slug ?? $event->id]) }}" class="back-button">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour à l'événement
                </a>
            </div>
        </div>

        @if($readOnly)
            <div class="warning-banner">
                <svg class="warning-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
                <span class="text-amber-200 font-medium">La communauté de cet événement est désormais clôturée. Merci pour votre participation !</span>
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
            <div id="messages" wire:poll.2s="refreshMessages" class="messages-area">
                @forelse($this->messages as $m)
                    @php $own = auth()->check() && auth()->id() === $m->user_id; @endphp
                    @if($own)
                        <!-- Enhanced Own Message -->
                        <div class="own-message message-bubble">
                            <div class="own-bubble">
                                <div class="message-header">
                                    <span class="message-author">{{ optional($m->user)->name ?? 'Participant' }}</span>
                                    <span class="message-time">{{ $m->created_at?->translatedFormat('d/m H:i') }}</span>
                                </div>
                                <div class="message-content">{{ $m->message }}</div>
                            </div>
                        </div>
                    @else
                        <!-- Enhanced Other Message -->
                        <div class="other-message message-bubble">
                            <div class="user-avatar">
                                {{ mb_strtoupper(mb_substr(optional($m->user)->name ?? 'P', 0, 1, 'UTF-8'), 'UTF-8') }}
                            </div>
                            <div class="other-bubble">
                                <div class="message-header">
                                    <span class="message-author">{{ optional($m->user)->name ?? 'Participant' }}</span>
                                    <span class="message-time">{{ $m->created_at?->translatedFormat('d/m H:i') }}</span>
                                </div>
                                <div class="message-content">{{ $m->message }}</div>
                            </div>
                        </div>
                    @endif
                @empty
                    <!-- Enhanced Empty State -->
                    <div id="empty-state" class="empty-state">
                        <div class="empty-icon">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4-.8L3 20l.8-4A8.993 8.993 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <h3 class="empty-title">Démarrez la conversation !</h3>
                        <p class="empty-description">Soyez le premier à envoyer un message dans cette communauté</p>
                    </div>
                @endforelse
            </div>

            <!-- Enhanced Input Area -->
            <div class="input-area">
                <div class="input-wrapper">
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4-.8L3 20l.8-4A8.993 8.993 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <input
                        type="text"
                        wire:model.defer="messageText"
                        placeholder="Écrivez votre message..."
                        class="chat-input"
                        @if($readOnly) disabled @endif
                    >
                    <button wire:click="sendMessage" class="send-button" @if($readOnly) disabled @endif>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Envoyer
                    </button>
                </div>
                @if($readOnly)
                    <p class="mt-3 text-sm text-slate-400 text-center">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Lecture seule: l'événement est terminé
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
    
    document.addEventListener('mousemove', function(e) {
        mouseX = e.clientX;
        mouseY = e.clientY;
        
        // Create interactive glow trail
        const glow = document.createElement('div');
        glow.style.position = 'fixed';
        glow.style.left = mouseX + 'px';
        glow.style.top = mouseY + 'px';
        glow.style.width = '15px';
        glow.style.height = '15px';
        glow.style.background = 'radial-gradient(circle, rgba(139, 92, 246, 0.4) 0%, transparent 70%)';
        glow.style.borderRadius = '50%';
        glow.style.pointerEvents = 'none';
        glow.style.transform = 'translate(-50%, -50%)';
        glow.style.transition = 'all 1.5s ease-out';
        glow.style.zIndex = '9998';
        
        document.body.appendChild(glow);
        
        setTimeout(() => {
            glow.style.width = '80px';
            glow.style.height = '80px';
            glow.style.opacity = '0';
        }, 10);
        
        setTimeout(() => {
            glow.remove();
        }, 1500);
    });

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

    // Observe messages container for new messages
    const messagesContainer = document.getElementById('messages');
    if (messagesContainer) {
        observer.observe(messagesContainer, {
            childList: true,
            subtree: true
        });
    }

    // Enhanced input interactions
    const chatInput = document.querySelector('.chat-input');
    const inputWrapper = document.querySelector('.input-wrapper');
    
    if (chatInput && inputWrapper) {
        chatInput.addEventListener('focus', function() {
            inputWrapper.style.transform = 'translateY(-2px) scale(1.01)';
        });
        
        chatInput.addEventListener('blur', function() {
            inputWrapper.style.transform = 'translateY(0) scale(1)';
        });

        // Typing indicator effect
        chatInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                inputWrapper.style.borderColor = 'rgba(139, 92, 246, 0.6)';
            } else {
                inputWrapper.style.borderColor = 'rgba(255, 255, 255, 0.2)';
            }
        });
    }

    // Enhanced send button interactions
    const sendButton = document.querySelector('.send-button');
    if (sendButton) {
        sendButton.addEventListener('click', function() {
            // Add click ripple effect
            const ripple = document.createElement('div');
            ripple.style.position = 'absolute';
            ripple.style.top = '50%';
            ripple.style.left = '50%';
            ripple.style.width = '0';
            ripple.style.height = '0';
            ripple.style.background = 'radial-gradient(circle, rgba(255, 255, 255, 0.4) 0%, transparent 70%)';
            ripple.style.borderRadius = '50%';
            ripple.style.transform = 'translate(-50%, -50%)';
            ripple.style.transition = 'all 0.6s ease';
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.style.width = '100px';
                ripple.style.height = '100px';
                ripple.style.opacity = '0';
            }, 10);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
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
