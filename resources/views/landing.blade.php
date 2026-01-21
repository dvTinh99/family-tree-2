<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Visualize, edit, and manage your family tree effortlessly with our powerful relationship editor. Support for complex family structures, beautiful auto-layout graphs, and intuitive editing tools.">
    <meta name="keywords" content="family tree builder, family tree software, genealogy app, relationship editor, family tree visualizer">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Family Tree Builder - Visualize Your Family History">
    <meta property="og:description" content="Create beautiful, interactive family trees with our powerful relationship editor. Perfect for complex family structures.">
    <meta property="og:type" content="website">
    <meta property="og:image" content="/social-preview.jpg">
    
    <title>Family Tree Builder - Visualize, Edit & Manage Family Relationships</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --secondary-color: #8b5cf6;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f9fafb;
            --white: #ffffff;
            --shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            z-index: 1000;
            padding: 1rem 0;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary-color);
        }

        .cta-nav {
            background: var(--primary-color);
            color: var(--white) !important;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .cta-nav:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        /* Mobile Menu Toggle */
        .menu-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
        }

        .menu-toggle span {
            width: 25px;
            height: 3px;
            background: var(--text-dark);
            border-radius: 3px;
            transition: all 0.3s;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg width="60" height="60" xmlns="http://www.w3.org/2000/svg"><circle cx="30" cy="30" r="2" fill="white" opacity="0.1"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-text h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-text p {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-primary, .btn-secondary {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 10px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--white);
            color: var(--primary-color);
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: var(--white);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
        }

        .hero-visual {
            position: relative;
        }

        .tree-diagram {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-lg);
        }

        .tree-svg {
            width: 100%;
            height: auto;
        }

        /* Features Section */
        .features {
            padding: 6rem 2rem;
            background: var(--bg-light);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .section-header p {
            font-size: 1.2rem;
            color: var(--text-light);
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: var(--shadow);
            transition: all 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: var(--white);
            margin-bottom: 1.5rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .feature-card p {
            color: var(--text-light);
            line-height: 1.8;
        }

        /* Demo Section */
        .demo {
            padding: 6rem 2rem;
            background: var(--white);
        }

        .demo-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .demo-image {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .demo-image::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            height: 80%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(50px);
        }

        .demo-placeholder {
            width: 100%;
            height: 400px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.2rem;
            position: relative;
            z-index: 1;
        }

        .demo-text h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
        }

        .demo-text p {
            font-size: 1.1rem;
            color: var(--text-light);
            margin-bottom: 1rem;
            line-height: 1.8;
        }

        .demo-features {
            list-style: none;
            margin: 2rem 0;
        }

        .demo-features li {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .demo-features i {
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        /* Testimonials Section */
        .testimonials {
            padding: 6rem 2rem;
            background: var(--bg-light);
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .testimonial-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: var(--shadow);
        }

        .testimonial-text {
            font-size: 1.1rem;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
            line-height: 1.8;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 700;
            font-size: 1.2rem;
        }

        .author-info h4 {
            font-weight: 600;
            color: var(--text-dark);
        }

        .author-info p {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .stars {
            color: #fbbf24;
            margin-bottom: 1rem;
        }

        /* CTA Section */
        .cta-section {
            padding: 6rem 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -250px;
            right: -250px;
        }

        .cta-section::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -150px;
            left: -150px;
        }

        .cta-content {
            position: relative;
            z-index: 1;
        }

        .cta-section h2 {
            font-size: 3rem;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 1.5rem;
        }

        .cta-section p {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Footer */
        footer {
            background: var(--text-dark);
            color: rgba(255, 255, 255, 0.7);
            padding: 3rem 2rem 1.5rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            color: var(--white);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--white);
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            text-decoration: none;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                position: fixed;
                top: 70px;
                right: -100%;
                flex-direction: column;
                background: var(--white);
                width: 100%;
                padding: 2rem;
                box-shadow: var(--shadow);
                transition: right 0.3s;
            }

            .nav-links.active {
                right: 0;
            }

            .menu-toggle {
                display: flex;
            }

            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-text h1 {
                font-size: 2.5rem;
            }

            .hero-buttons {
                justify-content: center;
            }

            .demo-content {
                grid-template-columns: 1fr;
            }

            .section-header h2 {
                font-size: 2rem;
            }

            .cta-section h2 {
                font-size: 2rem;
            }
        }

        /* Animation Classes */
        .fade-in {
            opacity: 0;
        }

        .slide-up {
            opacity: 0;
            transform: translateY(50px);
        }

        .scale-in {
            opacity: 0;
            transform: scale(0.8);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <a href="#" class="logo">
                <i class="fas fa-project-diagram"></i>
                FamilyTree
            </a>
            <button class="menu-toggle" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <ul class="nav-links" id="navLinks">
                <li><a href="#features">Features</a></li>
                <li><a href="#demo">Demo</a></li>
                <li><a href="#testimonials">Testimonials</a></li>
                <li><a href="#cta" class="cta-nav">Get Started</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Visualize, Edit & Manage Your Family Tree Effortlessly</h1>
                <p>Create beautiful, interactive family trees with powerful relationship editing tools. Perfect for complex family structures, genealogy research, and preserving your family history.</p>
                <div class="hero-buttons">
                    <a href="#" class="btn-primary">
                        <i class="fas fa-play-circle"></i>
                        Try Demo
                    </a>
                    <a href="#features" class="btn-secondary">
                        <i class="fas fa-arrow-down"></i>
                        Learn More
                    </a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="tree-diagram">
                    <svg class="tree-svg" viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg">
                        <!-- Family Tree Visualization -->
                        <defs>
                            <linearGradient id="nodeGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:rgba(255,255,255,0.3);stop-opacity:1" />
                                <stop offset="100%" style="stop-color:rgba(255,255,255,0.1);stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        
                        <!-- Connections -->
                        <line x1="200" y1="60" x2="150" y2="140" stroke="rgba(255,255,255,0.4)" stroke-width="2"/>
                        <line x1="200" y1="60" x2="250" y2="140" stroke="rgba(255,255,255,0.4)" stroke-width="2"/>
                        <line x1="150" y1="180" x2="100" y2="240" stroke="rgba(255,255,255,0.4)" stroke-width="2"/>
                        <line x1="150" y1="180" x2="200" y2="240" stroke="rgba(255,255,255,0.4)" stroke-width="2"/>
                        <line x1="250" y1="180" x2="300" y2="240" stroke="rgba(255,255,255,0.4)" stroke-width="2"/>
                        
                        <!-- Nodes -->
                        <circle cx="200" cy="40" r="25" fill="url(#nodeGradient)" stroke="white" stroke-width="2"/>
                        <circle cx="150" cy="160" r="25" fill="url(#nodeGradient)" stroke="white" stroke-width="2"/>
                        <circle cx="250" cy="160" r="25" fill="url(#nodeGradient)" stroke="white" stroke-width="2"/>
                        <circle cx="100" cy="260" r="20" fill="url(#nodeGradient)" stroke="white" stroke-width="2"/>
                        <circle cx="200" cy="260" r="20" fill="url(#nodeGradient)" stroke="white" stroke-width="2"/>
                        <circle cx="300" cy="260" r="20" fill="url(#nodeGradient)" stroke="white" stroke-width="2"/>
                        
                        <!-- Icons -->
                        <text x="200" y="48" text-anchor="middle" fill="white" font-size="16">👴</text>
                        <text x="150" y="168" text-anchor="middle" fill="white" font-size="16">👨</text>
                        <text x="250" y="168" text-anchor="middle" fill="white" font-size="16">👩</text>
                        <text x="100" y="266" text-anchor="middle" fill="white" font-size="14">👦</text>
                        <text x="200" y="266" text-anchor="middle" fill="white" font-size="14">👧</text>
                        <text x="300" y="266" text-anchor="middle" fill="white" font-size="14">👶</text>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-header">
                <h2>Powerful Features for Everyone</h2>
                <p>Everything you need to create, manage, and visualize complex family relationships with ease.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <h3>Beautiful Graph & Auto Layout</h3>
                    <p>Automatically generate stunning family tree visualizations with intelligent hierarchical organization. Nodes are positioned perfectly to show generations, relationships, and connections clearly.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h3>Interactive Editing</h3>
                    <p>Add new family members, edit relationships, and update connections with intuitive drag-and-drop interactions. Real-time updates make exploring your family data effortless.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Complex Family Structures</h3>
                    <p>Support for multiple marriages, blended families, half-siblings, adoptions, and non-traditional relationships. Visualize any family structure without confusion.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-magic"></i>
                    </div>
                    <h3>Smooth Animations</h3>
                    <p>Professional GSAP-powered animations enhance user experience with smooth transitions, scroll-triggered reveals, and motion effects that guide your focus.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Fully Responsive</h3>
                    <p>Perfect experience on all devices - desktop, tablet, and mobile. Your family tree adapts beautifully to any screen size with touch-friendly controls.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3>High Performance</h3>
                    <p>Optimized for speed and efficiency. Handle thousands of family members with smooth rendering and instant updates. Built for genealogy professionals.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Section -->
    <section class="demo" id="demo">
        <div class="container">
            <div class="demo-content">
                <div class="demo-image">
                    <div class="demo-placeholder">
                        <i class="fas fa-project-diagram" style="font-size: 4rem;"></i>
                    </div>
                </div>
                <div class="demo-text">
                    <h2>See It In Action</h2>
                    <p>Our family tree builder makes it easy to visualize even the most complex family relationships. Watch how effortlessly you can:</p>
                    <ul class="demo-features">
                        <li><i class="fas fa-check-circle"></i> Add and connect family members instantly</li>
                        <li><i class="fas fa-check-circle"></i> Visualize multiple generations at once</li>
                        <li><i class="fas fa-check-circle"></i> Edit relationships with simple clicks</li>
                        <li><i class="fas fa-check-circle"></i> Export and share your family tree</li>
                        <li><i class="fas fa-check-circle"></i> Collaborate with family members</li>
                    </ul>
                    <a href="#" class="btn-primary">
                        <i class="fas fa-play-circle"></i>
                        Watch Demo Video
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
        <div class="container">
            <div class="section-header">
                <h2>Loved by Thousands</h2>
                <p>See what our users have to say about their family tree building experience.</p>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"This is hands down the best family tree software I've used. The ability to handle complex relationships like remarriages and adoptions is incredible. My family history is finally complete!"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">SM</div>
                        <div class="author-info">
                            <h4>Sarah Mitchell</h4>
                            <p>Genealogy Researcher</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"The interface is so intuitive! I was able to map out five generations of my family in just a few hours. The auto-layout feature saves so much time and the results look professional."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">JD</div>
                        <div class="author-info">
                            <h4>James Davidson</h4>
                            <p>History Teacher</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Perfect for our blended family! We have a complicated family structure with step-siblings and half-siblings, and this tool handles it beautifully. Everyone can see how we're all connected."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">LR</div>
                        <div class="author-info">
                            <h4>Linda Rodriguez</h4>
                            <p>Family Organizer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" id="cta">
        <div class="cta-content">
            <h2>Start Building Your Family Tree Today</h2>
            <p>Join thousands of users who are preserving their family history with our powerful and easy-to-use platform.</p>
            <div class="hero-buttons">
                <a href="#" class="btn-primary">
                    <i class="fas fa-rocket"></i>
                    Get Started Free
                </a>
                <a href="#" class="btn-secondary">
                    <i class="fas fa-envelope"></i>
                    Contact Sales
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><i class="fas fa-project-diagram"></i> FamilyTree</h3>
                    <p>Build and visualize beautiful family trees with the most powerful relationship editor available.</p>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Product</h3>
                    <ul class="footer-links">
                        <li><a href="#">Features</a></li>
                        <li><a href="#">Pricing</a></li>
                        <li><a href="#">Demo</a></li>
                        <li><a href="#">Documentation</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Company</h3>
                    <ul class="footer-links">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Support</h3>
                    <ul class="footer-links">
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 FamilyTree Builder. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- GSAP Animation Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <script>
        // Register ScrollTrigger plugin
        gsap.registerPlugin(ScrollTrigger);

        // Mobile Menu Toggle
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');

        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        // Close mobile menu when clicking a link
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Hero Section Animations
        gsap.from('.hero-text h1', {
            duration: 1,
            y: 50,
            opacity: 0,
            ease: 'power3.out'
        });

        gsap.from('.hero-text p', {
            duration: 1,
            y: 30,
            opacity: 0,
            delay: 0.3,
            ease: 'power3.out'
        });

        gsap.from('.hero-buttons', {
            duration: 1,
            y: 30,
            opacity: 0,
            delay: 0.6,
            ease: 'power3.out'
        });

        gsap.from('.hero-visual', {
            duration: 1.2,
            scale: 0.8,
            opacity: 0,
            delay: 0.4,
            ease: 'back.out(1.7)'
        });

        // Animate SVG nodes
        gsap.from('.tree-svg circle', {
            duration: 1.5,
            scale: 0,
            opacity: 0,
            stagger: 0.1,
            delay: 1,
            ease: 'elastic.out(1, 0.5)'
        });

        gsap.from('.tree-svg line', {
            duration: 1,
            drawSVG: 0,
            opacity: 0,
            stagger: 0.1,
            delay: 1.2,
            ease: 'power2.inOut'
        });

        // Feature Cards Animation
        gsap.from('.feature-card', {
            scrollTrigger: {
                trigger: '.features-grid',
                start: 'top 80%',
                toggleActions: 'play none none none'
            },
            duration: 0.8,
            y: 50,
            opacity: 0,
            stagger: 0.15,
            ease: 'power3.out'
        });

        // Section Header Animations
        gsap.utils.toArray('.section-header').forEach(header => {
            gsap.from(header.children, {
                scrollTrigger: {
                    trigger: header,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                },
                duration: 0.8,
                y: 30,
                opacity: 0,
                stagger: 0.2,
                ease: 'power3.out'
            });
        });

        // Demo Section Animation
        gsap.from('.demo-image', {
            scrollTrigger: {
                trigger: '.demo',
                start: 'top 70%',
                toggleActions: 'play none none none'
            },
            duration: 1,
            x: -100,
            opacity: 0,
            ease: 'power3.out'
        });

        gsap.from('.demo-text > *', {
            scrollTrigger: {
                trigger: '.demo',
                start: 'top 70%',
                toggleActions: 'play none none none'
            },
            duration: 0.8,
            x: 100,
            opacity: 0,
            stagger: 0.15,
            ease: 'power3.out'
        });

        // Testimonial Cards Animation
        gsap.from('.testimonial-card', {
            scrollTrigger: {
                trigger: '.testimonials-grid',
                start: 'top 80%',
                toggleActions: 'play none none none'
            },
            duration: 0.8,
            y: 50,
            opacity: 0,
            stagger: 0.2,
            ease: 'power3.out'
        });

        // CTA Section Animation
        gsap.from('.cta-content > *', {
            scrollTrigger: {
                trigger: '.cta-section',
                start: 'top 75%',
                toggleActions: 'play none none none'
            },
            duration: 0.8,
            y: 40,
            opacity: 0,
            stagger: 0.2,
            ease: 'power3.out'
        });

        // Parallax effect for hero background
        gsap.to('.hero::before', {
            scrollTrigger: {
                trigger: '.hero',
                start: 'top top',
                end: 'bottom top',
                scrub: true
            },
            y: 200,
            opacity: 0
        });

        // Navbar background on scroll
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                nav.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });
    </script>
</body>
</html>
