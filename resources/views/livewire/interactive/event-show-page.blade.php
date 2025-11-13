<style>
/* Enhanced Animated Background System */
.event-background {
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

.event-background::before {
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
    animation: complexFloat 18s ease-in-out infinite;
    mix-blend-mode: screen;
}

.float-1 {
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(79, 70, 229, 0.8) 0%, rgba(99, 102, 241, 0.4) 50%, transparent 70%);
    top: -15%;
    left: -15%;
    animation-delay: 0s;
    animation-duration: 25s;
}

.float-2 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(139, 92, 246, 0.8) 0%, rgba(167, 139, 250, 0.4) 50%, transparent 70%);
    top: 35%;
    right: -10%;
    animation-delay: 7s;
    animation-duration: 30s;
}

.float-3 {
    width: 450px;
    height: 450px;
    background: radial-gradient(circle, rgba(236, 72, 153, 0.8) 0%, rgba(244, 114, 182, 0.4) 50%, transparent 70%);
    bottom: -10%;
    left: 25%;
    animation-delay: 14s;
    animation-duration: 28s;
}

.float-4 {
    width: 350px;
    height: 350px;
    background: radial-gradient(circle, rgba(34, 197, 94, 0.6) 0%, rgba(134, 239, 172, 0.3) 50%, transparent 70%);
    top: 25%;
    left: 40%;
    animation-delay: 21s;
    animation-duration: 22s;
}

@keyframes complexFloat {
    0%, 100% {
        transform: translateY(0px) translateX(0px) scale(1) rotate(0deg);
    }
    25% {
        transform: translateY(-50px) translateX(40px) scale(1.2) rotate(90deg);
    }
    50% {
        transform: translateY(-25px) translateX(-20px) scale(0.8) rotate(180deg);
    }
    75% {
        transform: translateY(-60px) translateX(30px) scale(1.15) rotate(270deg);
    }
}

/* Enhanced Particle System */
.event-particles {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    pointer-events: none;
}

.event-particle {
    position: absolute;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.4) 50%, transparent 70%);
    border-radius: 50%;
    animation: particleFloat 30s linear infinite;
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.6);
}

@keyframes particleFloat {
    0% {
        transform: translateY(100vh) translateX(0px) rotate(0deg) scale(0);
        opacity: 0;
    }
    10% {
        transform: translateY(80vh) translateX(30px) rotate(36deg) scale(1);
        opacity: 1;
    }
    90% {
        transform: translateY(20vh) translateX(-30px) rotate(324deg) scale(1);
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
    width: 10px;
    height: 10px;
    background: radial-gradient(circle, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0.6) 40%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
    animation: orbFloat 35s linear infinite;
    box-shadow: 
        0 0 30px rgba(255, 255, 255, 0.9),
        0 0 60px rgba(255, 255, 255, 0.5),
        0 0 90px rgba(255, 255, 255, 0.3);
}

@keyframes orbFloat {
    0% {
        transform: translateY(100vh) translateX(0px) scale(0);
        opacity: 0;
    }
    10% {
        transform: translateY(80vh) translateX(15px) scale(1);
        opacity: 1;
    }
    90% {
        transform: translateY(20vh) translateX(-15px) scale(1);
        opacity: 1;
    }
    100% {
        transform: translateY(-100vh) translateX(40px) scale(0);
        opacity: 0;
    }
}

/* Enhanced Event Container */
.event-container {
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
    animation: eventEntrance 1.5s ease-out;
}

@keyframes eventEntrance {
    0% {
        opacity: 0;
        transform: translateY(80px) scale(0.9) rotateX(20deg);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1) rotateX(0deg);
    }
}

.event-container::before {
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

/* Enhanced Hero Section */
.hero-section {
    position: relative;
    border-radius: 32px;
    overflow: hidden;
    margin-bottom: 3rem;
    animation: heroFloat 6s ease-in-out infinite;
}

@keyframes heroFloat {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    filter: brightness(0.7);
    transition: all 0.8s ease;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: 
        linear-gradient(135deg, rgba(79, 70, 229, 0.8) 0%, rgba(139, 92, 246, 0.6) 50%, rgba(236, 72, 153, 0.4) 100%);
    backdrop-filter: blur(5px);
    animation: heroOverlayPulse 4s ease-in-out infinite;
}

@keyframes heroOverlayPulse {
    0%, 100% { opacity: 0.9; }
    50% { opacity: 0.7; }
}

.hero-content {
    position: relative;
    padding: 6rem 4rem;
    text-align: center;
    z-index: 2;
}

.event-title {
    font-size: 4rem;
    font-weight: 900;
    color: white;
    text-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
    margin-bottom: 1.5rem;
    animation: titleGlow 3s ease-in-out infinite alternate;
    letter-spacing: -0.02em;
}

@keyframes titleGlow {
    0% { text-shadow: 0 8px 16px rgba(0, 0, 0, 0.4), 0 0 30px rgba(255, 255, 255, 0.3); }
    100% { text-shadow: 0 8px 16px rgba(0, 0, 0, 0.4), 0 0 50px rgba(255, 255, 255, 0.6); }
}

.event-description {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    max-width: 4xl;
    margin: 0 auto;
    line-height: 1.6;
    font-weight: 500;
}

/* Enhanced Navigation Tabs */
.navigation-tabs {
    display: flex;
    gap: 1rem;
    margin-bottom: 3rem;
    background: 
        linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
    backdrop-filter: blur(15px);
    padding: 0.5rem;
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.15);
}

.tab-button {
    flex: 1;
    background: transparent;
    border: none;
    padding: 1rem 1.5rem;
    border-radius: 16px;
    font-weight: 700;
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.7);
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.tab-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.6s ease;
}

.tab-button:hover::before {
    left: 100%;
}

.tab-button:hover {
    color: rgba(255, 255, 255, 0.9);
    background: rgba(255, 255, 255, 0.05);
}

.tab-button.active {
    background: 
        linear-gradient(135deg, #4F46E5 0%, #6366F1 50%, #8B5CF6 100%);
    color: white;
    box-shadow: 
        0 12px 24px rgba(79, 70, 229, 0.3),
        0 6px 12px rgba(79, 70, 229, 0.2);
    transform: translateY(-2px);
}

/* Enhanced Content Cards */
.content-card {
    background: 
        linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.08) 100%),
        rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 24px;
    padding: 2rem;
    margin-bottom: 2rem;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    animation: cardEntrance 0.8s ease-out;
}

@keyframes cardEntrance {
    0% {
        opacity: 0;
        transform: translateY(40px) scale(0.95);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.content-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
    transition: left 0.8s ease;
}

.content-card:hover::before {
    left: 100%;
}

.content-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 
        0 30px 60px rgba(0, 0, 0, 0.3),
        0 15px 30px rgba(79, 70, 229, 0.2),
        inset 0 1px 0 rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.3);
}

.card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.card-icon {
    width: 48px;
    height: 48px;
    border-radius: 16px;
    background: 
        linear-gradient(135deg, #4F46E5 0%, #6366F1 50%, #8B5CF6 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    box-shadow: 0 8px 16px rgba(79, 70, 229, 0.3);
    transition: all 0.3s ease;
}

.card-icon:hover {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 12px 24px rgba(79, 70, 229, 0.4);
}

.card-title {
    font-size: 1.5rem;
    font-weight: 800;
    color: white;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

/* Enhanced Video Container */
.video-container {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    background: #000;
    box-shadow: 0 16px 32px rgba(0, 0, 0, 0.4);
    transition: all 0.4s ease;
}

.video-container:hover {
    transform: scale(1.02);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
}

.video-container iframe {
    width: 100%;
    height: 100%;
    border: none;
}

.video-label {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background: 
        linear-gradient(135deg, rgba(79, 70, 229, 0.9) 0%, rgba(139, 92, 246, 0.8) 100%);
    backdrop-filter: blur(10px);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.9rem;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    animation: videoLabelPulse 2s ease-in-out infinite;
}

@keyframes videoLabelPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* Enhanced Voting Panel */
.voting-panel {
    background: 
        linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(34, 197, 94, 0.05) 100%);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(34, 197, 94, 0.3);
    border-radius: 20px;
    padding: 1.5rem;
    margin-top: 1rem;
}

.participant-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-top: 1.5rem;
}

.participant-card {
    background: 
        linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.participant-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.6s ease;
}

.participant-card:hover::before {
    left: 100%;
}

.participant-card:hover {
    transform: translateY(-5px) scale(1.05);
    box-shadow: 
        0 20px 40px rgba(0, 0, 0, 0.3),
        0 10px 20px rgba(79, 70, 229, 0.2);
    border-color: rgba(79, 70, 229, 0.4);
}

.participant-avatar {
    width: 64px;
    height: 64px;
    border-radius: 20px;
    background: 
        linear-gradient(135deg, #4F46E5 0%, #6366F1 50%, #8B5CF6 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 auto 1rem;
    box-shadow: 0 8px 16px rgba(79, 70, 229, 0.3);
    transition: all 0.3s ease;
}

.participant-card:hover .participant-avatar {
    transform: scale(1.1) rotate(5deg);
    box-shadow: 0 12px 24px rgba(79, 70, 229, 0.4);
}

.participant-name {
    font-weight: 700;
    color: white;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.participant-votes {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.vote-button {
    background: 
        linear-gradient(135deg, #22C55E 0%, #16A34A 100%);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    width: 100%;
}

.vote-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.5s ease;
}

.vote-button:hover::before {
    left: 100%;
}

.vote-button:hover {
    background: 
        linear-gradient(135deg, #16A34A 0%, #15803D 100%);
    transform: translateY(-2px) scale(1.05);
    box-shadow: 
        0 12px 24px rgba(34, 197, 94, 0.4),
        0 6px 12px rgba(34, 197, 94, 0.3);
}

.vote-button:active {
    transform: translateY(0) scale(0.98);
}

.vote-button.voted {
    background: 
        linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
}

/* Enhanced Community Button */
.community-button {
    background: 
        linear-gradient(135deg, #4F46E5 0%, #6366F1 50%, #8B5CF6 100%);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 16px;
    font-weight: 700;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    position: relative;
    overflow: hidden;
    text-decoration: none;
    box-shadow: 
        0 12px 24px rgba(79, 70, 229, 0.3),
        0 6px 12px rgba(79, 70, 229, 0.2);
}

.community-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.6s ease;
}

.community-button:hover::before {
    left: 100%;
}

.community-button:hover {
    background: 
        linear-gradient(135deg, #4338CA 0%, #5853DF 50%, #7C3AED 100%);
    transform: translateY(-3px) scale(1.05);
    box-shadow: 
        0 20px 40px rgba(79, 70, 229, 0.4),
        0 10px 20px rgba(79, 70, 229, 0.3);
}

.community-button:active {
    transform: translateY(-1px) scale(1.02);
}

/* Enhanced Admin Toggle */
.admin-toggle {
    display: inline-flex;
    background: 
        linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 0.25rem;
    gap: 0.25rem;
}

.toggle-option {
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
}

.toggle-option:hover {
    color: rgba(255, 255, 255, 0.9);
    background: rgba(255, 255, 255, 0.05);
}

.toggle-option.active {
    background: 
        linear-gradient(135deg, #4F46E5 0%, #6366F1 50%, #8B5CF6 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

/* Enhanced Empty States */
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

/* Responsive Design */
@media (max-width: 1024px) {
    .hero-content {
        padding: 4rem 2rem;
    }
    
    .event-title {
        font-size: 3rem;
    }
    
    .participant-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    }
}

@media (max-width: 768px) {
    .event-container {
        border-radius: 20px;
        margin: 1rem;
    }
    
    .hero-section {
        border-radius: 20px;
    }
    
    .hero-content {
        padding: 3rem 1.5rem;
    }
    
    .event-title {
        font-size: 2rem;
    }
    
    .event-description {
        font-size: 1rem;
    }
    
    .navigation-tabs {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .content-card {
        padding: 1.5rem;
        border-radius: 16px;
    }
    
    .participant-grid {
        grid-template-columns: 1fr;
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
    <div class="event-background">
        <div class="floating-element float-1"></div>
        <div class="floating-element float-2"></div>
        <div class="floating-element float-3"></div>
        <div class="floating-element float-4"></div>
        
        <!-- Enhanced Particle System -->
        <div class="event-particles">
            <div class="event-particle" style="width: 10px; height: 10px; left: 5%; animation-delay: 0s; animation-duration: 25s;"></div>
            <div class="event-particle" style="width: 8px; height: 8px; left: 15%; animation-delay: 5s; animation-duration: 30s;"></div>
            <div class="event-particle" style="width: 12px; height: 12px; left: 25%; animation-delay: 10s; animation-duration: 20s;"></div>
            <div class="event-particle" style="width: 6px; height: 6px; left: 35%; animation-delay: 15s; animation-duration: 35s;"></div>
            <div class="event-particle" style="width: 9px; height: 9px; left: 45%; animation-delay: 20s; animation-duration: 28s;"></div>
            <div class="event-particle" style="width: 11px; height: 11px; left: 55%; animation-delay: 25s; animation-duration: 22s;"></div>
            <div class="event-particle" style="width: 7px; height: 7px; left: 65%; animation-delay: 30s; animation-duration: 32s;"></div>
            <div class="event-particle" style="width: 10px; height: 10px; left: 75%; animation-delay: 35s; animation-duration: 26s;"></div>
            <div class="event-particle" style="width: 8px; height: 8px; left: 85%; animation-delay: 40s; animation-duration: 29s;"></div>
            <div class="event-particle" style="width: 9px; height: 9px; left: 95%; animation-delay: 45s; animation-duration: 24s;"></div>
        </div>

        <!-- Interactive Light Orbs -->
        <div class="light-orb" style="left: 10%; animation-delay: 0s; animation-duration: 40s;"></div>
        <div class="light-orb" style="left: 30%; animation-delay: 12s; animation-duration: 45s;"></div>
        <div class="light-orb" style="left: 50%; animation-delay: 24s; animation-duration: 35s;"></div>
        <div class="light-orb" style="left: 70%; animation-delay: 6s; animation-duration: 42s;"></div>
        <div class="light-orb" style="left: 90%; animation-delay: 18s; animation-duration: 38s;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Enhanced Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <a href="{{ route('events.show', $event) }}" class="text-fuchsia-400 text-xl sm:text-2xl font-bold hover:text-fuchsia-300 transition-all duration-300 hover:scale-105">
                    {{ $event->title }}
                </a>
                
                <div class="flex items-center gap-4">
                    <!-- Enhanced Admin Toggle -->
                    <div class="admin-toggle">
                        <a href="{{ route('interactive.events.show', ['event' => $event->slug ?? $event->id]) }}" class="toggle-option active">
                            Vue Utilisateur
                        </a>
                        @can('update', $event)
                            <a href="{{ route('events.interactive.manage', $event) }}" class="toggle-option">
                                Vue Admin
                            </a>
                        @endcan
                    </div>

                    <!-- Enhanced Community Button -->
                    <a href="{{ route('events.community', $event) }}" class="community-button">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Ouvrir la communauté
                    </a>
                </div>
            </div>

            <!-- Enhanced Hero Section -->
            <div class="hero-section">
                <div class="hero-background" style="background-image: url('{{ $event->cover_image_url }}');"></div>
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <h1 class="event-title">{{ $event->title }}</h1>
                    @if($event->description)
                        <p class="event-description">
                            {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 220) }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Enhanced Event Content -->
        <div class="space-y-8">
            <!-- Enhanced Event Details Card -->
            <div class="content-card">
                <div class="card-header">
                    <div class="card-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="card-title">Détails de l'Événement</h2>
                </div>
                
                <div class="rounded-2xl bg-slate-900/50 p-4">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        @if($event->youtube_url)
                            <div class="space-y-4">
                                <h3 class="font-bold text-slate-200 text-lg">YouTube</h3>
                                <div class="video-container aspect-video">
                                    <div class="video-label">YouTube Live</div>
                                    <iframe class="w-full h-full"
                                            src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::afterLast($event->youtube_url, 'v=') }}"
                                            title="YouTube video"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        @endif
                        @if($event->tiktok_url)
                            <div class="space-y-4">
                                <h3 class="font-bold text-slate-200 text-lg">TikTok</h3>
                                <div class="video-container aspect-[9/16]">
                                    <div class="video-label">TikTok Live</div>
                                    <iframe class="w-full h-full"
                                            src="{{ $event->tiktok_url }}"
                                            title="TikTok"
                                            frameborder="0"
                                            allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        @endif
                        @unless($event->youtube_url || $event->tiktok_url)
                            <div class="col-span-2">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <h3 class="empty-title">Aucune vidéo disponible</h3>
                                    <p class="empty-description">Les streams seront bientôt disponibles</p>
                                </div>
                            </div>
                        @endunless
                    </div>
                </div>
            </div>

            <!-- Enhanced Participants Voting Card -->
            <div class="content-card">
                <div class="card-header">
                    <div class="card-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h2 class="card-title">Rencontrez les Participants</h2>
                </div>
                
                @if($event->isInteractiveActive() && ($event->interactive_public || auth()->check()))
                    <div class="voting-panel">
                        <livewire:interactive.voting-panel :event="$event" />
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="empty-title">Votes non disponibles</h3>
                        <p class="empty-description">Les votes ne sont pas accessibles pour le moment</p>
                    </div>
                @endif
            </div>

            <!-- Additional Interactive Features -->
            <div class="content-card">
                <div class="card-header">
                    <div class="card-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h2 class="card-title">Fonctionnalités Interactives</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Challenge Feature -->
                    <div class="text-center p-6 rounded-2xl bg-gradient-to-br from-purple-500/10 to-pink-500/10 border border-purple-500/20 hover:from-purple-500/20 hover:to-pink-500/20 transition-all duration-300 hover:scale-105">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white text-2xl font-bold">
                            🏆
                        </div>
                        <h3 class="text-white font-bold text-lg mb-2">Défis</h3>
                        <p class="text-slate-300 text-sm">Participez aux défis de l'événement</p>
                    </div>
                    
                    <!-- Donation Feature -->
                    <div class="text-center p-6 rounded-2xl bg-gradient-to-br from-green-500/10 to-emerald-500/10 border border-green-500/20 hover:from-green-500/20 hover:to-emerald-500/20 transition-all duration-300 hover:scale-105">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center text-white text-2xl font-bold">
                            💝
                        </div>
                        <h3 class="text-white font-bold text-lg mb-2">Dons</h3>
                        <p class="text-slate-300 text-sm">Soutenez les participants</p>
                    </div>
                    
                    <!-- Wallet Feature -->
                    <div class="text-center p-6 rounded-2xl bg-gradient-to-br from-blue-500/10 to-cyan-500/10 border border-blue-500/20 hover:from-blue-500/20 hover:to-cyan-500/20 transition-all duration-300 hover:scale-105">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white text-2xl font-bold">
                            💰
                        </div>
                        <h3 class="text-white font-bold text-lg mb-2">Portefeuille</h3>
                        <p class="text-slate-300 text-sm">Gérez vos crédits</p>
                    </div>
                </div>
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
        glow.style.width = '20px';
        glow.style.height = '20px';
        glow.style.background = 'radial-gradient(circle, rgba(139, 92, 246, 0.4) 0%, transparent 70%)';
        glow.style.borderRadius = '50%';
        glow.style.pointerEvents = 'none';
        glow.style.transform = 'translate(-50%, -50%)';
        glow.style.transition = 'all 2s ease-out';
        glow.style.zIndex = '9998';
        
        document.body.appendChild(glow);
        
        setTimeout(() => {
            glow.style.width = '100px';
            glow.style.height = '100px';
            glow.style.opacity = '0';
        }, 10);
        
        setTimeout(() => {
            glow.remove();
        }, 2000);
    });

    // Enhanced card hover effects
    const cards = document.querySelectorAll('.content-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-12px) scale(1.03) rotateX(5deg)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1) rotateX(0deg)';
        });
    });

    // Enhanced participant card interactions
    const participantCards = document.querySelectorAll('.participant-card');
    participantCards.forEach(card => {
        card.addEventListener('click', function() {
            // Add click ripple effect
            const ripple = document.createElement('div');
            ripple.style.position = 'absolute';
            ripple.style.top = '50%';
            ripple.style.left = '50%';
            ripple.style.width = '0';
            ripple.style.height = '0';
            ripple.style.background = 'radial-gradient(circle, rgba(79, 70, 229, 0.4) 0%, transparent 70%)';
            ripple.style.borderRadius = '50%';
            ripple.style.transform = 'translate(-50%, -50%)';
            ripple.style.transition = 'all 0.8s ease';
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.style.width = '200px';
                ripple.style.height = '200px';
                ripple.style.opacity = '0';
            }, 10);
            
            setTimeout(() => {
                ripple.remove();
            }, 800);
        });
    });

    // Enhanced vote button interactions
    const voteButtons = document.querySelectorAll('.vote-button');
    voteButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Toggle voted state
            this.classList.toggle('voted');
            
            // Add success animation
            this.style.animation = 'voteSuccess 0.6s ease-out';
            setTimeout(() => {
                this.style.animation = '';
            }, 600);
        });
    });

    // Enhanced community button interactions
    const communityButton = document.querySelector('.community-button');
    if (communityButton) {
        communityButton.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px) scale(1.08) rotateX(5deg)';
        });
        
        communityButton.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1) rotateX(0deg)';
        });
    }

    // Enhanced hero section parallax
    const heroSection = document.querySelector('.hero-section');
    const heroBackground = document.querySelector('.hero-background');
    
    if (heroSection && heroBackground) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallax = scrolled * 0.5;
            
            heroBackground.style.transform = `translateY(${parallax}px) scale(1.1)`;
        });
    }

    // Add entrance animations to elements
    const elementsToAnimate = document.querySelectorAll('.content-card, .admin-toggle, .community-button');
    elementsToAnimate.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(40px)';
        element.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
        
        setTimeout(() => {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, 200 + (index * 150));
    });

    // Enhanced video container interactions
    const videoContainers = document.querySelectorAll('.video-container');
    videoContainers.forEach(container => {
        container.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.03) rotateY(5deg)';
            this.style.boxShadow = '0 25px 50px rgba(0, 0, 0, 0.6)';
        });
        
        container.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) rotateY(0deg)';
            this.style.boxShadow = '0 16px 32px rgba(0, 0, 0, 0.4)';
        });
    });
});

// Add vote success animation
const style = document.createElement('style');
style.textContent = `
    @keyframes voteSuccess {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.2);
            box-shadow: 0 0 30px rgba(34, 197, 94, 0.8);
        }
        100% {
            transform: scale(1);
        }
    }
`;
document.head.appendChild(style);
</script>
