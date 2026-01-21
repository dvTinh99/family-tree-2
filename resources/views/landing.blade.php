<!DOCTYPE html>
<html lang="en">
<head>
  <!-- ================= SEO META ================= -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Family Tree Builder – Visual Relationship Editor</title>
  <meta name="description" content="Build, visualize, and edit complex family trees effortlessly. A modern family tree builder with auto layout, GSAP animations, and full mobile support." />

  <!-- Open Graph -->
  <meta property="og:title" content="Family Tree Builder – Visual Relationship Editor" />
  <meta property="og:description" content="Create beautiful family trees. Edit complex relationships with ease." />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="preview.png" />

  <!-- ================= FONTS & ICONS ================= -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <!-- ================= GSAP ================= -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

  <!-- ================= STYLES ================= -->
  <style>
    :root {
      --primary: #4f46e5;
      --secondary: #6366f1;
      --dark: #0f172a;
      --gray: #475569;
      --bg: #f8fafc;
      --radius: 16px;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg);
      color: var(--dark);
      line-height: 1.6;
    }

    img {
      max-width: 100%;
      display: block;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    section {
      padding: 96px 20px;
    }

    .container {
      max-width: 1200px;
      margin: auto;
    }

    /* ================= HERO ================= */
    header {
      background: linear-gradient(135deg, #eef2ff, #ffffff);
      padding: 120px 20px;
    }

    .hero {
      display: grid;
      grid-template-columns: 1.2fr 1fr;
      gap: 48px;
      align-items: center;
    }

    .hero h1 {
      font-size: 3rem;
      font-weight: 700;
      margin-bottom: 20px;
    }

    .hero p {
      font-size: 1.1rem;
      color: var(--gray);
      margin-bottom: 32px;
    }

    .cta {
      display: inline-block;
      background: var(--primary);
      color: #fff;
      padding: 14px 28px;
      border-radius: var(--radius);
      font-weight: 600;
      transition: transform .2s ease, box-shadow .2s ease;
    }

    .cta:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(79,70,229,.3);
    }

    .hero-visual {
      background: white;
      border-radius: var(--radius);
      padding: 24px;
      box-shadow: 0 20px 40px rgba(0,0,0,.08);
    }

    /* ================= FEATURES ================= */
    .features {
      background: #fff;
    }

    .features h2 {
      text-align: center;
      font-size: 2.2rem;
      margin-bottom: 64px;
    }

    .feature-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 32px;
    }

    .feature-card {
      background: var(--bg);
      border-radius: var(--radius);
      padding: 32px;
      transition: transform .2s ease;
    }

    .feature-card:hover {
      transform: translateY(-6px);
    }

    .feature-card i {
      font-size: 1.8rem;
      color: var(--primary);
      margin-bottom: 16px;
    }

    .feature-card h3 {
      margin-bottom: 12px;
      font-size: 1.2rem;
    }

    .feature-card p {
      color: var(--gray);
      font-size: .95rem;
    }

    /* ================= DEMO ================= */
    .demo {
      background: linear-gradient(180deg, #ffffff, #eef2ff);
      text-align: center;
    }

    .demo h2 {
      font-size: 2.2rem;
      margin-bottom: 24px;
    }

    .demo img {
      margin-top: 40px;
      border-radius: var(--radius);
      box-shadow: 0 20px 40px rgba(0,0,0,.1);
    }

    /* ================= TESTIMONIALS ================= */
    .testimonials {
      background: #fff;
    }

    .testimonial-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 32px;
    }

    .testimonial {
      background: var(--bg);
      padding: 28px;
      border-radius: var(--radius);
    }

    .testimonial p {
      font-style: italic;
      margin-bottom: 16px;
    }

    .testimonial strong {
      font-size: .9rem;
    }

    /* ================= FINAL CTA ================= */
    .final-cta {
      text-align: center;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: #fff;
    }

    .final-cta h2 {
      font-size: 2.4rem;
      margin-bottom: 24px;
    }

    /* ================= FOOTER ================= */
    footer {
      background: var(--dark);
      color: #cbd5f5;
      padding: 40px 20px;
      text-align: center;
      font-size: .9rem;
    }

    /* ================= RESPONSIVE ================= */
    @media (max-width: 900px) {
      .hero {
        grid-template-columns: 1fr;
        text-align: center;
      }
    }
  </style>
</head>

<body>

  <!-- ================= HERO ================= -->
  <header>
    <div class="container hero">
      <div>
        <h1>Family Tree Builder & Relationship Editor</h1>
        <p>
          Visualize, edit, and manage complex family relationships effortlessly
          with a modern, interactive family tree builder.
        </p>
        <a href="#demo" class="cta">Try Interactive Demo</a>
      </div>

      <div class="hero-visual">
        <img src="tree-preview.png" alt="Family tree visualization preview" loading="lazy">
      </div>
    </div>
  </header>

  <!-- ================= FEATURES ================= -->
  <section class="features">
    <div class="container">
      <h2>Powerful Features Designed for Clarity</h2>

      <div class="feature-grid">
        <article class="feature-card">
          <i class="fa-solid fa-diagram-project"></i>
          <h3>Beautiful Graph & Auto Layout</h3>
          <p>Automatically generate clean, hierarchical family trees that adapt as data changes.</p>
        </article>

        <article class="feature-card">
          <i class="fa-solid fa-pen-to-square"></i>
          <h3>Interactive Relationship Editing</h3>
          <p>Add, edit, update, or remove family members with intuitive direct interactions.</p>
        </article>

        <article class="feature-card">
          <i class="fa-solid fa-people-arrows"></i>
          <h3>Complex Family Structures</h3>
          <p>Supports blended families, multiple marriages, adoptions, and extended relationships.</p>
        </article>

        <article class="feature-card">
          <i class="fa-solid fa-wand-magic-sparkles"></i>
          <h3>GSAP Animations</h3>
          <p>Smooth, professional animations using GSAP and ScrollTrigger for superior UX.</p>
        </article>

        <article class="feature-card">
          <i class="fa-solid fa-mobile-screen"></i>
          <h3>Responsive & Mobile Friendly</h3>
          <p>Optimized layouts that work seamlessly on desktop, tablet, and mobile devices.</p>
        </article>
      </div>
    </div>
  </section>

  <!-- ================= DEMO ================= -->
  <section class="demo" id="demo">
    <div class="container">
      <h2>See the Family Tree in Action</h2>
      <p>Explore how relationships dynamically adjust in real time.</p>

      <img src="demo.gif" alt="Family tree interactive demo" loading="lazy">
    </div>
  </section>

  <!-- ================= TESTIMONIALS ================= -->
  <section class="testimonials">
    <div class="container">
      <h2>User Feedback</h2>

      <div class="testimonial-grid">
        <div class="testimonial">
          <p>“The best family tree editor I’ve ever used. Handles complex relationships perfectly.”</p>
          <strong>— Genealogy Researcher</strong>
        </div>

        <div class="testimonial">
          <p>“Beautiful UI, smooth animations, and extremely easy to use.”</p>
          <strong>— Product Designer</strong>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= FINAL CTA ================= -->
  <section class="final-cta">
    <div class="container">
      <h2>Start Building Your Family Tree Today</h2>
      <a href="#" class="cta">Get Started Free</a>
    </div>
  </section>

  <!-- ================= FOOTER ================= -->
  <footer>
    © 2026 Family Tree Builder. All rights reserved.
  </footer>

  <!-- ================= GSAP ANIMATIONS ================= -->
  <script>
    gsap.registerPlugin(ScrollTrigger);

    gsap.from(".hero h1, .hero p, .hero .cta", {
      opacity: 0,
      y: 40,
      duration: 1,
      stagger: 0.2
    });

    gsap.utils.toArray(".feature-card").forEach(card => {
      gsap.from(card, {
        scrollTrigger: {
          trigger: card,
          start: "top 85%"
        },
        opacity: 0,
        y: 40,
        duration: 0.6
      });
    });
  </script>

</body>
</html>
