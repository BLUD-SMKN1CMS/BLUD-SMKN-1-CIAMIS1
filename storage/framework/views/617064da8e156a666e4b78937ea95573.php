<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?> | BLUD SMKN 1 CIAMIS</title>
    
    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(asset('assets/iconsmea.png')); ?>" type="image/png">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS - Animasi Scroll -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-blue: #4A90E2;
            --light-blue: #87CEEB;
            --sky-blue: #E3F2FD;
            --dark-blue: #1A365D;
            --success: #38A169;
            --soft-bg: #f0f8ff;
            
            /* Warna brand sosial media */
            --facebook: #1877F2;
            --instagram: #E4405F;
            --youtube: #FF0000;
            --tiktok: #000000;
            --whatsapp: #25D366;
            --twitter: #1DA1F2;
            --linkedin: #0A66C2;
        }
        
        * {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }
        
        html {
            scroll-padding-top: 80px;
        }
        
        body {
            background-color: var(--soft-bg);
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }
        
        /* ===== NAVBAR DENGAN ANIMASI ===== */
        .navbar-nav .nav-link {
            font-weight: 500;
            padding: 0.4rem 0.9rem;
            color: #4A5568 !important;
            position: relative;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary-blue) !important;
        }
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            width: 0;
            height: 2px;
            background-color: var(--primary-blue);
            transition: width 0.3s ease, left 0.3s ease;
            transform: translateX(-50%);
        }
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 70%;
        }
        .navbar-brand img {
            height: 42px;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .navbar-brand img:hover {
            transform: scale(1.08) rotate(2deg);
        }
        @media (max-width: 991.98px) {
            .navbar-brand img {
                height: 38px;
            }
            .navbar-brand div {
                line-height: 1.2;
            }
        }
            
        /* ===== BUTTON ANIMATIONS ===== */
        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .btn-primary:hover {
            background-color: var(--dark-blue);
            border-color: var(--dark-blue);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 6px 15px rgba(74, 144, 226, 0.4);
        }
        
        .text-primary { color: var(--primary-blue) !important; }
        .bg-primary { background-color: var(--primary-blue) !important; }
        
        /* ===== HERO SECTION WITH ANIMATION ===== */
        .hero-section {
            background: linear-gradient(135deg, var(--sky-blue) 0%, var(--light-blue) 100%);
            padding: 100px 0 80px;
            border-bottom-left-radius: 60px;
            border-bottom-right-radius: 60px;
            position: relative;
            overflow: hidden;
            animation: gradientMove 15s ease infinite;
            background-size: 200% 200%;
        }
        
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* ===== CAROUSEL YANG SUDAH DIPERBAIKI ===== */
        #heroCarousel {
            position: relative;
            z-index: 1;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15), 0 5px 15px rgba(0, 0, 0, 0.1);
            /* HAPUS BORDER PUTIH, GUNAKAN SHADOW SAJA */
        }
        
        .carousel-inner {
            border-radius: 20px;
            overflow: hidden;
        }
        
        .carousel-item {
            transition: transform 0.8s ease-in-out;
            height: 500px;
        }
        
        .carousel-item img {
            height: 500px;
            object-fit: cover;
            width: 100%;
            border-radius: 20px;
        }
        
        /* CAPTION DENGAN OPACITY RINGAN */
        .carousel-caption {
            position: absolute;
            bottom: 20%;
            left: 10%;
            right: 10%;
            background: rgba(0, 0, 0, 0.5); /* OPACITY DIPERBAIKI - LEBIH TERANG */
            backdrop-filter: blur(8px);
            border-radius: 15px;
            padding: 25px;
            text-align: left;
            transform: translateY(30px);
            opacity: 0;
            transition: all 0.8s ease 0.5s;
            border: 1px solid rgba(255, 255, 255, 0.1); /* BORDER RINGAN */
        }
        
        .carousel-item.active .carousel-caption {
            transform: translateY(0);
            opacity: 1;
        }
        
        .carousel-control-prev,
        .carousel-control-next {
            width: 50px;
            height: 50px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.7;
            transition: all 0.3s ease;
        }
        
        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background: rgba(0, 0, 0, 0.8);
            opacity: 1;
            transform: translateY(-50%) scale(1.1);
        }
        
        .carousel-control-prev {
            left: 20px;
        }
        
        .carousel-control-next {
            right: 20px;
        }
        
        .carousel-indicators {
            bottom: 20px;
        }
        
        .carousel-indicators [data-bs-target] {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 6px;
            background-color: rgba(255, 255, 255, 0.5);
            border: none;
            transition: all 0.3s ease;
        }
        
        .carousel-indicators .active {
            background-color: var(--primary-blue);
            transform: scale(1.3);
            box-shadow: 0 0 10px rgba(74, 144, 226, 0.5);
        }
        
        /* ===== CARDS WITH ENHANCED ANIMATIONS ===== */
        .tefa-card, .product-card {
            border-radius: 16px;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.07);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
            /* overflow: hidden; REMOVED to prevent cutting off floating elements */
            margin-top: 30px; /* Add margin to compensate for floating icon */
        }
        
        .tefa-card::before, .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-blue), var(--light-blue));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s ease;
        }
        
        .tefa-card:hover::before, .product-card:hover::before {
            transform: scaleX(1);
        }
        
        .tefa-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .product-card:hover {
            transform: translateY(-10px) rotateX(5deg);
            box-shadow: 0 15px 30px rgba(0,0,0,0.12);
        }
        
        .tefa-icon {
            width: 80px;
            height: 80px;
            background: var(--sky-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: -40px auto 20px; /* Floating effect restored */
            border: 4px solid white;
            font-size: 30px;
            color: var(--primary-blue);
            transition: all 0.4s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            position: relative;
            z-index: 10; /* Higher z-index to be above card */
        }
        
        .tefa-card:hover .tefa-icon {
            transform: scale(1.1) rotate(5deg);
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            color: white;
        }
        
        .product-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
            transition: transform 0.7s ease;
        }
        
        .product-card:hover .product-img {
            transform: scale(1.08);
        }
        
        /* ===== WHATSAPP FLOAT ANIMATION ===== */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 30px;
            right: 30px;
            background-color: var(--whatsapp);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 28px;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.5);
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            animation: pulse 2s infinite, float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .whatsapp-float:hover {
            background-color: #128C7E;
            transform: scale(1.15) rotate(10deg);
            animation: none;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7); }
            70% { box-shadow: 0 0 0 12px rgba(37, 211, 102, 0); }
            100% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0); }
        }
        
        /* ===== SECTION TITLE ANIMATION ===== */
        .section-title {
            position: relative;
            display: inline-block;
            overflow: hidden;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 4px;
            background: var(--primary-blue);
            border-radius: 2px;
            transition: width 1s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .section-title.animate::after {
            width: 60px;
        }

        /* ===== FOOTER OPTIMIZED WITH ANIMATIONS ===== */
        .footer {
            background: linear-gradient(135deg, #0a192f, #0f2744, #1a365d);
            color: white;
            padding: 60px 0 25px; /* Tambah padding atas bawah */
            position: relative;
            overflow: hidden;
            animation: footerGradient 20s ease infinite;
            background-size: 200% 200%;
            width: 100%;
            /* HAPUS: margin-top: auto; */
        }
        
        @keyframes footerGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, 
                var(--facebook) 0%,
                var(--instagram) 25%,
                var(--youtube) 50%,
                var(--tiktok) 75%,
                var(--whatsapp) 100%
            );
            z-index: 1;
            animation: rainbow 5s linear infinite;
        }
        
        @keyframes rainbow {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }
        
        .footer .footer-wave {
            position: absolute;
            top: 4px;
            left: 0;
            width: 100%;
            height: 60px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='rgba(255,255,255,0.03)' fill-opacity='1' d='M0,224L48,218.7C96,213,192,203,288,181.3C384,160,480,128,576,128C672,128,768,160,864,176C960,192,1056,192,1152,170.7C1248,149,1344,107,1392,85.3L1440,64L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z'%3E%3C/path%3E%3C/svg%3E");
            background-size: cover;
            opacity: 0.5;
            animation: waveMove 20s linear infinite;
        }
        
        @keyframes waveMove {
            0% { background-position: 0 0; }
            100% { background-position: 1000px 0; }
        }

        .footer-title {
            position: relative;
            padding-bottom: 12px;
            margin-bottom: 20px;
            display: inline-block;
            font-size: 18px;
        }
        
        .footer-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--primary-blue);
            border-radius: 2px;
            transition: width 0.5s ease;
        }
        
        .footer-title:hover::after {
            width: 60px;
        }

        .footer-contact .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 12px;
            transition: transform 0.3s ease;
        }
        
        .footer-contact .contact-item:hover {
            transform: translateX(5px);
        }
        
        .footer-contact .contact-icon {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            flex-shrink: 0;
            color: var(--primary-blue);
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .footer-contact .contact-item:hover .contact-icon {
            background: var(--primary-blue);
            color: white;
            transform: rotate(10deg);
        }

        /* Link TEFA dengan hover animation */
        .footer-links ul {
            padding-left: 0;
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 10px;
            position: relative;
            padding-left: 18px;
            transition: all 0.3s ease;
        }
        
        .footer-links li:hover {
            transform: translateX(5px);
        }
        
        .footer-links li::before {
            content: '›';
            position: absolute;
            left: 0;
            color: var(--primary-blue);
            font-size: 16px;
            transition: transform 0.3s ease;
        }
        
        .footer-links li:hover::before {
            transform: translateX(3px);
        }
        
        .footer-links a {
            color: #d1d8e0 !important;
            text-decoration: none !important;
            transition: all 0.4s ease !important;
            display: inline-block;
            font-size: 14px;
        }
        
        .footer-links a:hover {
            color: var(--primary-blue) !important;
            transform: translateX(5px);
        }

        /* ===== SOSIAL MEDIA ANIMATIONS ===== */
        .social-media-section {
            margin-top: 15px;
        }
        
        .social-title {
            font-size: 16px;
            margin-bottom: 12px;
            color: #fff;
            transition: transform 0.3s ease;
        }
        
        .social-icons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }
        
        .social-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.6s;
        }
        
        .social-icon:hover::before {
            left: 100%;
        }
        
        /* Warna latar sesuai platform */
        .social-icon.facebook { background: var(--facebook); }
        .social-icon.instagram { background: linear-gradient(45deg, #833AB4, #E1306C, #F77737); }
        .social-icon.youtube { background: var(--youtube); }
        .social-icon.tiktok { background: #000000; }
        .social-icon.whatsapp { background: var(--whatsapp); }
        .social-icon.twitter { background: var(--twitter); }
        
        /* Efek hover dengan animasi yang lebih menarik */
        .social-icon:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
        
        .social-icon.facebook:hover { box-shadow: 0 8px 20px rgba(24, 119, 242, 0.4); }
        .social-icon.instagram:hover { box-shadow: 0 8px 20px rgba(228, 64, 95, 0.4); }
        .social-icon.youtube:hover { box-shadow: 0 8px 20px rgba(255, 0, 0, 0.4); }
        .social-icon.tiktok:hover { box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4); }
        .social-icon.whatsapp:hover { box-shadow: 0 8px 20px rgba(37, 211, 102, 0.4); }

        /* FOOTER BOTTOM */
        .footer-bottom {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            transition: transform 0.4s ease;
        }
        
        .footer-logo:hover {
            transform: scale(1.05);
        }
        
        .footer-logo img {
            height: 35px;
            margin-right: 10px;
            transition: transform 0.4s ease;
        }
        
        .footer-logo:hover img {
            transform: rotate(5deg);
        }
        
        .footer-logo h6 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }
        
        .copyright {
            font-size: 13px;
            color: #a0aec0;
            line-height: 1.4;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }
        
        .copyright:hover {
            opacity: 1;
        }
        
        /* ===== CUSTOM SCROLLBAR - MODERN & ANIMATED ===== */
::-webkit-scrollbar {
    width: 12px;
}

::-webkit-scrollbar-track {
    background: transparent; /* Transparan untuk efek mengambang */
    border-radius: 12px;
    margin: 10px 0; /* Memberi jarak di ujung atas/bawah */
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, var(--primary-blue), var(--light-blue), #90f7ff);
    border-radius: 12px;
    border: 2px solid transparent; /* Untuk efek inset glow */
    background-clip: padding-box;
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    box-shadow: 0 0 8px rgba(100, 200, 255, 0.3); /* Soft glow */
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, var(--dark-blue), var(--primary-blue), #4facfe);
    transform: scale(1.05);
    box-shadow: 
        0 0 12px rgba(100, 200, 255, 0.6),
        0 0 20px rgba(70, 150, 255, 0.4);
}

/* Efek saat sedang di-drag (opsional, tapi butuh JS untuk full support) */
::-webkit-scrollbar-thumb:active {
    background: linear-gradient(135deg, #2b5876, #4e4376);
    box-shadow: 0 0 15px rgba(50, 100, 255, 0.8);
    transition: all 0.2s ease;
}
        
        /* ===== LOADING ANIMATION ===== */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        
        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid var(--sky-blue);
            border-top: 5px solid var(--primary-blue);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* ===== FADE IN ANIMATION ===== */
        .fade-in {
            animation: fadeIn 1s ease forwards;
            opacity: 0;
        }
        
        @keyframes fadeIn {
            to { opacity: 1; }
        }
        
        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .footer {
                padding: 40px 0 15px;
            }
            
            .social-icon {
                width: 38px;
                height: 38px;
                font-size: 16px;
            }
            
            .footer-title {
                font-size: 16px;
            }
            
            .footer-links a {
                font-size: 13px;
            }
            
            .footer-contact .contact-item {
                margin-bottom: 10px;
            }
            
            .tefa-card:hover, .product-card:hover {
                transform: translateY(-5px);
            }
            
            .carousel-caption {
                bottom: 10%;
                left: 5%;
                right: 5%;
                padding: 15px;
                background: rgba(0, 0, 0, 0.6); /* Sedikit lebih gelap di mobile untuk readability */
            }
            
            .carousel-caption h2 {
                font-size: 1.5rem;
            }
            
            .carousel-caption p {
                font-size: 0.9rem;
            }
            
            .carousel-control-prev,
            .carousel-control-next {
                width: 40px;
                height: 40px;
            }
        }
        
        @media (max-width: 576px) {
            .footer {
                padding: 30px 0 10px;
            }
            
            .footer-bottom {
                margin-top: 20px;
                padding-top: 12px;
            }
            
            .carousel-caption {
                bottom: 5%;
                padding: 10px;
                background: rgba(0, 0, 0, 0.65); /* Sedikit lebih gelap di mobile kecil */
            }
            
            .carousel-caption h2 {
                font-size: 1.2rem;
                margin-bottom: 5px;
            }
            
            .carousel-caption p {
                font-size: 0.8rem;
                margin-bottom: 10px;
            }
            
            #heroCarousel {
                border-radius: 15px;
            }
        }
    </style>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-spinner"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-2">
        <div class="container">
            <!-- Logo & Brand -->
            <a class="navbar-brand d-flex align-items-center text-decoration-none" href="<?php echo e(route('home')); ?>">
                <img src="<?php echo e(asset('assets/iconsmea.png')); ?>" alt="Logo BLUD" class="me-2">
                <div>
                    <div class="fw-bold text-primary mb-0" style="font-size: 1.15rem;">BLUD SMKN 1 CIAMIS</div>
                    <small class="text-muted d-none d-md-block" style="font-size: 0.8rem;">Teaching Factory Products & Services</small>
                </div>
            </a>

            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Nav Menu -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('about') ? 'active' : ''); ?>" href="<?php echo e(route('about')); ?>">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('faq') ? 'active' : ''); ?>" href="<?php echo e(route('faq')); ?>">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(request()->routeIs('home') ? '#tefa-section' : url('/#tefa-section')); ?>">TEFA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(request()->routeIs('home') ? '#produk-section' : url('/#produk-section')); ?>">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(request()->routeIs('home') ? '#layanan-section' : url('/#layanan-section')); ?>">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(request()->routeIs('home') ? '#kontak-section' : url('/#kontak-section')); ?>">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer Optimized -->
<footer class="footer">
    <div class="footer-wave"></div>
    
    <div class="container position-relative">
        <div class="row">
            <!-- Kontak - DINAMIS DARI DATABASE -->
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">
                <h5 class="footer-title fw-bold">BLUD SMKN 1 CIAMIS</h5>
                <div class="footer-contact">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <?php
                                $addressLines = explode(',', $contactInfo['company_address']);
                            ?>
                            <?php $__currentLoopData = $addressLines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p class="mb-0 small"><?php echo e(trim($line)); ?></p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <p class="mb-0 small"><?php echo e($contactInfo['company_email']); ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <p class="mb-0 small"><?php echo e($contactInfo['company_phone']); ?></p>
                        </div>
                    </div>

                    <!-- Jam Operasional - DINAMIS DARI DATABASE -->
<div class="operating-hours mt-3">
    <h6 class="social-title mb-2">Jam Operasional</h6>
    <ul class="list-unstyled small">
        <li><i class="fas fa-clock me-1"></i> <?php echo e($contactInfo['opening_hours_weekdays'] ?? 'Senin - Jumat: 08:00 - 16:00'); ?></li>
        <li><i class="fas fa-clock me-1"></i> <?php echo e($contactInfo['opening_hours_saturday'] ?? 'Sabtu: 08:00 - 14:00'); ?></li>
        <li><i class="fas fa-clock me-1"></i> <?php echo e($contactInfo['opening_hours_sunday'] ?? 'Minggu & Hari Libur: Tutup'); ?></li>
    </ul>
</div>
                </div>
            </div>

            <!-- TEFA Jurusan - DINAMIS DARI DATABASE -->
<div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
    <h5 class="footer-title fw-bold">TEFA Jurusan</h5>
    <div class="footer-links">
        <ul>
            <?php $__currentLoopData = $footerTefas ?? $tefas ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tefa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($tefa->is_active): ?>
                <li>
                    <a href="<?php echo e(route('tefa.show', $tefa->slug)); ?>">
                        <i class="fas fa-arrow-right me-1 small"></i>
                        <?php echo e($tefa->name); ?>

                    </a>
                </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</div>

            <!-- Layanan & Sosial Media -->
            <div class="col-lg-4 col-md-12 mb-4" data-aos="fade-up" data-aos-delay="200">
                <h5 class="footer-title fw-bold">Layanan Sewa</h5>
                <div class="footer-links mb-3">
                    <ul>
                       <?php $__currentLoopData = $footerServices ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(route('service.show', $service->slug)); ?>">
                                    <i class="fas fa-arrow-right me-1 small"></i>
                                    <?php echo e($service->name); ?>

                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                
<!-- Sosial Media -->
<div class="social-media-section">
    <h6 class="social-title">Ikuti Kami</h6>
    
    <div class="social-icons">
        <?php
            // Ambil data dengan fallback
            $fb = $socialMedia['facebook'] ?? '#';
            $ig = $socialMedia['instagram'] ?? '#';
            $yt = $socialMedia['youtube'] ?? '#';
            $tt = $socialMedia['tiktok'] ?? '#';
            $tw = $socialMedia['twitter'] ?? '#';
        ?>
        
        <!-- Facebook -->
        <?php if($fb != '' && $fb != '#'): ?>
        <a href="<?php echo e($fb); ?>" class="social-icon facebook" target="_blank">
            <i class="fab fa-facebook-f"></i>
        </a>
        <?php else: ?>
        <!-- Fallback jika tidak ada data -->
        <a href="#" class="social-icon facebook" target="_blank" style="opacity: 0.6;">
            <i class="fab fa-facebook-f"></i>
        </a>
        <?php endif; ?>
        
        <!-- Instagram -->
        <?php if($ig != '' && $ig != '#'): ?>
        <a href="<?php echo e($ig); ?>" class="social-icon instagram" target="_blank">
            <i class="fab fa-instagram"></i>
        </a>
        <?php else: ?>
        <a href="#" class="social-icon instagram" target="_blank" style="opacity: 0.6;">
            <i class="fab fa-instagram"></i>
        </a>
        <?php endif; ?>
        
        <!-- YouTube -->
        <?php if($yt != '' && $yt != '#'): ?>
        <a href="<?php echo e($yt); ?>" class="social-icon youtube" target="_blank">
            <i class="fab fa-youtube"></i>
        </a>
        <?php else: ?>
        <a href="#" class="social-icon youtube" target="_blank" style="opacity: 0.6;">
            <i class="fab fa-youtube"></i>
        </a>
        <?php endif; ?>
        
        <!-- TikTok -->
        <?php if($tt != '' && $tt != '#'): ?>
        <a href="<?php echo e($tt); ?>" class="social-icon tiktok" target="_blank">
            <i class="fab fa-tiktok"></i>
        </a>
        <?php else: ?>
        <a href="#" class="social-icon tiktok" target="_blank" style="opacity: 0.6;">
            <i class="fab fa-tiktok"></i>
        </a>
        <?php endif; ?>
        
        <!-- Twitter -->
        <?php if($tw != '' && $tw != '#'): ?>
        <a href="<?php echo e($tw); ?>" class="social-icon twitter" target="_blank">
            <i class="fab fa-twitter"></i>
        </a>
        <?php endif; ?>
    </div>
</div>
</div>

        <!-- Footer Bottom -->
        <div class="footer-bottom" data-aos="fade-up" data-aos-delay="300">
            <div class="footer-logo" id="secret-logo-trigger" style="cursor: pointer; user-select: none;">
                <img src="<?php echo e(asset('assets/iconsmea.png')); ?>" alt="Logo BLUD">
                <h6 class="text-white">BLUD SMKN 1 CIAMIS</h6>
            </div>
            <p class="copyright mb-0" id="secret-copyright-trigger" style="cursor: pointer; user-select: none;">
                &copy; <?php echo e(date('Y')); ?> BLUD SMKN 1 CIAMIS. All rights reserved. | 
                <span class="text-primary">Versi 1.0.0</span>
            </p>
        </div>
    </div>
</footer>

<!-- WhatsApp Floating Button - DINAMIS DARI DATABASE -->
<a href="https://wa.me/<?php echo e($contactInfo['whatsapp_number'] ?? '6281234567890'); ?>?text=<?php echo e(urlencode($contactInfo['whatsapp_message'] ?? 'Halo, saya tertarik dengan layanan BLUD SMKN 1 Ciamis')); ?>" 
   class="whatsapp-float" target="_blank" data-aos="zoom-in" data-aos-delay="1000">
    <i class="fab fa-whatsapp"></i>
</a>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
            easing: 'ease-in-out'
        });

        // Page loader
        window.addEventListener('load', function() {
            setTimeout(function() {
                const loader = document.getElementById('pageLoader');
                loader.style.opacity = '0';
                loader.style.visibility = 'hidden';
                
                // Animate section titles
                document.querySelectorAll('.section-title').forEach(title => {
                    title.classList.add('animate');
                });
                
                // Add fade-in class to elements
                document.querySelectorAll('.fade-in').forEach(el => {
                    el.style.animationDelay = '0.3s';
                });
                
                // Initialize carousel with auto play - FIXED
                initializeCarousel();
            }, 500);
        });

        // Carousel initialization function - FIXED AUTO SLIDE
        function initializeCarousel() {
            const carouselElement = document.getElementById('heroCarousel');
            if (carouselElement) {
                // Initialize Bootstrap Carousel dengan auto play YANG BENAR
                const carousel = new bootstrap.Carousel(carouselElement, {
                    interval: 5000, // 5 detik
                    ride: true, // INI YANG BENAR untuk auto play
                    wrap: true,
                    pause: 'hover',
                    keyboard: true
                });
                
                console.log('Carousel initialized with auto-play (ride: true)');
                
                // FIX: JANGAN panggil cycle() manual karena 'ride: true' sudah handle
                // carousel.cycle(); // HAPUS BARIS INI
                
                // Manual start untuk memastikan
                carouselElement.addEventListener('shown.bs.carousel', function() {
                    // Reset interval jika diperlukan
                    if (carousel._interval) {
                        clearInterval(carousel._interval);
                    }
                    carousel._interval = setInterval(function() {
                        carousel.next();
                    }, 5000);
                });
                
                // Start interval pertama kali
                if (!carousel._interval) {
                    carousel._interval = setInterval(function() {
                        carousel.next();
                    }, 5000);
                }
            }
        }

        // Alternatif: Bootstrap 5 Carousel dengan auto-play SIMPLE
        document.addEventListener('DOMContentLoaded', function() {
            const carouselElement = document.getElementById('heroCarousel');
            if (carouselElement) {
                // Cara paling sederhana untuk Bootstrap 5
                const carousel = new bootstrap.Carousel(carouselElement, {
                    interval: 5000,
                    ride: 'carousel', // Ini untuk auto-play
                    wrap: true
                });
                
                console.log('Bootstrap 5 Carousel initialized with ride:carousel');
            }
        });

        // Smooth scroll untuk navigasi
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Efek hover untuk ikon sosial media
        document.querySelectorAll('.social-icon').forEach(icon => {
            icon.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.1)';
            });
            
            icon.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Navbar active highlight on scroll
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('section');
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (scrollY >= (sectionTop - 100)) {
                    current = section.getAttribute('id');
                }
            });
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });

        // Add animation to cards on mouse enter
        document.querySelectorAll('.tefa-card, .product-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.zIndex = '10';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.zIndex = '1';
            });
        });

        // Form submission animation
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
                    submitBtn.disabled = true;
                }
            });
        });

        // Pastikan carousel berjalan otomatis - FIXED
        document.addEventListener('DOMContentLoaded', function() {
            // Coba dua cara untuk memastikan auto-play bekerja
            setTimeout(function() {
                const carouselElement = document.getElementById('heroCarousel');
                if (carouselElement) {
                    // Cara 1: Bootstrap default
                    const carousel = new bootstrap.Carousel(carouselElement, {
                        interval: 5000,
                        ride: 'carousel'
                    });
                    
                    // Cara 2: Manual interval sebagai backup
                    let manualInterval = setInterval(function() {
                        carousel.next();
                    }, 5000);
                    
                    // Pause pada hover
                    carouselElement.addEventListener('mouseenter', function() {
                        clearInterval(manualInterval);
                    });
                    
                    carouselElement.addEventListener('mouseleave', function() {
                        manualInterval = setInterval(function() {
                            carousel.next();
                        }, 5000);
                    });
                }
            }, 1000);
        });
        // Secret Login Trigger (3x click)
        const secretTriggers = ['secret-logo-trigger', 'secret-copyright-trigger'];
        let clickCount = 0;
        let clickTimer;

        secretTriggers.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('click', function(e) {
                    // Prevent default behavior if needed (though div/p usually don't have any)
                    
                    clickCount++;
                    
                    // Reset timer on each click
                    clearTimeout(clickTimer);
                    
                    // If 3 clicks reached
                    if (clickCount >= 3) {
                        // Create a ripple effect or visual feedback
                        const ripple = document.createElement('div');
                        ripple.style.position = 'fixed';
                        ripple.style.top = '0';
                        ripple.style.left = '0';
                        ripple.style.width = '100%';
                        ripple.style.height = '100%';
                        ripple.style.background = 'white';
                        ripple.style.opacity = '0';
                        ripple.style.transition = 'opacity 0.5s';
                        ripple.style.zIndex = '9999';
                        document.body.appendChild(ripple);
                        
                        // Flash effect
                        requestAnimationFrame(() => {
                            ripple.style.opacity = '1';
                        });
                        
                        setTimeout(() => {
                            window.location.href = "<?php echo e(route('admin.login')); ?>";
                        }, 500);
                        
                        // Reset count
                        clickCount = 0;
                        return;
                    }
                    
                    // Reset count if no next click within 500ms
                    clickTimer = setTimeout(() => {
                        clickCount = 0;
                    }, 500);
                });
            }
        });
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\RISWAN\BLUD-SMKN-1-CIAMIS1\resources\views/layouts/app.blade.php ENDPATH**/ ?>