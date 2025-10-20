<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد کاربری - منطقه هیجان</title>

    <!-- Vazir Font -->
    <link href="https://cdn.jsdelivr.net/npm/vazir-font@30.1.0/dist/font-face.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Vazir', sans-serif;
        }

        html, body {
            height: 100%;
            width: 100%;
            overflow-x: hidden;
        }

        body {
            background: linear-gradient(135deg, #0a0e27 0%, #1a1a2e 50%, #16213e 100%);
            color: #fff;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        /* Animated Background Particles */
        .particles {
            position: fixed;
            width: 100%;
            height: 100%;
            overflow: hidden;
            top: 0;
            left: 0;
            z-index: 0;
            pointer-events: none;
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
            position: fixed;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.4;
            animation: pulse 10s infinite ease-in-out;
            pointer-events: none;
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
            bottom: -100px;
            left: -100px;
            animation-delay: 2s;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.4;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.6;
            }
        }

        /* Dashboard Layout */
        .dashboard-wrapper {
            display: flex;
            flex: 1;
            min-height: 100vh;
            width: 100%;
            position: relative;
            z-index: 1;
            padding-top: 80px; /* Increased to prevent content overlap */
        }

        /* Header Styles - New Admin Panel Style */
        .dashboard-header {
            height: 80px;
            background: linear-gradient(90deg, rgba(10, 14, 39, 0.95), rgba(30, 20, 60, 0.95));
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 255, 255, 0.2);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            justify-content: space-between;
            flex-wrap: nowrap;
        }

        .header-brand {
            display: flex;
            align-items: center;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-left: 1rem;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.7);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 10px rgba(0, 255, 255, 0.3);
        }

        .header-actions {
            margin-right: auto;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-search {
            position: relative;
            width: 300px;
        }

        .header-search input {
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(0, 255, 255, 0.2);
            border-radius: 30px;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            color: #fff;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .header-search input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(0, 255, 255, 0.5);
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.3);
            outline: none;
        }

        .header-search i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }

        .header-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 1.3rem;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            margin: 0 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(0, 255, 255, 0.1);
        }

        .header-icon:hover {
            background: rgba(0, 255, 255, 0.2);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 255, 255, 0.3);
            border-color: rgba(0, 255, 255, 0.3);
        }

        .header-icon .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: linear-gradient(135deg, #ff00ff, #00ffff);
            border-radius: 50%;
            width: 22px;
            height: 22px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            border: 2px solid rgba(10, 14, 39, 0.8);
        }

        .user-profile {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 30px;
            transition: all 0.3s;
        }

        .user-profile:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-left: 0.5rem;
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.5);
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: bold;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .nav-link {
            color: #fff;
            margin: 0 1rem;
            font-weight: 500;
            position: relative;
            transition: all 0.3s;
        }

        .nav-link:hover {
            color: #00ffff;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #00ffff, #ff00ff);
            transition: width 0.3s;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .btn-neon {
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border: none;
            border-radius: 30px;
            padding: 0.5rem 1.5rem;
            color: #fff;
            font-weight: bold;
            position: relative;
            overflow: hidden;
            z-index: 1;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-neon::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #ff00ff, #00ffff);
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .btn-neon:hover::before {
            opacity: 1;
        }

        /* Mobile Menu */
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 300px;
            height: 100vh;
            background: rgba(10, 14, 39, 0.95);
            backdrop-filter: blur(10px);
            z-index: 1000;
            padding: 2rem;
            transition: right 0.3s ease;
            border-left: 1px solid rgba(0, 255, 255, 0.2);
            overflow-y: auto;
        }

        .mobile-menu.active {
            right: 0;
            box-shadow: -5px 0 25px rgba(0, 0, 0, 0.5);
        }

        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 999;
            display: none;
            backdrop-filter: blur(3px);
        }

        .mobile-overlay.active {
            display: block;
        }
        
        .mobile-menu-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(0, 255, 255, 0.2);
        }
        
        .mobile-menu-close {
            background: none;
            border: none;
            color: #fff;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .mobile-menu-close:hover {
            color: #00ffff;
            transform: rotate(90deg);
        }
        
        .mobile-menu-items {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .mobile-menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .mobile-menu-item:hover {
            background: rgba(0, 255, 255, 0.1);
            transform: translateX(-5px);
        }
        
        .mobile-menu-item i {
            margin-left: 1rem;
            font-size: 1.2rem;
            color: rgba(0, 255, 255, 0.8);
        }

        /* Dashboard Styles */
        .dashboard-content {
            position: relative;
            z-index: 10;
            padding: 2rem 0;
        }

        .dashboard-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
            text-align: center;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 10px rgba(0, 255, 255, 0.3);
        }

        .dashboard-card {
            background: linear-gradient(135deg, rgba(15, 25, 50, 0.95), rgba(30, 20, 60, 0.95));
            border-radius: 20px;
            border: 2px solid rgba(0, 255, 255, 0.3);
            backdrop-filter: blur(15px);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            height: 100%;
            height: 100%;
            transition: all 0.4s ease;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
            margin-bottom: 30px;
            overflow: hidden;
            position: relative;
        }

        .dashboard-card:hover {
            transform: translateY(-10px);
            border-color: rgba(255, 0, 255, 0.7);
            box-shadow: 0 20px 50px rgba(255, 0, 255, 0.4);
        }

        .dashboard-card::after {
            content: '';
            position: absolute;
            top: -100%;
            left: -100%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: shine 8s infinite;
        }

        @keyframes shine {
            0% {
                top: -100%;
                left: -100%;
            }
            100% {
                top: 100%;
                left: 100%;
            }
        }

        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-left: 1rem;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.7);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subscription-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .info-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .info-value {
            font-weight: bold;
            font-size: 1.1rem;
            color: #00ffff;
        }

        .progress-container {
            margin: 1.5rem 0;
        }

        .progress {
            height: 10px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            background: linear-gradient(90deg, #00ffff, #ff00ff);
            border-radius: 10px;
        }

        .game-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            margin-bottom: 1rem;
            transition: all 0.3s;
        }

        .game-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(-5px);
        }

        .game-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            margin-left: 1rem;
            object-fit: cover;
            border: 2px solid rgba(0, 255, 255, 0.5);
        }

        .game-info {
            flex-grow: 1;
        }

        .game-title {
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 0.3rem;
        }

        .game-meta {
            display: flex;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .game-meta span {
            margin-left: 1rem;
            display: flex;
            align-items: center;
        }

        .game-meta i {
            margin-left: 0.3rem;
            color: #00ffff;
        }

        .game-action {
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border: none;
            border-radius: 5px;
            padding: 0.5rem 1rem;
            color: #fff;
            font-weight: bold;
            transition: all 0.3s;
        }

        .game-action:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.7);
        }

        .history-item {
            padding: 1rem;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            margin-bottom: 1rem;
            border-right: 3px solid #00ffff;
        }

        .history-date {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 0.5rem;
        }

        .history-title {
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .history-details {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
        }

        .history-price {
            color: #00ffff;
            font-weight: bold;
        }

        .sidebar-nav {
            background: linear-gradient(135deg, rgba(15, 25, 50, 0.95), rgba(30, 20, 60, 0.95));
            border-radius: 20px;
            border: 2px solid rgba(0, 255, 255, 0.3);
            backdrop-filter: blur(15px);
            padding: 1.5rem;
            height: 100%;
            transition: all 0.4s ease;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
            margin-bottom: 30px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-left: 1rem;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.7);
        }

        .user-name {
            font-weight: bold;
            font-size: 1.2rem;
            margin-bottom: 0.2rem;
        }

        .user-plan {
            font-size: 0.8rem;
            padding: 0.2rem 0.5rem;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border-radius: 20px;
            color: #fff;
            display: inline-block;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            border-radius: 10px;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s;
        }

        .nav-item a:hover, .nav-item a.active {
            background: rgba(0, 255, 255, 0.1);
            color: #00ffff;
        }

        .nav-item i {
            margin-left: 0.8rem;
            font-size: 1.2rem;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 2rem 0;
            color: rgba(255, 255, 255, 0.7);
            position: relative;
            z-index: 10;
            border-top: 1px solid rgba(0, 255, 255, 0.2);
            margin-top: 2rem;
        }

        .footer a {
            color: #00ffff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer a:hover {
            color: #ff00ff;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .dashboard-card {
                padding: 1.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .dashboard-card {
                padding: 1.25rem;
            }
            
            .dashboard-title {
                font-size: 2rem;
            }
            
            .card-title {
                font-size: 1.3rem;
            }
        }
        
        @media (max-width: 576px) {
            .dashboard-card {
                padding: 1rem;
            }
            
            .dashboard-title {
                font-size: 1.8rem;
            }
            
            .card-title {
                font-size: 1.2rem;
            }
            
            .game-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .game-icon {
                margin-bottom: 1rem;
                margin-left: 0;
            }
            
            .game-action {
                margin-top: 1rem;
                width: 100%;
            }
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .dashboard-header {
                height: 70px;
                padding: 0 1rem;
                flex-wrap: nowrap;
            }
            
            .dashboard-wrapper {
                padding-top: 70px;
            }
            
            .header-brand {
                flex-shrink: 0;
            }
            
            .logo {
                font-size: 1.2rem;
            }
            
            .logo-icon {
                width: 35px;
                height: 35px;
                font-size: 1.2rem;
            }
            
            .header-actions {
                margin-right: 0;
                flex: 1;
                justify-content: center;
                max-width: 200px;
            }
            
            .header-search {
                width: 100%;
                max-width: 180px;
            }
            
            .header-search input {
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem 0.4rem 2rem;
            }
            
            .header-icon {
                width: 40px;
                height: 40px;
                font-size: 1.1rem;
                margin: 0 5px;
            }
            
            .user-profile {
                padding: 0.3rem;
            }
            
            .user-avatar {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }
            
            .menu-toggle {
                background: none;
                border: none;
                color: #fff;
                font-size: 1.5rem;
                padding: 0.5rem;
                cursor: pointer;
                transition: all 0.3s;
            }
            
            .menu-toggle:hover {
                color: #00ffff;
            }
            
            .dashboard-title {
                font-size: 2rem;
                margin-bottom: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .dashboard-header {
                height: 65px;
                padding: 0 0.5rem;
            }
            
            .dashboard-wrapper {
                padding-top: 65px;
            }
            
            .logo {
                font-size: 1rem;
            }
            
            .logo-icon {
                width: 30px;
                height: 30px;
                font-size: 1rem;
                margin-left: 0.5rem;
            }
            
            .header-search {
                max-width: 150px;
            }
            
            .header-search input {
                font-size: 0.75rem;
                padding: 0.3rem 0.6rem 0.3rem 1.8rem;
            }
            
            .header-icon {
                width: 35px;
                height: 35px;
                font-size: 1rem;
                margin: 0 3px;
            }
            
            .user-avatar {
                width: 30px;
                height: 30px;
                font-size: 0.9rem;
            }
            
            .dashboard-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Background Elements -->
    <div class="particles" id="particles"></div>
    <div class="glow-orb orb-1"></div>
    <div class="glow-orb orb-2"></div>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- Header -->
    <header class="dashboard-header">
        <div class="header-brand">
            <div class="logo-icon">
                <i class="bi bi-lightning-charge-fill"></i>
            </div>
            <div class="logo">منطقه هیجان</div>
        </div>
        <div class="header-actions">
            <div class="header-search">
                <input type="text" placeholder="جستجو...">
                <i class="bi bi-search"></i>
            </div>
            <div class="d-none d-md-flex">
                <a href="#" class="nav-link">داشبورد</a>
                <a href="#" class="nav-link">بازی‌ها</a>
                <a href="#" class="nav-link">پشتیبانی</a>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <div class="header-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" title="اعلان‌ها">
                <i class="bi bi-bell-fill"></i>
                <span class="badge">3</span>
            </div>
            <div class="header-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" title="پیام‌ها">
                <i class="bi bi-envelope-fill"></i>
                <span class="badge">5</span>
            </div>
            <div class="header-icon d-none d-md-flex" data-bs-toggle="tooltip" data-bs-placement="bottom" title="تنظیمات">
                <i class="bi bi-gear-fill"></i>
            </div>
            <div class="header-icon d-none d-md-flex" data-bs-toggle="tooltip" data-bs-placement="bottom" title="راهنما">
                <i class="bi bi-question-circle-fill"></i>
            </div>
            <!-- <div class="user-profile">
                <div class="user-avatar">
                    ک
                </div>
                <div class="user-info d-none d-md-block">
                    <div class="user-name">کاربر تریل‌زون</div>
                    <div class="user-role">کاربر ویژه</div>
                </div>
            </div> -->
            <button class="menu-toggle d-md-none ms-2" id="menuToggle">
                <i class="bi bi-list"></i>
            </button>
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
            <a href="/" class="nav-link" style="margin: 0; font-size: 1.2rem;">صفحه اصلی</a>
            <a href="/about" class="nav-link" style="margin: 0; font-size: 1.2rem;">درباره ما</a>
            <a href="/faq" class="nav-link" style="margin: 0; font-size: 1.2rem;">سوالات متداول</a>
            <a href="/tutorial" class="nav-link" style="margin: 0; font-size: 1.2rem;">آموزش</a>
            <a href="/logout" class="btn-neon mt-3" role="button">خروج</a>
        </nav>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <div class="container">
            <h1 class="dashboard-title">داشبورد کاربری</h1>
            
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="sidebar-nav">
                        <div class="user-profile">
                            <div class="user-avatar">👤</div>
                            <div>
                                <div class="user-name">کاربر هیجانی</div>
                                <div class="user-plan">پکیج طلایی</div>
                            </div>
                        </div>
                        
                        <ul class="nav-menu">
                            <li class="nav-item">
                                <a href="#" class="active">
                                    <i class="bi bi-speedometer2"></i>
                                    داشبورد
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#">
                                    <i class="bi bi-controller"></i>
                                    بازی‌های من
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#">
                                    <i class="bi bi-clock-history"></i>
                                    تاریخچه
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#">
                                    <i class="bi bi-credit-card"></i>
                                    اشتراک‌ها
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#">
                                    <i class="bi bi-gear"></i>
                                    تنظیمات
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#">
                                    <i class="bi bi-question-circle"></i>
                                    راهنما
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="col-lg-9 col-md-8">
                    <div class="row">
                        <!-- Subscription Status -->
                        <div class="col-lg-6 col-md-12">
                            <div class="dashboard-card">
                                <div class="card-header">
                                    <div class="card-icon">
                                        <i class="bi bi-hourglass-split"></i>
                                    </div>
                                    <h3 class="card-title">وضعیت اشتراک</h3>
                                </div>
                                
                                <div class="subscription-info">
                                    <div>
                                        <div class="info-label">نوع اشتراک</div>
                                        <div class="info-value">پکیج طلایی</div>
                                    </div>
                                    <div>
                                        <div class="info-label">تاریخ شروع</div>
                                        <div class="info-value">۱۴۰۲/۰۶/۱۵</div>
                                    </div>
                                    <div>
                                        <div class="info-label">تاریخ پایان</div>
                                        <div class="info-value">۱۴۰۲/۱۰/۱۵</div>
                                    </div>
                                </div>
                                
                                <div class="progress-container">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>زمان باقی‌مانده</span>
                                        <span>۶۵ روز از ۱۲۰ روز</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 55%"></div>
                                    </div>
                                </div>
                                
                                <div class="text-center mt-4">
                                    <a href="#" class="btn-neon">تمدید اشتراک</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Game Switch -->
                        <div class="col-lg-6 col-md-12">
                            <div class="dashboard-card">
                                <div class="card-header">
                                    <div class="card-icon">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </div>
                                    <h3 class="card-title">تعویض بازی</h3>
                                </div>
                                
                                <div class="subscription-info">
                                    <div>
                                        <div class="info-label">تعویض‌های باقی‌مانده</div>
                                        <div class="info-value">۲ از ۳</div>
                                    </div>
                                    <div>
                                        <div class="info-label">تاریخ آخرین تعویض</div>
                                        <div class="info-value">۱۴۰۲/۰۷/۲۰</div>
                                    </div>
                                </div>
                                
                                <div class="progress-container">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>زمان تا تعویض بعدی</span>
                                        <span>۵ روز</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 80%"></div>
                                    </div>
                                </div>
                                
                                <div class="text-center mt-4">
                                    <a href="#" class="btn-neon">انتخاب بازی جدید</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Active Games -->
                        <div class="col-12 mt-4">
                            <div class="dashboard-card">
                                <div class="card-header">
                                    <div class="card-icon">
                                        <i class="bi bi-controller"></i>
                                    </div>
                                    <h3 class="card-title">بازی‌های فعال</h3>
                                </div>
                                
                                <div class="game-list">
                                    <div class="game-item">
                                        <img src="https://via.placeholder.com/60x60" alt="بازی" class="game-icon">
                                        <div class="game-info">
                                            <div class="game-title">Call of Duty: Modern Warfare III</div>
                                            <div class="game-meta">
                                                <span><i class="bi bi-calendar-check"></i> فعال از: ۱۴۰۲/۰۶/۱۵</span>
                                                <span><i class="bi bi-clock"></i> ۴۵ ساعت بازی</span>
                                            </div>
                                        </div>
                                        <button class="game-action">اجرای بازی</button>
                                    </div>
                                    
                                    <div class="game-item">
                                        <img src="https://via.placeholder.com/60x60" alt="بازی" class="game-icon">
                                        <div class="game-info">
                                            <div class="game-title">FIFA 24</div>
                                            <div class="game-meta">
                                                <span><i class="bi bi-calendar-check"></i> فعال از: ۱۴۰۲/۰۷/۰۵</span>
                                                <span><i class="bi bi-clock"></i> ۲۸ ساعت بازی</span>
                                            </div>
                                        </div>
                                        <button class="game-action">اجرای بازی</button>
                                    </div>
                                    
                                    <div class="game-item">
                                        <img src="https://via.placeholder.com/60x60" alt="بازی" class="game-icon">
                                        <div class="game-info">
                                            <div class="game-title">Assassin's Creed Mirage</div>
                                            <div class="game-meta">
                                                <span><i class="bi bi-calendar-check"></i> فعال از: ۱۴۰۲/۰۷/۲۰</span>
                                                <span><i class="bi bi-clock"></i> ۱۲ ساعت بازی</span>
                                            </div>
                                        </div>
                                        <button class="game-action">اجرای بازی</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Subscription History -->
                        <div class="col-12 mt-4">
                            <div class="dashboard-card">
                                <div class="card-header">
                                    <div class="card-icon">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <h3 class="card-title">تاریخچه اشتراک‌ها</h3>
                                </div>
                                
                                <div class="history-list">
                                    <div class="history-item">
                                        <div class="history-date">۱۴۰۲/۰۶/۱۵</div>
                                        <div class="history-title">خرید اشتراک پکیج طلایی (۴ ماهه)</div>
                                        <div class="history-details">
                                            <span>شماره سفارش: #TZ-45678</span>
                                            <span class="history-price">۴۵۰,۰۰۰ تومان</span>
                                        </div>
                                    </div>
                                    
                                    <div class="history-item">
                                        <div class="history-date">۱۴۰۲/۰۲/۱۰</div>
                                        <div class="history-title">خرید اشتراک پکیج نقره‌ای (۲ ماهه)</div>
                                        <div class="history-details">
                                            <span>شماره سفارش: #TZ-34567</span>
                                            <span class="history-price">۲۵۰,۰۰۰ تومان</span>
                                        </div>
                                    </div>
                                    
                                    <div class="history-item">
                                        <div class="history-date">۱۴۰۱/۱۱/۲۵</div>
                                        <div class="history-title">خرید اشتراک پکیج برنزی (۱ ماهه)</div>
                                        <div class="history-details">
                                            <span>شماره سفارش: #TZ-23456</span>
                                            <span class="history-price">۱۵۰,۰۰۰ تومان</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
        // Mobile Menu
        const menuToggle = document.getElementById('menuToggle');
        const menuClose = document.getElementById('menuClose');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileOverlay = document.getElementById('mobileOverlay');

        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.add('active');
            mobileOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        menuClose.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
            mobileOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });

        mobileOverlay.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
            mobileOverlay.classList.remove('active');
            document.body.style.overflow = '';
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

        // Add card hover effects
        function addCardHoverEffects() {
            const cards = document.querySelectorAll('.dashboard-card');
            
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px)';
                    this.style.boxShadow = '0 20px 50px rgba(255, 0, 255, 0.4)';
                    this.style.borderColor = 'rgba(255, 0, 255, 0.7)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = '';
                    this.style.boxShadow = '';
                    this.style.borderColor = '';
                });
            });
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            addCardHoverEffects();
        });
    </script>
</body>
</html>