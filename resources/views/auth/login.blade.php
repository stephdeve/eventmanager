<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - EventManager</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            background: #0a0a0f;
        }

        /* Enhanced Animated Background */
        .auth-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(ellipse at top left, rgba(79, 70, 229, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at bottom right, rgba(139, 92, 246, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at center, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                linear-gradient(135deg, #0a0a0f 0%, #1a1a2e 50%, #16213e 100%);
            z-index: -2;
        }

        .background-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.08;
            object-fit: cover;
            filter: blur(2px);
        }

        .background-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                linear-gradient(135deg, rgba(79, 70, 229, 0.2) 0%, transparent 30%),
                linear-gradient(225deg, rgba(139, 92, 246, 0.2) 0%, transparent 30%),
                linear-gradient(45deg, rgba(59, 130, 246, 0.15) 0%, transparent 40%);
            animation: backgroundPulse 8s ease-in-out infinite;
        }

        @keyframes backgroundPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        /* Enhanced Animated Elements */
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.4;
            animation: complexFloat 12s ease-in-out infinite;
            mix-blend-mode: screen;
        }

        .shape-1 {
            width: 400px;
            height: 400px;
            background: 
                radial-gradient(circle, rgba(79, 70, 229, 0.8) 0%, rgba(99, 102, 241, 0.4) 50%, transparent 70%);
            top: 5%;
            left: 5%;
            animation-delay: 0s;
            animation-duration: 15s;
        }

        .shape-2 {
            width: 350px;
            height: 350px;
            background: 
                radial-gradient(circle, rgba(139, 92, 246, 0.8) 0%, rgba(167, 139, 250, 0.4) 50%, transparent 70%);
            top: 50%;
            right: 10%;
            animation-delay: 3s;
            animation-duration: 18s;
        }

        .shape-3 {
            width: 300px;
            height: 300px;
            background: 
                radial-gradient(circle, rgba(59, 130, 246, 0.8) 0%, rgba(96, 165, 250, 0.4) 50%, transparent 70%);
            bottom: 10%;
            left: 15%;
            animation-delay: 6s;
            animation-duration: 20s;
        }

        .shape-4 {
            width: 250px;
            height: 250px;
            background: 
                radial-gradient(circle, rgba(236, 72, 153, 0.6) 0%, rgba(244, 114, 182, 0.3) 50%, transparent 70%);
            top: 30%;
            right: 30%;
            animation-delay: 9s;
            animation-duration: 16s;
        }

        @keyframes complexFloat {
            0%, 100% {
                transform: translateY(0px) translateX(0px) scale(1) rotate(0deg);
            }
            25% {
                transform: translateY(-30px) translateX(20px) scale(1.1) rotate(90deg);
            }
            50% {
                transform: translateY(-15px) translateX(-10px) scale(0.9) rotate(180deg);
            }
            75% {
                transform: translateY(-40px) translateX(15px) scale(1.05) rotate(270deg);
            }
        }

        /* Enhanced Particles System */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.4) 50%, transparent 70%);
            border-radius: 50%;
            animation: enhancedParticleFloat 20s linear infinite;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        @keyframes enhancedParticleFloat {
            0% {
                transform: translateY(100vh) translateX(0px) rotate(0deg) scale(0);
                opacity: 0;
            }
            10% {
                transform: translateY(80vh) translateX(10px) rotate(36deg) scale(1);
                opacity: 1;
            }
            90% {
                transform: translateY(20vh) translateX(-10px) rotate(324deg) scale(1);
                opacity: 1;
            }
            100% {
                transform: translateY(0vh) translateX(0px) rotate(360deg) scale(0);
                opacity: 0;
            }
        }

        /* Interactive Light Effects */
        .light-orb {
            position: absolute;
            width: 6px;
            height: 6px;
            background: radial-gradient(circle, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0.6) 40%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            animation: orbFloat 25s linear infinite;
            box-shadow: 
                0 0 20px rgba(255, 255, 255, 0.8),
                0 0 40px rgba(255, 255, 255, 0.4),
                0 0 60px rgba(255, 255, 255, 0.2);
        }

        @keyframes orbFloat {
            0% {
                transform: translateY(100vh) translateX(0px);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) translateX(50px);
                opacity: 0;
            }
        }

        /* Geometric Shapes */
        .geometric-shape {
            position: absolute;
            opacity: 0.1;
            animation: geometricRotate 30s linear infinite;
        }

        .triangle {
            width: 0;
            height: 0;
            border-left: 30px solid transparent;
            border-right: 30px solid transparent;
            border-bottom: 52px solid rgba(79, 70, 229, 0.3);
        }

        .square {
            width: 40px;
            height: 40px;
            background: rgba(139, 92, 246, 0.3);
            transform: rotate(45deg);
        }

        @keyframes geometricRotate {
            0% {
                transform: rotate(0deg) translateY(0px);
            }
            100% {
                transform: rotate(360deg) translateY(-20px);
            }
        }

        /* Main Container with Enhanced Effects */
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            z-index: 1;
            perspective: 1000px;
        }

        .auth-card {
            background: 
                linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.08) 100%),
                rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(25px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 32px;
            width: 100%;
            max-width: 520px;
            overflow: hidden;
            box-shadow: 
                0 32px 64px rgba(0, 0, 0, 0.3),
                0 16px 32px rgba(79, 70, 229, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            animation: cardEntrance 1s ease-out;
        }

        @keyframes cardEntrance {
            0% {
                opacity: 0;
                transform: translateY(50px) scale(0.9) rotateX(10deg);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1) rotateX(0deg);
            }
        }

        .auth-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 
                0 40px 80px rgba(0, 0, 0, 0.4),
                0 20px 40px rgba(79, 70, 229, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: topShimmer 3s ease-in-out infinite;
        }

        @keyframes topShimmer {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.8; }
        }

        /* Enhanced Header */
        .auth-header {
            background: 
                linear-gradient(135deg, rgba(79, 70, 229, 0.95) 0%, rgba(99, 102, 241, 0.9) 50%, rgba(139, 92, 246, 0.85) 100%);
            backdrop-filter: blur(15px);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .auth-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.15), transparent),
                linear-gradient(-45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: enhancedShimmer 4s ease-in-out infinite;
        }

        @keyframes enhancedShimmer {
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

        .auth-header h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.75rem;
            position: relative;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            animation: titleGlow 2s ease-in-out infinite alternate;
        }

        @keyframes titleGlow {
            0% { text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3), 0 0 20px rgba(255, 255, 255, 0.2); }
            100% { text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3), 0 0 30px rgba(255, 255, 255, 0.4); }
        }

        .auth-header p {
            opacity: 0.95;
            font-size: 1.1rem;
            position: relative;
            font-weight: 500;
        }

        /* Enhanced Body */
        .auth-body {
            padding: 3rem 2rem;
            position: relative;
        }

        /* Enhanced Form Styles */
        .form-group {
            margin-bottom: 2rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 1rem;
            font-size: 0.95rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.95);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .input-wrapper {
            position: relative;
            transform-style: preserve-3d;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 1.25rem;
            transform: translateY(-50%);
            width: 24px;
            height: 24px;
            color: rgba(255, 255, 255, 0.6);
            pointer-events: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 2;
        }

        .form-control {
            width: 100%;
            padding: 1.25rem 1.25rem 1.25rem 3.75rem;
            border: 2px solid rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            font-size: 1rem;
            background: 
                linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.04) 100%),
                rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            color: white;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }

        .form-control::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .form-control:focus::before {
            left: 100%;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
            font-weight: 500;
        }

        .form-control:focus {
            outline: none;
            border-color: rgba(79, 70, 229, 0.6);
            background: 
                linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.08) 100%),
                rgba(255, 255, 255, 0.08);
            box-shadow: 
                0 0 0 4px rgba(79, 70, 229, 0.2),
                0 8px 32px rgba(79, 70, 229, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .form-control:focus + .input-icon {
            color: rgba(255, 255, 255, 0.95);
            transform: translateY(-50%) scale(1.1);
        }

        /* Enhanced Password Toggle */
        .toggle-visibility {
            position: absolute;
            top: 50%;
            right: 1.25rem;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 0.75rem;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.7);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .toggle-visibility:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
            color: rgba(255, 255, 255, 0.95);
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 4px 16px rgba(255, 255, 255, 0.2);
        }

        .toggle-visibility:active {
            transform: translateY(-50%) scale(0.95);
        }

        /* Enhanced Checkbox */
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: #4F46E5;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .checkbox-wrapper label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            margin: 0;
            transition: color 0.3s ease;
        }

        .checkbox-wrapper label:hover {
            color: rgba(255, 255, 255, 0.95);
        }

        /* Enhanced Buttons */
        .btn-primary {
            width: 100%;
            background: 
                linear-gradient(135deg, #4F46E5 0%, #6366F1 50%, #8B5CF6 100%);
            color: white;
            padding: 1.25rem 2rem;
            border: none;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 
                0 12px 32px rgba(79, 70, 229, 0.4),
                0 4px 16px rgba(79, 70, 229, 0.2);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
            transform: translate(-50%, -50%);
            transition: all 0.6s ease;
            border-radius: 50%;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover::after {
            width: 300px;
            height: 300px;
        }

        .btn-primary:hover {
            background: 
                linear-gradient(135deg, #4338CA 0%, #5853DF 50%, #7C3AED 100%);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 
                0 20px 40px rgba(79, 70, 229, 0.5),
                0 8px 24px rgba(79, 70, 229, 0.3);
        }

        .btn-primary:active {
            transform: translateY(-1px) scale(1);
        }

        .btn-primary.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-primary .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid transparent;
            border-top: 3px solid white;
            border-radius: 50%;
            animation: enhancedSpin 1s linear infinite;
            margin-right: 10px;
        }

        .btn-primary.loading .spinner {
            display: inline-block;
        }

        .btn-primary.loading .button-text {
            opacity: 0.8;
        }

        @keyframes enhancedSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Enhanced Google Button */
        .google-btn {
            width: 100%;
            background: 
                linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.08) 100%),
                rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            color: white;
            padding: 1.25rem 2rem;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .google-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .google-btn:hover::before {
            left: 100%;
        }

        .google-btn:hover {
            background: 
                linear-gradient(135deg, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0.15) 100%),
                rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 
                0 16px 32px rgba(0, 0, 0, 0.3),
                0 8px 16px rgba(255, 255, 255, 0.1);
        }

        .google-btn:active {
            transform: translateY(-1px) scale(1);
        }

        .google-icon {
            width: 24px;
            height: 24px;
            transition: transform 0.3s ease;
        }

        .google-btn:hover .google-icon {
            transform: scale(1.1);
        }

        /* Enhanced Separator */
        .separator {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 2.5rem 0;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.95rem;
            font-weight: 500;
        }

        .separator::before,
        .separator::after {
            content: '';
            flex: 1;
            border-bottom: 2px solid rgba(255, 255, 255, 0.15);
            position: relative;
        }

        .separator::before {
            margin-right: 1rem;
        }

        .separator::after {
            margin-left: 1rem;
        }

        .separator span {
            padding: 0.5rem 1.5rem;
            background: 
                linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.04) 100%),
                rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Enhanced Links */
        .auth-links {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .auth-links a {
            color: white;
            text-decoration: none;
            font-weight: 700;
            position: relative;
            transition: all 0.3s ease;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }

        .auth-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #4F46E5, #8B5CF6);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .auth-links a:hover {
            color: rgba(255, 255, 255, 0.95);
            background: rgba(255, 255, 255, 0.1);
        }

        .auth-links a:hover::after {
            width: 100%;
        }

        /* Enhanced Messages */
        .error-message {
            color: #FCA5A5;
            font-size: 0.8rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: errorShake 0.5s ease-in-out;
        }

        @keyframes errorShake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .error-message::before {
            content: '⚠';
            font-size: 0.9rem;
            animation: warningPulse 1s ease-in-out infinite;
        }

        @keyframes warningPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .success-message {
            background: 
                linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(34, 197, 94, 0.08) 100%),
                rgba(34, 197, 94, 0.05);
            backdrop-filter: blur(15px);
            color: #86EFAC;
            padding: 1.25rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            font-size: 0.95rem;
            text-align: center;
            border: 1px solid rgba(34, 197, 94, 0.3);
            box-shadow: 0 8px 24px rgba(34, 197, 94, 0.1);
            animation: successSlide 0.5s ease-out;
        }

        @keyframes successSlide {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Enhanced Role Modal */
        .role-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 1rem;
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        .role-modal {
            width: 100%;
            max-width: 480px;
            background: 
                linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            box-shadow: 
                0 32px 64px rgba(0, 0, 0, 0.4),
                0 16px 32px rgba(79, 70, 229, 0.1);
            overflow: hidden;
            animation: modalSlideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes modalSlideIn {
            0% {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .role-modal-header {
            background: 
                linear-gradient(135deg, #4F46E5 0%, #6366F1 50%, #8B5CF6 100%);
            color: white;
            padding: 2rem;
            font-weight: 700;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .role-modal-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s infinite;
        }

        .role-modal-body {
            padding: 2rem;
        }

        .role-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .role-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 1.5rem;
            border-radius: 16px;
            border: 2px solid rgba(79, 70, 229, 0.2);
            background: 
                linear-gradient(135deg, rgba(79, 70, 229, 0.05) 0%, rgba(79, 70, 229, 0.02) 100%);
            color: #1F2937;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .role-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(79, 70, 229, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .role-btn:hover::before {
            left: 100%;
        }

        .role-btn:hover {
            border-color: #4F46E5;
            background: 
                linear-gradient(135deg, rgba(79, 70, 229, 0.1) 0%, rgba(79, 70, 229, 0.05) 100%);
            box-shadow: 
                0 12px 24px rgba(79, 70, 229, 0.2),
                0 4px 12px rgba(79, 70, 229, 0.1);
            transform: translateY(-3px) scale(1.02);
        }

        .role-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            padding: 0 2rem 2rem;
        }

        .btn-cancel {
            background: 
                linear-gradient(135deg, rgba(107, 114, 128, 0.1) 0%, rgba(107, 114, 128, 0.05) 100%);
            border: 2px solid rgba(107, 114, 128, 0.3);
            color: #4B5563;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: 
                linear-gradient(135deg, rgba(107, 114, 128, 0.2) 0%, rgba(107, 114, 128, 0.1) 100%);
            transform: translateY(-2px);
        }

        /* Enhanced Footer */
        .auth-footer {
            margin-top: 2.5rem;
            padding-top: 2.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Enhanced Responsive */
        @media (max-width: 640px) {
            .auth-card {
                max-width: 100%;
                margin: 0 1rem;
            }

            .auth-body {
                padding: 2rem 1.5rem;
            }

            .auth-header {
                padding: 2.5rem 1.5rem;
            }

            .auth-header h2 {
                font-size: 1.75rem;
            }

            .role-options {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .auth-body {
                padding: 1.5rem;
            }

            .auth-header {
                padding: 2rem 1rem;
            }

            .form-control {
                padding: 1rem 1rem 1rem 3rem;
            }

            .btn-primary {
                padding: 1rem 1.5rem;
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Enhanced Animated Background -->
    <div class="auth-background">
        <img src="https://images.unsplash.com/photo-1472653431158-636457a7753f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
             alt="Background" 
             class="background-image"
             onerror="this.style.display='none'">
        <div class="background-overlay"></div>
        
        <!-- Enhanced Floating Shapes -->
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
        <div class="floating-shape shape-4"></div>
        
        <!-- Enhanced Particles -->
        <div class="particles">
            <div class="particle" style="width: 6px; height: 6px; left: 5%; animation-delay: 0s; animation-duration: 18s;"></div>
            <div class="particle" style="width: 4px; height: 4px; left: 15%; animation-delay: 3s; animation-duration: 22s;"></div>
            <div class="particle" style="width: 8px; height: 8px; left: 25%; animation-delay: 6s; animation-duration: 15s;"></div>
            <div class="particle" style="width: 3px; height: 3px; left: 35%; animation-delay: 9s; animation-duration: 25s;"></div>
            <div class="particle" style="width: 7px; height: 7px; left: 45%; animation-delay: 12s; animation-duration: 20s;"></div>
            <div class="particle" style="width: 5px; height: 5px; left: 55%; animation-delay: 15s; animation-duration: 17s;"></div>
            <div class="particle" style="width: 4px; height: 4px; left: 65%; animation-delay: 18s; animation-duration: 23s;"></div>
            <div class="particle" style="width: 6px; height: 6px; left: 75%; animation-delay: 21s; animation-duration: 19s;"></div>
            <div class="particle" style="width: 3px; height: 3px; left: 85%; animation-delay: 24s; animation-duration: 21s;"></div>
            <div class="particle" style="width: 5px; height: 5px; left: 95%; animation-delay: 27s; animation-duration: 16s;"></div>
        </div>

        <!-- Interactive Light Orbs -->
        <div class="light-orb" style="left: 10%; animation-delay: 0s; animation-duration: 30s;"></div>
        <div class="light-orb" style="left: 30%; animation-delay: 10s; animation-duration: 35s;"></div>
        <div class="light-orb" style="left: 50%; animation-delay: 20s; animation-duration: 28s;"></div>
        <div class="light-orb" style="left: 70%; animation-delay: 5s; animation-duration: 32s;"></div>
        <div class="light-orb" style="left: 90%; animation-delay: 15s; animation-duration: 25s;"></div>

        <!-- Geometric Shapes -->
        <div class="geometric-shape triangle" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
        <div class="geometric-shape square" style="top: 60%; right: 15%; animation-delay: 5s;"></div>
        <div class="geometric-shape triangle" style="bottom: 30%; left: 20%; animation-delay: 10s;"></div>
    </div>

    <!-- Enhanced Main Content -->
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2>Connexion</h2>
                <p>Bienvenue sur EventManager</p>
            </div>

            <div class="auth-body">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="success-message">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="success-message" style="background: rgba(239, 68, 68, 0.1); color: #FCA5A5; border-color: rgba(239, 68, 68, 0.3);">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Google Section -->
                <div class="google-section">
                    <a href="#" id="googleBtnLogin" class="google-btn">
                        <svg class="google-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12 s5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C33.602,6.053,29.062,4,24,4C12.955,4,4,12.955,4,24 s8.955,20,20,20s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
                            <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,16.108,18.961,14,24,14c3.059,0,5.842,1.154,7.961,3.039 l5.657-5.657C33.602,6.053,29.062,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
                            <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.193l-6.191-5.238C29.211,35.091,26.715,36,24,36 c-5.202,0-9.619-3.317-11.283-7.946l-6.541,5.036C9.507,39.556,16.227,44,24,44z"/>
                            <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.794,2.241-2.231,4.166-4.095,5.569 c0.001-0.001,0.002-0.001,0.003-0.002l6.191,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
                        </svg>
                        <span>Continuer avec Google</span>
                    </a>
                </div>

                <!-- Enhanced Separator -->
                <div class="separator">
                    <span>ou connectez-vous avec email</span>
                </div>

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Adresse email</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autofocus class="form-control" placeholder="votre@email.com" autocomplete="username">
                        </div>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <input id="password" type="password" name="password" required class="form-control"
                                placeholder="••••••••" autocomplete="current-password">
                            <button type="button" class="toggle-visibility" aria-label="Afficher le mot de passe"
                                data-target="password">
                                <svg class="eye-open h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg class="eye-closed h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.5a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="checkbox-wrapper">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Se souvenir de moi</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary" id="submitButton">
                        <span class="spinner"></span>
                        <span class="button-text">Se connecter</span>
                    </button>

                    <!-- Forgot Password Link -->
                    <div class="auth-links">
                        <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                    </div>

                    <!-- Register Link -->
                    <div class="auth-links">
                        <span>Pas encore de compte ?</span>
                        <a href="{{ route('register') }}">Créer un compte</a>
                    </div>

                    <div class="auth-footer">
                        <p>&copy; 2025 EventManager. Tous droits réservés.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Enhanced Role Selection Modal -->
    <div class="role-modal-backdrop" id="roleModalBackdropLogin" aria-hidden="true">
        <div class="role-modal" role="dialog" aria-modal="true" aria-labelledby="roleModalTitleLogin">
            <div class="role-modal-header" id="roleModalTitleLogin">Choisissez votre type de compte</div>
            <div class="role-modal-body">
                <div class="role-options">
                    <button class="role-btn" data-role="user" type="button">Participant</button>
                    <button class="role-btn" data-role="organizer" type="button">Organisateur</button>
                </div>
            </div>
            <div class="role-modal-footer">
                <button class="btn-cancel" type="button" id="roleModalCancelLogin">Annuler</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const googleRedirectBase = "{{ route('auth.google.redirect') }}";
            const roleModalBackdrop = document.getElementById('roleModalBackdropLogin');
            const openRoleModalBtn = document.getElementById('googleBtnLogin');
            const cancelRoleBtn = document.getElementById('roleModalCancelLogin');

            // Enhanced role modal handlers
            if (openRoleModalBtn && roleModalBackdrop) {
                openRoleModalBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    roleModalBackdrop.style.display = 'flex';
                    // Add entrance animation
                    setTimeout(() => {
                        roleModalBackdrop.querySelector('.role-modal').style.animation = 'modalSlideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                    }, 10);
                });
            }

            if (cancelRoleBtn) {
                cancelRoleBtn.addEventListener('click', function() {
                    roleModalBackdrop.style.display = 'none';
                });
            }

            roleModalBackdrop?.addEventListener('click', function(e) {
                if (e.target === roleModalBackdrop) {
                    roleModalBackdrop.style.display = 'none';
                }
            });

            document.querySelectorAll('#roleModalBackdropLogin .role-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const role = this.getAttribute('data-role') || 'user';
                    const url = googleRedirectBase + '?role=' + encodeURIComponent(role);
                    
                    // Add loading state to button
                    this.style.transform = 'scale(0.95)';
                    this.style.opacity = '0.7';
                    
                    setTimeout(() => {
                        window.location.href = url;
                    }, 200);
                });
            });

            // Enhanced password visibility toggle
            document.querySelectorAll('.toggle-visibility').forEach(function(button) {
                const targetId = button.getAttribute('data-target');
                const input = document.getElementById(targetId);
                if (!input) return;

                button.addEventListener('click', function() {
                    const isPassword = input.getAttribute('type') === 'password';
                    input.setAttribute('type', isPassword ? 'text' : 'password');
                    button.setAttribute('aria-label', isPassword ? 'Masquer le mot de passe' :
                        'Afficher le mot de passe');

                    const eyeOpen = button.querySelector('.eye-open');
                    const eyeClosed = button.querySelector('.eye-closed');
                    if (eyeOpen && eyeClosed) {
                        if (isPassword) {
                            eyeOpen.style.display = 'none';
                            eyeClosed.style.display = 'block';
                        } else {
                            eyeOpen.style.display = 'block';
                            eyeClosed.style.display = 'none';
                        }
                    }

                    // Add click animation
                    this.style.transform = 'translateY(-50%) scale(0.9)';
                    setTimeout(() => {
                        this.style.transform = 'translateY(-50%) scale(1.1)';
                    }, 100);
                });
            });

            // Enhanced form submission with loading animation
            const loginForm = document.getElementById('loginForm');
            const submitButton = document.getElementById('submitButton');

            loginForm.addEventListener('submit', function(e) {
                // Enhanced form validation
                const requiredFields = loginForm.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.style.borderColor = '#FCA5A5';
                        field.style.animation = 'errorShake 0.5s ease-in-out';
                        setTimeout(() => {
                            field.style.animation = '';
                        }, 500);
                    } else {
                        field.style.borderColor = 'rgba(255, 255, 255, 0.2)';
                    }
                });

                if (isValid) {
                    submitButton.classList.add('loading');
                    submitButton.disabled = true;
                    
                    // Add submit animation
                    submitButton.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        submitButton.style.transform = 'scale(1)';
                    }, 200);
                } else {
                    e.preventDefault();
                }
            });

            // Enhanced input focus effects with ripple
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    const icon = this.parentElement.querySelector('.input-icon');
                    if (icon) {
                        icon.style.color = 'rgba(255, 255, 255, 0.95)';
                        icon.style.transform = 'translateY(-50%) scale(1.2)';
                    }
                    
                    // Add focus ripple effect
                    const ripple = document.createElement('div');
                    ripple.style.position = 'absolute';
                    ripple.style.top = '50%';
                    ripple.style.left = '50%';
                    ripple.style.width = '0';
                    ripple.style.height = '0';
                    ripple.style.border = '2px solid rgba(79, 70, 229, 0.6)';
                    ripple.style.borderRadius = '50%';
                    ripple.style.transform = 'translate(-50%, -50%)';
                    ripple.style.transition = 'all 0.6s ease';
                    this.parentElement.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.style.width = '100%';
                        ripple.style.height = '100%';
                        ripple.style.opacity = '0';
                    }, 10);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });

                input.addEventListener('blur', function() {
                    const icon = this.parentElement.querySelector('.input-icon');
                    if (icon) {
                        icon.style.color = 'rgba(255, 255, 255, 0.6)';
                        icon.style.transform = 'translateY(-50%) scale(1)';
                    }
                });

                // Add typing animation
                input.addEventListener('input', function() {
                    this.style.borderColor = 'rgba(79, 70, 229, 0.4)';
                });
            });

            // Enhanced checkbox interaction
            const rememberCheckbox = document.getElementById('remember');
            if (rememberCheckbox) {
                rememberCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        this.style.transform = 'scale(1.2)';
                        setTimeout(() => {
                            this.style.transform = 'scale(1)';
                        }, 200);
                    }
                });
            }

            // Add interactive particle effect on mouse move
            let mouseX = 0;
            let mouseY = 0;
            
            document.addEventListener('mousemove', function(e) {
                mouseX = e.clientX;
                mouseY = e.clientY;
                
                // Create interactive glow effect
                const glow = document.createElement('div');
                glow.style.position = 'fixed';
                glow.style.left = mouseX + 'px';
                glow.style.top = mouseY + 'px';
                glow.style.width = '10px';
                glow.style.height = '10px';
                glow.style.background = 'radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%)';
                glow.style.borderRadius = '50%';
                glow.style.pointerEvents = 'none';
                glow.style.transform = 'translate(-50%, -50%)';
                glow.style.transition = 'all 1s ease-out';
                glow.style.zIndex = '9998';
                
                document.body.appendChild(glow);
                
                setTimeout(() => {
                    glow.style.width = '50px';
                    glow.style.height = '50px';
                    glow.style.opacity = '0';
                }, 10);
                
                setTimeout(() => {
                    glow.remove();
                }, 1000);
            });

            // Add entrance animation to form elements
            const formElements = document.querySelectorAll('.form-group, .google-btn, .separator, .auth-links');
            formElements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(30px)';
                element.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                
                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, 100 + (index * 100));
            });
        });
    </script>
</body>

</html>
