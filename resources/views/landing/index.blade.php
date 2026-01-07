<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Caffeshop Landing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('logo seanspace.png') }}">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- CSS Landing khusus --}}
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>


{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg bg-white border-bottom py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#home">Caffeshop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="#gallery">Galeri</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Kontak</a></li>
                 <li class="nav-item">
    <a class="nav-link" href="{{ route('menu') }}">Menu</a>
</li>


                
            </ul>
        </div>
    </div>
</nav>
<body id="home">
{{-- HERO SECTION --}}
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            {{-- Text --}}
            <div class="col-lg-6">
                <div class="hero-badge">
                    Fresh Coffee • Cozy Place
                </div>
                <h1 class="hero-title">
    <span class="hero-title-line-1">
        Welcome to <span class="hero-title-primary">Seanspace</span>
    </span><br>
    Caffeshop
</h1>

                <p class="hero-subtitle">
                    Setiap cangkir diseduh dari biji kopi pilihan,
                    dengan suasana yang hangat dan nyaman untuk bekerja, ngobrol, atau sekadar menikmati hidup.
                </p>

                <div class="d-flex flex-wrap align-items-center gap-3 mt-4">
                    
                    <a href="{{ route('menu') }}" class="btn btn-cta">
    Lihat Menu
</a>

                    <a href="#about" class="btn btn-ghost">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            {{-- Image --}}
            <div class="col-lg-6 mt-5 mt-lg-0">
                <div class="hero-image-wrapper">
                
                    <div class="hero-image-card">
                        <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=900&q=80"
                             alt="Coffee cup">
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

{{-- PROFIL / ABOUT SECTION --}}
<section id="about" class="section section-profile">
    <div class="container">

        {{-- JUDUL --}}
        <div class="text-center mb-4">
            <h2 class="section-title mb-1">Tentang Kami</h2>
            
        </div>

        {{-- FOTO + PARAGRAF --}}
        <div class="row g-4 align-items-center">

            {{-- FOTO --}}
            <div class="col-lg-5">
                <div class="profile-image-card">
                    <img src="https://images.unsplash.com/photo-1504753793650-d4a2b783c15e?auto=format&fit=crop&w=1000&q=80"
                         alt="Coffee machine">
                </div>
            </div>

            {{-- PARAGRAF --}}
            <div class="col-lg-7">
                <p class="mb-3">
                    Caffeshop berdiri sejak 2024 dengan tujuan menghadirkan pengalaman kopi premium
                    yang tetap terjangkau untuk semua kalangan. Kami memilih biji kopi terbaik dari berbagai
                    daerah di Indonesia dan dunia.
                </p>

                <p class="mb-0">
                    Setiap cangkir kopi yang kami sajikan merupakan hasil proses yang teliti, mulai dari
                    pemilihan biji, roasting, hingga brewing. Tim barista kami berpengalaman dan siap
                    memberikan pengalaman terbaik untuk Anda.
                </p>
            </div>
        </div>

        {{-- Misi Kami (FULL WIDTH DI BAWAH) --}}
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="mission-card">
                    <h6>Misi Kami</h6>
                    <ul>
                        <li>Menyajikan kopi berkualitas tinggi dengan harga bersahabat.</li>
                        <li>Menciptakan ruang nyaman untuk berkumpul, bekerja, dan beristirahat.</li>
                        <li>Mendukung petani kopi lokal melalui pemilihan bahan baku.</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- GALLERY SECTION - SLIDER --}}
<section id="gallery" class="gallery-section">
    <div class="container">
        <div class="gallery-wrapper">
            <div class="gallery-header">
                <div class="gallery-header-text">
                    <h2>Galeri Caffeshop</h2>
                    <p>Beberapa sudut favorit dan menu unggulan yang jadi pilihan pelanggan.</p>
                </div>
            </div>

            <div class="gallery-slider">
                <button class="gallery-arrow" id="galleryPrev" aria-label="Sebelumnya">
                    ‹
                </button>

                <div class="gallery-track">
                    <div class="gallery-track-inner" id="galleryTrack">
                        {{-- Slide 1 --}}
                        <article class="gallery-card">
                            <div class="gallery-card-image">
                                <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=1000&q=80"
                                     alt="Interior coffee shop">
                            </div>
                            <div class="gallery-card-content">
                                <h3>Interior Cozy</h3>
                                <p>
                                    Ruang duduk yang hangat dengan pencahayaan lembut, cocok untuk bekerja,
                                    meeting kecil, ataupun sekadar ngobrol santai.
                                </p>
                                <div class="gallery-card-tags">
                                    <span>Area Non-Smoking</span>
                                    <span>Wi-Fi Cepat</span>
                                    <span>Stopkontak Tersedia</span>
                                </div>
                            </div>
                        </article>

                        {{-- Slide 2 --}}
                        <article class="gallery-card">
                            <div class="gallery-card-image">
                                <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=1000&q=80"
                                     alt="Signature coffee">
                            </div>
                            <div class="gallery-card-content">
                                <h3>Signature Coffee</h3>
                                <p>
                                    Pilihan menu kopi andalan dengan racikan khusus barista kami, menggabungkan
                                    cita rasa klasik dan modern.
                                </p>
                                <div class="gallery-card-tags">
                                    <span>Caramel Latte</span>
                                    <span>Hazelnut Coffee</span>
                                    <span>Seasonal Menu</span>
                                </div>
                            </div>
                        </article>

                        {{-- Slide 3 --}}
                        <article class="gallery-card">
                            <div class="gallery-card-image">
                                <img src="https://images.unsplash.com/photo-1459755486867-b55449bb39ff?auto=format&fit=crop&w=1000&q=80"
                                     alt="Community space">
                            </div>
                            <div class="gallery-card-content">
                                <h3>Community Space</h3>
                                <p>
                                    Area yang nyaman untuk komunitas, workshop kecil, atau sesi sharing.
                                    Dapat dipesan untuk acara tertentu.
                                </p>
                                <div class="gallery-card-tags">
                                    <span>Workshop</span>
                                    <span>Sharing Session</span>
                                    <span>Reservasi</span>
                                </div>
                            </div>
                        </article>

                        {{-- Slide 4 --}}
                        <article class="gallery-card">
                            <div class="gallery-card-image">
                                <img src="https://images.unsplash.com/photo-1459755486867-b55449bb39ff?auto=format&fit=crop&w=1000&q=80"
                                     alt="Community space">
                            </div>
                            <div class="gallery-card-content">
                                <h3>Community 4</h3>
                                <p>
                                    Area yang nyaman untuk komunitas, workshop kecil, atau sesi sharing.
                                    Dapat dipesan untuk acara tertentu.
                                </p>
                                <div class="gallery-card-tags">
                                    <span>Workshop</span>
                                    <span>Sharing Session</span>
                                    <span>Reservasi</span>
                                </div>
                            </div>
                        </article>
                        {{-- Slide 5 --}}
                        <article class="gallery-card">
                            <div class="gallery-card-image">
                                <img src="https://images.unsplash.com/photo-1459755486867-b55449bb39ff?auto=format&fit=crop&w=1000&q=80"
                                     alt="Community space">
                            </div>
                            <div class="gallery-card-content">
                                <h3>5</h3>
                                <p>
                                    Area yang nyaman untuk komunitas, workshop kecil, atau sesi sharing.
                                    Dapat dipesan untuk acara tertentu.
                                </p>
                                <div class="gallery-card-tags">
                                    <span>Workshop</span>
                                    <span>Sharing Session</span>
                                    <span>Reservasi</span>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>

                
                

                <button class="gallery-arrow" id="galleryNext" aria-label="Berikutnya">
                    ›
                </button>
            </div>
        </div>
    </div>
</section>
<section id="contact" class="section">
    <div class="container">

        <!-- TITLE -->
        <div class="text-center mb-4">
            <h2 class="section-title mb-1">Informasi Kontak</h2>
            <p class="section-subtitle mb-0">
                Hubungi kami untuk reservasi, pemesanan, atau kerjasama.
            </p>
        </div>

        <!-- CARD WRAPPER -->
        <div class="contact-shell mb-4">

            <!-- ROW 1: INFO UTAMA -->
            <div class="row g-4 mb-3">

                <div class="col-md-3">
                    <h6 class="contact-info-title">
                        <i class="fa-solid fa-location-dot contact-icon"></i> Alamat
                    </h6>
                   <ul class="info-list fw-bold">
                        <li>Jln Andir Rt 01 Rw 02</li>
                        <li>desa Cukanggentng</li>
                    </ul>
                </div>

                <div class="col-md-3">
                    <h6 class="contact-info-title">
                        <i class="fa-regular fa-clock contact-icon"></i> Jam Operasional
                    </h6>
                    <ul class="info-list fw-bold">
                        <li>Senin–Jumat: 08.00–22.00</li>
                        <li>Sabtu–Minggu: 09.00–23.00</li>
                    </ul>
                </div>

                <div class="col-md-3">
                    <h6 class="contact-info-title">
                        <i class="fa-solid fa-phone contact-icon"></i> Telepon
                    </h6>
                    <ul class="info-list fw-bold">
                        <li>08xx-xxxx-xxxx</li>
                        <li>08xx-xxxx-xxxx</li>
                    </ul>
                </div>

                <div class="col-md-3">
                    <h6 class="contact-info-title">
                        <i class="fa-regular fa-envelope contact-icon"></i> Email
                    </h6>
                    <ul class="info-list fw-bold">
                        <li>hello@caffeshop.test</li>
                        <li>reservasi@caffeshop.test</li>
                    </ul>
                </div>

            </div>

            <!-- ROW 2: SOCIAL MEDIA -->
            <div class="row g-4 mb-4">

                <div class="col-md-3">
    <h6 class="contact-info-title">
        <i class="fa-brands fa-instagram contact-icon"></i> Instagram
    </h6>
    <a href="https://instagram.com/caffeshop.id" target="_blank" class="contact-link">
        @caffeshop.id
    </a>
</div>

<div class="col-md-3">
    <h6 class="contact-info-title">
        <i class="fa-brands fa-facebook-f contact-icon"></i> Facebook
    </h6>
    <a href="https://facebook.com/caffeshop" target="_blank" class="contact-link">
        Caffeshop Official
    </a>
</div>

<div class="col-md-3">
    <h6 class="contact-info-title">
        <i class="fa-brands fa-tiktok contact-icon"></i> TikTok
    </h6>
    <a href="https://tiktok.com/@caffeshop.tiktok" target="_blank" class="contact-link">
        @caffeshop.tiktok
    </a>
</div>

<div class="col-md-3">
    <h6 class="contact-info-title">
        <i class="fa-brands fa-whatsapp contact-icon"></i> WhatsApp
    </h6>
    <a href="https://wa.me/628xxxxxxx" target="_blank" class="contact-link">
        Chat via WhatsApp
    </a>
</div>


            </div>

            <!-- ROW 3: MAPS -->
            <iframe 
  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.009048998123!2d107.6186!3d-6.9175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e62f0xxxxxxx%3A0x1234567890abcdef!2sNama%20Tempat!5e0!3m2!1sid!2sid!4v1733750000000!5m2!1sid!2sid" 
  width="100%" 
  height="450" 
  style="border:0;" 
  allowfullscreen="" 
  loading="lazy" 
  referrerpolicy="no-referrer-when-downgrade">
</iframe>


        </div>
    </div>
</section>

<footer class="footer">
    <div class="container d-flex justify-content-between flex-wrap gap-2">
        <span>© {{ date('Y') }} Caffeshop. All rights reserved.</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Slider galeri sederhana
    const track = document.getElementById('galleryTrack');
    const slides = Array.from(track.children);
    let currentIndex = 0;

    function updateGallery() {
        track.style.transform = 'translateX(' + (-currentIndex * 100) + '%)';
    }

    document.getElementById('galleryPrev').addEventListener('click', function () {
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        updateGallery();
    });

    document.getElementById('galleryNext').addEventListener('click', function () {
        currentIndex = (currentIndex + 1) % slides.length;
        updateGallery();
    });
</script>
<script>
document.addEventListener("scroll", () => {
    const sections = document.querySelectorAll("section");
    const navLinks = document.querySelectorAll(".nav-link");

    let current = "";

    sections.forEach(section => {
        const sectionTop = section.offsetTop - 200; 
        if (scrollY >= sectionTop) {
            current = section.getAttribute("id");
        }
    });

    // fallback: kalau belum ada yang ketangkep, paksa 'home'
    if (!current) {
        current = "home";
    }

    navLinks.forEach(link => {
        link.classList.remove("active");
        if (link.getAttribute("href") === "#" + current) {
            link.classList.add("active");
        }
    });
});
</script>

</body>
</html>
