<![CDATA[<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منطقه هیجان - پلتفرم بازی</title>

    <!-- Vazir Font -->
    <link href="https://cdn.jsdelivr.net/npm/vazir-font@30.1.0/dist/font-face.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    
    <style>
        html, body {
    overflow-x: hidden !important;
}
.indicators {
    flex-direction: row-reverse;
}




        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Vazir', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0a0e27 0%, #1a1a2e 50%, #16213e 100%);
            color: #fff;
            overflow: hidden;
            height: 100vh;
            position: relative;
        }

        /* Animated Background Particles */
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            top: 0;
            left: 0;
            z-index: 0;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: rgba(0, 255, 255, 0.5);
            border-radius: 50%;
            animation: float 15s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translate(var(--tx), var(--ty)) scale(0);
                opacity: 0;
            }
        }

        /* Glowing Background Orbs */
        .glow-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.4;
            animation: pulse 10s infinite ease-in-out;
        }

        .orb-1 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, #00ffff, transparent);
            top: -150px;
            right: -150px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, #ff00ff, transparent);
            bottom: -150px;
            left: -150px;
            animation-delay: 2s;
        }

        .orb-3 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #00ffaa, transparent);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 4s;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.3;
            }
            50% {
                transform: scale(1.3);
                opacity: 0.6;
            }
        }

        /* Header Styles */
        .header {
            position: relative;
            z-index: 1000;
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95), rgba(26, 26, 46, 0.95));
            backdrop-filter: blur(30px);
            border-bottom: 2px solid transparent;
            border-image: linear-gradient(90deg, #00ffff, #ff00ff, #00ffaa) 1;
            padding: 1.2rem 0;
            box-shadow: 0 10px 40px rgba(0, 255, 255, 0.2);
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            animation: logoRotate 20s infinite linear;
            box-shadow: 0 5px 25px rgba(0, 255, 255, 0.5);
            position: relative;
        }

        .logo-icon::before {
            content: '';
            position: absolute;
            inset: -3px;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border-radius: 18px;
            z-index: -1;
            opacity: 0;
            animation: logoPulse 3s infinite;
        }

        @keyframes logoRotate {
            0%, 100% {
                transform: rotateY(0deg);
            }
            50% {
                transform: rotateY(360deg);
            }
        }

        @keyframes logoPulse {
            0%, 100% {
                opacity: 0;
                transform: scale(1);
            }
            50% {
                opacity: 0.5;
                transform: scale(1.2);
            }
        }

        .logo {
            font-size: 2rem;
            font-weight: bold;
            background: linear-gradient(135deg, #00ffff, #ff00ff, #00ffaa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s infinite;
            filter: drop-shadow(0 0 20px rgba(0, 255, 255, 0.5));
        }

        @keyframes shimmer {
            0%, 100% {
                filter: hue-rotate(0deg) drop-shadow(0 0 20px rgba(0, 255, 255, 0.5));
            }
            50% {
                filter: hue-rotate(30deg) drop-shadow(0 0 20px rgba(255, 0, 255, 0.5));
            }
        }

        .nav-link {
            color: #00ffff !important;
            font-weight: 600;
            position: relative;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            margin: 0 1.5rem;
            padding: 0.5rem 1rem;
            font-size: 1.1rem;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #00ffff, #ff00ff);
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            transform: translateX(-50%);
            border-radius: 3px;
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.8);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.1), rgba(255, 0, 255, 0.1));
            border-radius: 10px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .nav-link:hover::after {
            opacity: 1;
        }

        .nav-link:hover::before {
            width: 100%;
        }

        .nav-link:hover {
            color: #ff00ff !important;
            transform: translateY(-3px);
        }

        .btn-neon {
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border: none;
            padding: 0.8rem 2.5rem;
            border-radius: 50px;
            color: #fff;
            font-weight: bold;
            font-size: 1.1rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            box-shadow: 0 5px 25px rgba(0, 255, 255, 0.4);
        }

        .btn-neon::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.7s;
        }

        .btn-neon:hover::before {
            left: 100%;
        }

        .btn-neon::after {
            content: '';
            position: absolute;
            inset: -3px;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border-radius: 50px;
            z-index: -1;
            opacity: 0;
            filter: blur(15px);
            transition: opacity 0.3s;
        }

        .btn-neon:hover::after {
            opacity: 0.8;
        }

        .btn-neon:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 40px rgba(255, 0, 255, 0.6);
        }

        /* Mobile Menu */
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 85%;
            max-width: 400px;
            height: 100vh;
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.98), rgba(26, 26, 46, 0.98));
            backdrop-filter: blur(30px);
            border-left: 3px solid transparent;
            border-image: linear-gradient(180deg, #00ffff, #ff00ff) 1;
            z-index: 2000;
            transition: right 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            padding: 2rem;
            box-shadow: -10px 0 50px rgba(0, 255, 255, 0.3);
        }

        .mobile-menu.active {
            right: 0;
        }

        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            z-index: 1999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s;
        }

        .mobile-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Main Content */
        .main-content {
            position: relative;
            z-index: 1;
            height: calc(100vh - 90px - 45px); /* Adjusted for footer */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 1rem 2rem; /* Reduced top/bottom padding */
        }

        .main-title {
            font-size: 2rem;
            font-weight: bold;
            background: linear-gradient(135deg, #00ffff, #ff00ff, #00ffaa, #00ffff);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
            margin-bottom: 1rem;
            animation: titleFloat 4s infinite ease-in-out, gradientShift 5s infinite;
            filter: drop-shadow(0 0 30px rgba(0, 255, 255, 0.6));
        }

        @keyframes titleFloat {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-15px);
            }
        }

        @keyframes gradientShift {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }

        /* 3D Card Carousel */
        .carousel-3d-container {
            position: relative;
            width: 100%;
            max-width: 1600px;
            height: 600px; /* Reduced height */
            perspective: 2500px;
            margin: 0 auto;
        }

        .carousel-3d {
            position: relative;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            transition: transform 1s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .card-3d {
            position: absolute;
            width: 420px;
            height: 600px;
            left: 50%;
            top: 50%;
            margin-left: -210px;
            margin-top: -300px;
            background: linear-gradient(135deg, rgba(15, 25, 50, 0.95), rgba(30, 20, 60, 0.95));
            border-radius: 30px;
            border: 3px solid rgba(0, 255, 255, 0.3);
            backdrop-filter: blur(30px);
            padding: 2.5rem;
            transform-style: preserve-3d;
            transition: all 1s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            cursor: pointer;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.6);
            overflow: hidden;
        }

        .card-3d:hover {
            border-color: rgba(255, 0, 255, 0.7);
            box-shadow: 0 40px 100px rgba(255, 0, 255, 0.5);
        }

        .card-3d::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.15), rgba(255, 0, 255, 0.15));
            border-radius: 30px;
            opacity: 0;
            transition: opacity 0.1s;
        }

        .card-3d:hover::before {
            opacity: 1;
        }

        .card-3d::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: shine 8s infinite;
        }

        @keyframes shine {
            0% {
                top: -50%;
                left: -50%;
            }
            100% {
                top: 150%;
                left: 150%;
            }
        }

        .card-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            box-shadow: 0 15px 40px rgba(0, 255, 255, 0.6);
            animation: iconFloat 5s infinite ease-in-out;
            position: relative;
        }

        .card-icon::before {
            content: '';
            position: absolute;
            inset: -5px;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border-radius: 50%;
            z-index: -1;
            opacity: 0.5;
            filter: blur(20px);
            animation: iconPulse 3s infinite;
        }

        @keyframes iconFloat {
            0%, 100% {
                transform: translateY(0) rotateY(0deg);
            }
            25% {
                transform: translateY(-10px) rotateY(90deg);
            }
            50% {
                transform: translateY(0) rotateY(180deg);
            }
            75% {
                transform: translateY(-10px) rotateY(270deg);
            }
        }

        @keyframes iconPulse {
            0%, 100% {
                opacity: 0.3;
                transform: scale(1);
            }
            50% {
                opacity: 0.8;
                transform: scale(1.2);
            }
        }

        .card-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            background: linear-gradient(135deg, #ff00ff, #00ffff);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9rem;
            box-shadow: 0 5px 20px rgba(255, 0, 255, 0.5);
            animation: badgeBounce 2s infinite;
        }

        @keyframes badgeBounce {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 0 15px rgba(0, 255, 255, 0.5));
        }

        .card-price {
            text-align: center;
            font-size: 1.3rem;
            font-weight: bold;
            color: #fff;
            margin-bottom: 0.5rem;
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.5));
        }

        .card-duration {
            text-align: center;
            color: #ff00ff;
            font-size: 1rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .card-divider {
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #00ffff, #ff00ff, transparent);
            margin: 1.5rem 0;
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.5);
        }

        .card-features {
            list-style: none;
            padding: 0;
            margin-bottom: 2rem;
            direction: initial;
        }

        .card-features li {
            padding: 0.09rem 0;
            color: #00ffff;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            font-size: 1.05rem;
            transition: all 0.3s;
            
        }

        .card-features li:hover {
            color: #ff00ff;
            transform: translateX(-5px);
        }

        .card-features li::before {
            /* content: '✦'; */
            margin-left: 0.8rem;
            color: #ff00ff;
            font-size: 1.2rem;
            animation: sparkle 2s infinite;
        }

        @keyframes sparkle {
            0%, 100% {
                opacity: 1;
                transform: scale(1) rotate(0deg);
            }
            50% {
                opacity: 0.6;
                transform: scale(1.3) rotate(180deg);
            }
        }

        .card-description {
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        .btn-card {
            width: 100%;
            padding: 1.2rem;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border: none;
            border-radius: 20px;
            color: #fff;
            font-weight: bold;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 255, 255, 0.4);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-card::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.8s, height 0.8s;
        }

        .btn-card:hover::before {
            width: 500px;
            height: 500px;
        }

        .btn-card::after {
            content: '←';
            position: absolute;
            left: 30px;
            opacity: 0;
            transition: all 0.3s;
        }

        .btn-card:hover::after {
            opacity: 1;
            left: 20px;
        }

        .btn-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 50px rgba(255, 0, 255, 0.6);
        }

        /* Navigation Buttons */
        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border: none;
            border-radius: 50%;
            color: #fff;
            font-size: 2rem;
            cursor: pointer;
            z-index: 100;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(0, 255, 255, 0.5);
        }

        .nav-btn::before {
            content: '';
            position: absolute;
            inset: -5px;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border-radius: 50%;
            z-index: -1;
            opacity: 0;
            filter: blur(20px);
            transition: opacity 0.3s;
        }

        .nav-btn:hover::before {
            opacity: 0.8;
        }

        .nav-btn:hover {
            transform: translateY(-50%) scale(1.2) rotate(360deg);
            box-shadow: 0 15px 50px rgba(255, 0, 255, 0.8);
        }

        .nav-btn.prev {
            right: 10px;
        }

        .nav-btn.next {
            left: 10px;
        }

        /* Indicators */
        .indicators {
            position: absolute;
            bottom: 10px; /* Moved inside the container */
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 1rem;
        }

        .indicator {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            border: 2px solid transparent;
        }

        .indicator:hover {
            background: rgba(255, 255, 255, 0.6);
            transform: scale(1.2);
        }

        .indicator.active {
            width: 50px;
            border-radius: 15px;
            background: linear-gradient(90deg, #00ffff, #ff00ff);
            box-shadow: 0 0 25px rgba(0, 255, 255, 0.9);
            border-color: rgba(255, 255, 255, 0.3);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .carousel-3d-container {
                height: 620px;
            }

            .card-3d {
                width: 380px;
                height: 580px;
                margin-left: -190px;
                margin-top: -290px;
            }
        }

        @media (max-width: 768px) {
            .main-title {
                font-size: 2.2rem;
            }

            .carousel-3d-container {
                height: 550px; /* Reduced height */
                perspective: 1500px;
            }

            .card-3d {
                
                width: 320px; /* Reduced width */
                height: 520px; /* Reduced height */
                margin-left: -160px;
                margin-top: -260px;
                padding: 1.8rem;
            }

            .nav-btn {
                width: 60px;
                height: 60px;
            }

            .nav-btn.prev {
                right: 5px;
            }

            .nav-btn.next {
                left: 5px;
            }

            .card-icon {
                width: 100px;
                height: 100px;
                font-size: 3rem;
            }

            .card-title {
                font-size: 2rem;
            }

            .card-price {
                font-size: 2.3rem;
            }
        }

        @media (max-width: 480px) {
            .main-title {
                font-size: 1.8rem;
                margin-bottom: 0.5rem;
            }

            .carousel-3d-container {
                height: 480px;
            }

            .card-3d {
                width: 280px;
                height: 460px;
                margin-left: -150px; /* Adjusted margin for better separation */
                margin-top: -230px;
                padding: 1.3rem; /* Slightly increased padding */
            }

            .card-icon {
                width: 50px;
                height: 50px;
                font-size: 1.6rem;
                margin-bottom: 0.8rem; /* Increased margin */
            }

            .card-title {
                font-size: 1.2rem;
                margin-bottom: 0.5rem;
            }

            .card-price {
                font-size: 1rem;
                margin-bottom: 0.2rem;
            }
            
            .card-duration {
                font-size: 0.75rem;
                margin-bottom: 0.5rem;
            }

            .card-divider {
                margin: 0.8rem 0;
            }

            .card-description {
                font-size: 0.75rem;
                line-height: 1.4;
                margin-bottom: 0.5rem;
            }

            .card-features {
                margin-bottom: 0.8rem;
            }

            .card-features li {
                font-size: 0.8rem;
                padding: 0;
            }

            .btn-card {
                padding: 0.6rem;
                font-size: 0.85rem;
                border-radius: 15px;
            }

            .nav-btn {
                width: 45px;
                height: 45px;
                font-size: 1.3rem;
            }
        }

        /* Mobile Side Cards Visibility */
        @media (max-width: 768px) {
            .carousel-3d {
                overflow: visible;
            }
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 0.8rem 0;
            text-align: center;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.4);
            z-index: 100;
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.5), rgba(26, 26, 46, 0.5));
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(0, 255, 255, 0.1);
        }

        .footer a {
            color: #00ffff;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .footer a:hover {
            color: #ff00ff;
            text-shadow: 0 0 10px rgba(255, 0, 255, 0.7);
        }
    </style>
</head>
<body>
    <!-- Background Elements -->
    <div class="particles" id="particles"></div>
    <div class="glow-orb orb-1"></div>
    <div class="glow-orb orb-2"></div>
    <div class="glow-orb orb-3"></div>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo-container">
                    <div class="logo-icon">🎮</div>
                    <div class="logo">منطقه هیجانی!</div>
                </div>

                <!-- Desktop Menu -->
                <nav class="d-none d-md-flex align-items-center">
                    <a href="/about" class="nav-link">درباره ما</a>
                    <a href="/faq" class="nav-link">سوالات متداول</a>
                    <a href="/tutorial" class="nav-link">آموزش</a>
                    @auth
                        <a href="{{ route('user.dashboard') }}" class="btn-neon" role="button">پنل کاربری</a>
                    @else
                        <a href="/login" class="btn-neon" role="button">ورود / ثبت نام</a>
                    @endauth
                </nav>

                <!-- Mobile Menu Button -->
                <button class="btn btn-link d-md-none text-light p-0" id="menuToggle" style="font-size: 2rem;">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div class="logo-container">
                <div class="logo-icon" style="width: 45px; height: 45px; font-size: 1.5rem;">🎮</div>
                <div class="logo" style="font-size: 1.7rem;">منطقه هیجان</div>
            </div>
            <button class="btn btn-link text-light p-0" id="menuClose" style="font-size: 2rem;">
                <i class="bi bi-x"></i>
            </button>
        </div>
        <nav class="d-flex flex-column gap-4">
            <a href="/about" class="nav-link" style="margin: 0; font-size: 1.2rem;">درباره ما</a>
            <a href="/faq" class="nav-link" style="margin: 0; font-size: 1.2rem;">سوالات متداول</a>
            <a href="/tutorial" class="nav-link" style="margin: 0; font-size: 1.2rem;">آموزش</a>
            @auth
                <a href="{{ route('user.dashboard') }}" class="btn-neon mt-3" role="button">پنل کاربری</a>
            @else
                <a href="/login" class="btn-neon mt-3" role="button">ورود / ثبت نام</a>
            @endauth
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1 class="main-title">پکیج‌های اشتراک بازی</h1>

        <!-- 3D Carousel -->
        <div class="carousel-3d-container">
            <div class="carousel-3d" id="carousel">
                <!-- Cards will be generated by JavaScript -->
            </div>

            <!-- Navigation Buttons -->
            <button class="nav-btn prev" id="prevBtn">
                <i class="bi bi-chevron-right"></i>
            </button>
            <button class="nav-btn next" id="nextBtn">
                <i class="bi bi-chevron-left"></i>
            </button>

            <!-- Indicators -->
            <div class="indicators" id="indicators"></div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <span>© تمامی حقوق برای </span>
        <a href="https://thrillstore.ir" target="_blank">فروشگاه هیجان</a>
        <span> محفوظ است. طراحی و توسعه توسط </span>
        <a href="https://wa.me/989137640338" target="_blank">امین</a>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Card Data
        const cards = [
            {
                title: 'پکیج برنزی',
                price: '۱۵۰,۰۰۰',
                duration: '۱ ماهه',
                icon: '🥉',
                badge: 'مناسب مبتدیان',
                description: 'شروع حرفه‌ای شما در دنیای بازی با امکانات پایه و کیفیت عالی',
                features: ['دسترسی به ۵۰+ بازی محبوب', 'پشتیبانی ۲۴/۷', 'کیفیت تصویر HD', 'بروزرسانی هفتگی', 'بدون محدودیت زمانی']
            },
            {
                title: 'پکیج نقره‌ای',
                price: '۲۵۰,۰۰۰',
                duration: '۲ ماهه',
                icon: '🥈',
                badge: 'محبوب‌ترین',
                description: 'گزینه ایده‌آل برای گیمرهای حرفه‌ای با امکانات گسترده',
                features: ['دسترسی به ۱۰۰+ بازی', 'پشتیبانی اختصاصی', 'کیفیت Full HD', 'دسترسی زودهنگام به بازی‌ها', 'بدون تبلیغات']
            },
            {
                title: 'پکیج طلایی',
                price: '۴۵۰,۰۰۰',
                duration: '۴ ماهه',
                icon: '🥇',
                badge: 'پرفروش',
                description: 'تجربه کامل گیمینگ با دسترسی نامحدود و کیفیت بی‌نظیر',
                features: ['دسترسی نامحدود به همه بازی‌ها', 'پشتیبانی VIP', 'کیفیت 4K Ultra HD', 'محتوای اختصاصی', 'ذخیره ابری نامحدود']
            },
            {
                title: 'پکیج پلاتینیوم',
                price: '۸۰۰,۰۰۰',
                duration: '۶ ماهه',
                icon: '💎',
                badge: 'ویژه',
                description: 'بالاترین سطح خدمات با امکانات پریمیوم و انحصاری',
                features: ['همه امکانات طلایی', 'پشتیبانی اختصاصی ۲۴/۷', 'دسترسی بتا به بازی‌های جدید', 'تخفیف‌های ویژه', 'جوایز ماهانه']
            },
            {
                title: 'پکیج الماس',
                price: '۱,۲۰۰,۰۰۰',
                duration: '۱ سال',
                icon: '👑',
                badge: 'VIP',
                description: 'نهایت تجربه گیمینگ با مربی شخصی و امکانات استثنایی',
                features: ['دسترسی کامل به تمام محتوا', 'مربی اختصاصی', 'تورنمنت‌های اختصاصی', 'پشتیبانی لحظه‌ای', 'هدایای ماهانه ارزشمند']
            }
        ];

        let currentIndex = 0;
        const carousel = document.getElementById('carousel');
        const indicators = document.getElementById('indicators');
        const totalCards = cards.length;

        // Create Cards
        function createCards() {
            cards.forEach((card, index) => {
                const cardEl = document.createElement('div');
                cardEl.className = 'card-3d';
                cardEl.innerHTML = `
                    <div class="card-badge">${card.badge}</div>
                    <div class="card-icon">${card.icon}</div>
                    <h3 class="card-title">${card.title}</h3>
                    <div class="card-price">${card.price} <small style="font-size: 1rem; color: #00ffff;">تومان</small></div>
                    <div class="card-duration">${card.duration}</div>
                    <div class="card-divider"></div>
                    <p class="card-description">${card.description}</p>
                    <ul class="card-features">
                        ${card.features.map(f => `<li>${f}</li>`).join('')}
                    </ul>
                    @auth
                        <a href="{{ route('user.dashboard') }}" class="btn-card">خرید در داشبورد</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-card">ورود و خرید اشتراک</a>
                    @endauth
                `;
                carousel.appendChild(cardEl);
            });
        }

        // Create Indicators
        function createIndicators() {
            cards.forEach((_, index) => {
                const indicator = document.createElement('div');
                indicator.className = 'indicator' + (index === 0 ? ' active' : '');
                indicator.addEventListener('click', () => goToSlide(index));
                indicators.appendChild(indicator);
            });
        }

        // Update Carousel
        function updateCarousel() {
            const cardElements = document.querySelectorAll('.card-3d');
            const indicatorElements = document.querySelectorAll('.indicator');
            const isMobile = window.innerWidth <= 768;

            cardElements.forEach((card, index) => {
                const offset = index - currentIndex;
                const absOffset = Math.abs(offset);

                let translateZ = -absOffset * 450;
                let translateX = offset * 450;
                let rotateY = offset * 40;
                let opacity = absOffset === 0 ? 1 : (isMobile ? 0.4 : 0.3);
                let scale = absOffset === 0 ? 1 : (isMobile ? 0.65 : 0.7);
                let zIndex = totalCards - absOffset;

                if (isMobile) {
                    translateX = offset * 300;
                    translateZ = -absOffset * 300;
                    rotateY = offset * 25;
                }

                card.style.transform = `
                    translateX(${translateX}px)
                    translateZ(${translateZ}px)
                    rotateY(${rotateY}deg)
                    scale(${scale})
                `;
                card.style.opacity = opacity;
                card.style.zIndex = zIndex;
                card.style.pointerEvents = absOffset === 0 ? 'auto' : 'none';
            });

            indicatorElements.forEach((indicator, index) => {
                indicator.classList.toggle('active', index === currentIndex);
            });
        }

        // Navigation
        function goToSlide(index) {
            currentIndex = (index + totalCards) % totalCards;
            updateCarousel();
        }

        function nextSlide() {
            goToSlide(currentIndex + 1);
        }

        function prevSlide() {
            goToSlide(currentIndex - 1);
        }

        // Event Listeners
        document.getElementById('prevBtn').addEventListener('click', nextSlide);
        document.getElementById('nextBtn').addEventListener('click', prevSlide);

        // Auto Slide
        let autoSlide = setInterval(nextSlide, 5000);

        carousel.addEventListener('mouseenter', () => {
            clearInterval(autoSlide);
        });

        carousel.addEventListener('mouseleave', () => {
            autoSlide = setInterval(nextSlide, 5000);
        });

        // Touch Support
        let touchStartX = 0;
        let touchEndX = 0;

        carousel.addEventListener('touchstart', e => {
            touchStartX = e.changedTouches[0].screenX;
            clearInterval(autoSlide);
        });

        carousel.addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
            autoSlide = setInterval(nextSlide, 5000);
        });

        function handleSwipe() {
            if (touchStartX - touchEndX > 50) {
                nextSlide();
            }
            if (touchEndX - touchStartX > 50) {
                prevSlide();
            }
        }

        // Mobile Menu
        const menuToggle = document.getElementById('menuToggle');
        const menuClose = document.getElementById('menuClose');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileOverlay = document.getElementById('mobileOverlay');

        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.add('active');
            mobileOverlay.classList.add('active');
        });

        menuClose.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
            mobileOverlay.classList.remove('active');
        });

        mobileOverlay.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
            mobileOverlay.classList.remove('active');
        });

        // Particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            for (let i = 0; i < 80; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.setProperty('--tx', (Math.random() - 0.5) * 300 + 'px');
                particle.style.setProperty('--ty', (Math.random() - 0.5) * 300 + 'px');
                particle.style.animationDelay = Math.random() * 15 + 's';
                particlesContainer.appendChild(particle);
            }
        }

        // Window Resize Handler
        window.addEventListener('resize', updateCarousel);

        // Initialize
        createCards();
        createIndicators();
        updateCarousel();
        createParticles();
    </script>
</body>
</html>]]>
