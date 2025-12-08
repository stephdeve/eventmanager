<style>
    /* Variables de couleurs conformes à votre design */
    :root {
        --primary: #4F46E5;
        --primary-dark: #4338CA;
        --primary-light: #818cf8;
        --secondary: #10B981;
        --secondary-dark: #059669;
        --secondary-light: #34d399;
        --accent: #F59E0B;
        --accent-dark: #D97706;
        --accent-light: #fbbf24;
        --danger: #EF4444;
        --danger-dark: #DC2626;
        --success: #22C55E;
        --success-dark: #16A34A;
        --indigo: #6366f1;
        --purple: #8b5cf6;
        --blue: #3b82f6;
        --cyan: #06b6d4;
    }

    /* Style principal conforme */
    .event-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 2rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e2e8f0;
    }

    .event-container:hover {
        transform: translateY(-4px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    /* Header revisé - design épuré */
    .event-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--indigo) 100%);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .event-header-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
        position: relative;
        z-index: 2;
    }

    .event-title-section {
        flex: 1;
        min-width: 0;
    }

    .event-title-main {
        font-size: 2rem;
        font-weight: 800;
        color: white;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .event-subtitle {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.9);
        margin: 0;
    }

    /* Navigation header revisée */
    .header-navigation {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-shrink: 0;
    }

    .admin-toggle {
        display: inline-flex;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 0.5rem;
        gap: 0.25rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .toggle-option {
        padding: 0.75rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .toggle-option:hover {
        color: white;
        background: rgba(255, 255, 255, 0.1);
    }

    .toggle-option.active {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .community-button {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        white-space: nowrap;
    }

    .community-button:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    /* Section Hero */
    .hero-section {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 2.5rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .hero-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        filter: brightness(0.85);
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(61, 61, 67, 0.8) 40%, rgba(4, 4, 6, 0.6) 100%);
    }

    .hero-content {
        position: relative;
        padding: 4rem 2rem;
        text-align: center;
        z-index: 2;
    }

    .event-title {
        font-size: 3rem;
        font-weight: 800;
        color: white;
        margin-bottom: 1.5rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .event-description {
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.95);
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.6;
        font-weight: 500;
    }

    /* Navigation tabs */
    .navigation-tabs {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 2.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 0.75rem;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid #e2e8f0;
    }

    .tab-button {
        flex: 1;
        background: transparent;
        border: none;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        font-weight: 700;
        color: #64748b;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .tab-button:hover {
        color: #475569;
        background: rgba(255, 255, 255, 0.6);
        transform: translateY(-2px);
    }

    .tab-button.active {
        background: linear-gradient(135deg, var(--primary) 0%, var(--indigo) 100%);
        color: white;
        box-shadow: 0 6px 15px rgba(79, 70, 229, 0.3);
    }

    /* Cartes de contenu avec couleurs alternées */
    .content-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .content-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        border-color: #cbd5e1;
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    /* Icônes avec couleurs alternées */
    .card-icon-primary {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 6px 15px rgba(79, 70, 229, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-icon-secondary {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: var(--secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 6px 15px rgba(16, 185, 129, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-icon-accent {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 6px 15px rgba(245, 158, 11, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-icon-indigo {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: var(--indigo);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 6px 15px rgba(99, 102, 241, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-icon-purple {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: var(--purple);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 6px 15px rgba(139, 92, 246, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-icon-blue {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: var(--blue);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 6px 15px rgba(59, 130, 246, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-icon-cyan {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: var(--cyan);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 6px 15px rgba(6, 182, 212, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-icon-primary:hover,
    .card-icon-secondary:hover,
    .card-icon-accent:hover,
    .card-icon-indigo:hover,
    .card-icon-purple:hover,
    .card-icon-blue:hover,
    .card-icon-cyan:hover {
        transform: scale(1.1);
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1e293b;
    }

    /* Conteneur vidéo */
    .video-container {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        background: #000;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .video-container:hover {
        transform: scale(1.02);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
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
        background: var(--primary);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.9rem;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    /* Panneau de vote */
    .voting-panel {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }

    .participant-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
    }

    .participant-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .participant-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        border-color: var(--primary);
    }

    .participant-avatar {
        width: 70px;
        height: 70px;
        border-radius: 14px;
        background: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.75rem;
        font-weight: 800;
        margin: 0 auto 1rem;
        box-shadow: 0 6px 15px rgba(79, 70, 229, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .participant-card:hover .participant-avatar {
        transform: scale(1.1);
        background: var(--primary-dark);
    }

    .participant-name {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .participant-votes {
        color: #64748b;
        font-size: 0.95rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .vote-button {
        background: var(--success);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 100%;
    }

    .vote-button:hover {
        background: var(--success-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(34, 197, 94, 0.4);
    }

    .vote-button.voted {
        background: var(--primary);
    }

    /* États vides */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        border-radius: 16px;
        background: #f8f9fa;
        border: 2px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 0.75rem;
    }

    .empty-description {
        color: #64748b;
        font-size: 1rem;
        max-width: 400px;
        margin: 0 auto;
    }

    /* Grilles */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .feature-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 2rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .feature-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        border-color: var(--primary);
    }

    .feature-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 1.5rem;
        border-radius: 16px;
        background: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 6px 15px rgba(79, 70, 229, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.1);
        background: var(--primary-dark);
    }

    .feature-title {
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 1rem;
        font-size: 1.25rem;
    }

    .feature-description {
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.5;
    }

    /* Badges avec couleurs variées */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .badge-primary {
        background: var(--primary);
        color: white;
    }

    .badge-secondary {
        background: var(--secondary);
        color: white;
    }

    .badge-accent {
        background: var(--accent);
        color: white;
    }

    .badge-danger {
        background: var(--danger);
        color: white;
    }

    .badge-indigo {
        background: var(--indigo);
        color: white;
    }

    .badge-purple {
        background: var(--purple);
        color: white;
    }

    /* Stats cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .stat-card {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 600;
    }

    /* Quick actions */
    .quick-action {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }

    .quick-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        border-color: var(--primary);
        color: inherit;
    }

    .action-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        background: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
    }

    .action-content {
        flex: 1;
        text-align: left;
    }

    .action-title {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .hero-content {
            padding: 3rem 1.5rem;
        }

        .event-title {
            font-size: 2.5rem;
        }

        .event-title-main {
            font-size: 1.75rem;
        }

        .participant-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }

        .features-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .event-header {
            padding: 1.5rem;
        }

        .event-header-content {
            flex-direction: column;
            align-items: stretch;
            gap: 1.5rem;
        }

        .event-title-section {
            text-align: center;
        }

        .header-navigation {
            justify-content: center;
            flex-wrap: wrap;
        }

        .admin-toggle {
            width: 100%;
            justify-content: center;
        }

        .community-button {
            width: 100%;
            justify-content: center;
        }

        .event-container {
            border-radius: 12px;
            margin: 1rem;
        }

        .hero-section {
            border-radius: 12px;
        }

        .hero-content {
            padding: 2.5rem 1rem;
        }

        .event-title {
            font-size: 2rem;
        }

        .event-description {
            font-size: 1.1rem;
        }

        .navigation-tabs {
            flex-direction: column;
            gap: 0.5rem;
        }

        .content-card {
            padding: 1.5rem;
            border-radius: 12px;
        }

        .participant-grid {
            grid-template-columns: 1fr;
        }

        .features-grid {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .event-header {
            padding: 1rem;
        }

        .event-title-main {
            font-size: 1.5rem;
        }

        .event-subtitle {
            font-size: 1rem;
        }

        .admin-toggle {
            flex-direction: column;
        }

        .toggle-option {
            justify-content: center;
        }
    }

    /* Dark mode neutral overrides */
    .dark .event-container {
        background: #0a0a0a;
        border: 1px solid #262626;
    }

    .dark .content-card,
    .dark .feature-card,
    .dark .quick-action {
        background: #0a0a0a;
        border: 1px solid #262626;
    }

    .dark .navigation-tabs {
        background: linear-gradient(135deg, #0a0a0a 0%, #171717 100%);
        border: 1px solid #262626;
    }

    .dark .tab-button {
        color: #a3a3a3;
    }

    .dark .tab-button:hover {
        background: rgba(23, 23, 23, 0.6);
        color: #e5e5e5;
    }

    .dark .stat-card,
    .dark .voting-panel {
        background: #0a0a0a;
        border: 1px solid #262626;
    }

    .dark .empty-icon {
        background: #0a0a0a;
        border: 2px solid #262626;
        color: #9ca3af;
    }

    .dark .card-title,
    .dark .participant-name,
    .dark .feature-title,
    .dark .action-title {
        color: #e5e5e5;
    }

    .dark .participant-votes,
    .dark .feature-description,
    .dark .empty-description {
        color: #a3a3a3;
    }
</style>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-indigo-50/30 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header revisé - design épuré sans image de fond -->
        <div class="event-header">
            <div class="event-header-content">
                <div class="event-title-section">
                    <h1 class="event-title-main">{{ $event->title }}</h1>
                    <p class="event-subtitle">Expérience interactive en direct</p>
                </div>

                <div class="header-navigation">
                    <div class="admin-toggle">
                        <a href="{{ route('interactive.events.show', ['event' => $event->slug ?? $event->id]) }}"
                            class="toggle-option active">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Vue Utilisateur
                        </a>
                        @can('update', $event)
                            <a href="{{ route('events.interactive.manage', $event) }}" class="toggle-option">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Vue Admin
                            </a>
                        @endcan
                    </div>

                    <a href="{{ route('events.community', $event) }}" class="community-button">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Communauté
                    </a>
                </div>
            </div>
        </div>

        <!-- Section Hero -->
        <div class="hero-section">
            <div class="hero-background" style="background-image: url('{{ $event->cover_image_url }}');"></div>
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <h1 class="event-title">{{ $event->title }}</h1>
                @if ($event->description)
                    <p class="event-description">
                        {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 220) }}
                    </p>
                @endif
                <div class="mt-6 flex gap-4 justify-center flex-wrap">
                    <span class="badge badge-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        En Direct
                    </span>

                    @if($event->is_interactive)
                        @php($now = now())
                        @if($event->isInteractiveActive())
                            <span class="badge badge-secondary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                </svg>
                                Interactivité en cours
                            </span>
                        @elseif($event->interactive_starts_at && $now->lt($event->interactive_starts_at))
                            <span class="badge badge-indigo">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                Interactivité à {{ $event->interactive_starts_at->translatedFormat('d/m H:i') }}
                            </span>
                        @elseif($event->interactive_ends_at && $now->gt($event->interactive_ends_at))
                            <span class="badge badge-accent">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                </svg>
                                Interactivité terminée
                            </span>
                        @else
                            <span class="badge">
                                Interactivité inactive
                            </span>
                        @endif
                    @endif

                    <span class="badge badge-indigo">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        Live
                    </span>
                </div>
            </div>
        </div>

        <!-- Contenu de l'événement -->
        <div class="space-y-8">
            <!-- Détails de l'événement avec icône primaire -->
            <div class="content-card">
                <div class="card-header">
                    <div class="card-icon-primary">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="card-title">Détails de l'Événement</h2>
                </div>

                <div class="rounded-xl bg-slate-50 p-6 border border-slate-200">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        @if ($event->youtube_url)
                            <div class="space-y-4">
                                <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                                    </svg>
                                    YouTube Live
                                    <span class="badge badge-danger">Live</span>
                                </h3>
                                <div class="video-container aspect-video">
                                    <div class="video-label">YouTube</div>
                                    <iframe class="w-full h-full"
                                        src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::afterLast($event->youtube_url, 'v=') }}"
                                        title="YouTube video" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        @endif
                        @if ($event->tiktok_url)
                            <div class="space-y-4">
                                <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                                    <svg class="w-5 h-5 text-black" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M19.589 6.686a4.793 4.793 0 01-3.77-4.245V2h-3.445v13.672a2.896 2.896 0 01-5.201 1.743l-.002-.001.002.001a2.895 2.895 0 113.183-4.51v-3.5a6.329 6.329 0 105.608 6.145 6.33 6.33 0 003.771-11.355z" />
                                    </svg>
                                    TikTok Live
                                    <span class="badge badge-accent">Trending</span>
                                </h3>
                                <div class="video-container aspect-[9/16]">
                                    <div class="video-label">TikTok</div>
                                    <iframe class="w-full h-full" src="{{ $event->tiktok_url }}" title="TikTok"
                                        frameborder="0" allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        @endif
                        @unless ($event->youtube_url || $event->tiktok_url)
                            <div class="col-span-2">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="empty-title">Aucune vidéo disponible pour le moment</h3>
                                    <p class="empty-description">Les streams seront bientôt disponibles. Revenez plus tard
                                        !</p>
                                </div>
                            </div>
                        @endunless
                    </div>
                </div>
            </div>

            <!-- Participants et votes avec icône secondaire -->
            <div class="content-card">
                <div class="card-header">
                    <div class="card-icon-secondary">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h2 class="card-title">Rencontrez les Participants</h2>
                    <span class="badge badge-secondary">{{ $event->participants->count() }} participants</span>
                </div>

                @if ($event->isInteractiveActive() && ($event->interactive_public || auth()->check()))
                    <div class="voting-panel">
                        <livewire:interactive.voting-panel :event="$event" />
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="empty-title">Votes non disponibles pour le moment</h3>
                        <p class="empty-description">La fonction de vote sera activée prochainement</p>
                    </div>
                @endif
            </div>

            <!-- Fonctionnalités interactives avec icônes colorées alternées -->
            <div class="content-card">
                <div class="card-header">
                    <div class="card-icon-indigo">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h2 class="card-title">Fonctionnalités Interactives</h2>
                    <span class="badge badge-indigo">Nouveau</span>
                </div>

                <div class="features-grid">
                    <!-- Défis avec icône primaire -->
                    <div class="feature-card">
                        <div class="feature-icon" style="background: var(--primary);">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="feature-title">Défis & Compétitions</h3>
                        <p class="feature-description">Participez aux défis excitants et gagnez des récompenses
                            exclusives</p>
                    </div>

                    <!-- Dons avec icône secondaire -->
                    <div class="feature-card">
                        <div class="feature-icon" style="background: var(--secondary);">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h3 class="feature-title">Soutien & Dons</h3>
                        <p class="feature-description">Soutenez vos participants préférés et encouragez leur
                            performance</p>
                    </div>

                    <!-- Portefeuille avec icône accent -->
                    <div class="feature-card">
                        <div class="feature-icon" style="background: var(--accent);">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 1.119-3 2.5S10.343 13 12 13s3 1.119 3 2.5S13.657 18 12 18m0-10V6m0 12v-2m8-4a8 8 0 11-16 0 8 8 0 0116 0z" />
                            </svg>
                        </div>
                        <h3 class="feature-title">Portefeuille Digital</h3>
                        <p class="feature-description">Gérez vos crédits et récompenses de manière sécurisée</p>
                    </div>

                    <!-- Classement avec icône purple -->
                    <div class="feature-card">
                        <div class="feature-icon" style="background: var(--purple);">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="feature-title">Classement en Direct</h3>
                        <p class="feature-description">Suivez les performances en temps réel avec notre classement
                            interactif</p>
                    </div>
                </div>
            </div>

            <!-- Informations supplémentaires structurées -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Statistiques en temps réel avec icône blue -->
                <div class="content-card lg:col-span-2">
                    <div class="card-header">
                        <div class="card-icon-blue">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h2 class="card-title">Statistiques en Direct</h2>
                    </div>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-value">1.2K</div>
                            <div class="stat-label">Spectateurs</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value">356</div>
                            <div class="stat-label">Votes</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value">89</div>
                            <div class="stat-label">Participants</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value">2.5K</div>
                            <div class="stat-label">Interactions</div>
                        </div>
                    </div>
                </div>

                <!-- Actions rapides avec icône cyan -->
                <div class="content-card">
                    <div class="card-header">
                        <div class="card-icon-cyan">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h2 class="card-title">Actions Rapides</h2>
                    </div>
                    <div class="space-y-3">
                        <a href="#" class="quick-action">
                            <div class="action-icon" style="background: var(--primary);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="action-content">
                                <div class="action-title">Regarder le replay</div>
                                <div class="text-sm text-slate-600">Accéder aux enregistrements</div>
                            </div>
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <a href="#" class="quick-action">
                            <div class="action-icon" style="background: var(--secondary);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                            </div>
                            <div class="action-content">
                                <div class="action-title">Partager l'événement</div>
                                <div class="text-sm text-slate-600">Inviter des amis</div>
                            </div>
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Interactions conformes avec vos animations
        const cards = document.querySelectorAll(
            '.content-card, .participant-card, .feature-card, .stat-card, .quick-action');
        cards.forEach((card, index) => {
            card.style.transitionDelay = `${index * 0.1}s`;

            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
                this.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.15)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = '';
                this.style.boxShadow = '';
            });
        });

        // Interactions pour les boutons de vote
        const voteButtons = document.querySelectorAll('.vote-button');
        voteButtons.forEach(button => {
            button.addEventListener('click', function() {
                this.classList.toggle('voted');

                // Effet de pulsation conforme
                this.style.animation = 'pulse 0.6s ease';
                setTimeout(() => {
                    this.style.animation = '';
                }, 600);
            });
        });

        // Animation d'entrée des éléments
        const animatedElements = document.querySelectorAll(
            '.content-card, .feature-card, .participant-card, .stat-card');
        animatedElements.forEach((element, index) => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';

            setTimeout(() => {
                element.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, 200 + (index * 100));
        });

        // Mise à jour en temps réel des statistiques (simulation)
        function updateLiveStats() {
            const stats = document.querySelectorAll('.stat-value');
            stats.forEach(stat => {
                const current = parseInt(stat.textContent.replace(/[^\d]/g, ''));
                const increment = Math.floor(Math.random() * 10) + 1;
                stat.textContent = (current + increment).toLocaleString();
            });
        }

        // Mettre à jour les stats toutes les 30 secondes
        setInterval(updateLiveStats, 30000);
    });
</script>
