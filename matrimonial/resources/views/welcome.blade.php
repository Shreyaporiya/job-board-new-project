<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Matrimonial | Find Your Perfect Match</title>

    <link rel="icon" href="{{ asset('images/logo3.ico') }}" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>


<body>

{{-- ================= NAVBAR ================= --}}
<nav class="navbar navbar-expand-lg fixed-top bg-white shadow-sm">
    <div class="container">
        <img src="{{ asset('images/logo1.png') }}" alt="Logo" width="80" class="me-2 rounded-3">
        <div>
            <a href="{{ route('login') }}" class="btn btn-outline-danger me-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-danger">Register Free</a>
        </div>
    </div>
</nav>

@if (session('danger'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <strong>{{ session('danger') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- ================= HERO SLIDER ================= --}}
<section class="hero-section">
    <div class="position-relative hero-slider" data-aos="fade-up">

        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('images/image1.jpg') }}">
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1519741497674-611481863552">
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1606800052052-a08af7148866">
                </div>
            </div>
        </div>

        <div class="hero-overlay"></div>

        <div class="hero-content" data-aos="fade-right">
            <h1>Find Your Perfect Life Partner</h1>
            <p>Where trust, tradition and technology create beautiful matches.</p>
            <a href="{{ route('register') }}" class="btn btn-warning btn-lg">
                Get Started
            </a>
        </div>

    </div>
</section>

{{-- ================= WHY CHOOSE US (NEW DESIGN) ================= --}}
<section class="py-5 bg-blush">
    <div class="container">
        <h2 class="text-center text-wine mb-5" data-aos="fade-up">
            Why Choose Our Matrimony
        </h2>

        <div class="row align-items-center">

            <div class="col-md-6" data-aos="fade-right">
                <img src="{{ asset('images/matrimonial-bg.png') }}"
                     class="img-fluid rounded-4 shadow" style="height: 100%; width:100% ;">
            </div>

            <div class="col-md-6">

                <div class="why-box" data-aos="fade-left">
                    <span>✔</span>
                    <div>
                        <h5>100% Verified Profiles</h5>
                        <p>Each profile is manually reviewed for authenticity.</p>
                    </div>
                </div>

                <div class="why-box" data-aos="fade-left" data-aos-delay="100">
                    <span>💖</span>
                    <div>
                        <h5>Compatibility Based Matching</h5>
                        <p>Matches based on values, culture, and lifestyle.</p>
                    </div>
                </div>

                <div class="why-box" data-aos="fade-left" data-aos-delay="200">
                    <span>🔒</span>
                    <div>
                        <h5>Complete Privacy Control</h5>
                        <p>You decide who can view and contact you.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ================= WHO IS THIS FOR ================= --}}
<section class="py-5">
    <div class="container">
        <h2 class="text-center text-wine mb-5" data-aos="fade-up">
            Who Is This Platform For?
        </h2>

        <div class="row text-center">

            <div class="col-md-4" data-aos="zoom-in">
                <div class="soft-card">
                    <h4>👩‍🎓 Professionals</h4>
                    <p>Working individuals looking for compatible partners.</p>
                </div>
            </div>

            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="soft-card">
                    <h4>👨‍👩‍👧 Families</h4>
                    <p>Parents searching trusted matches for loved ones.</p>
                </div>
            </div>

            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="soft-card">
                    <h4>💑 Serious Seekers</h4>
                    <p>People ready for meaningful lifelong relationships.</p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ================= COUNTERS ================= --}}
<section class="py-5 bg-wine text-white text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-3" data-aos="zoom-in">
                <h1 class="text-gold counter" data-target="50000">0</h1>
                <p>Members</p>
            </div>
            <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
                <h1 class="text-gold counter" data-target="12000">0</h1>
                <p>Matches</p>
            </div>
            <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
                <h1 class="text-gold counter" data-target="99">0</h1>
                <p>Verified</p>
            </div>
            <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
                <h1 class="text-gold">24/7</h1>
                <p>Support</p>
            </div>
        </div>
    </div>
</section>

{{-- ================= TRUST SECTION ================= --}}
<section class="py-5 bg-rose text-center">
    <h2 data-aos="fade-up">Trusted by Thousands of Families ❤️</h2>
    <p class="mt-3" data-aos="fade-up" data-aos-delay="100">
        Building relationships with honesty, security and respect.
    </p>
</section>

{{-- ================= FOOTER ================= --}}
<footer class="py-3 text-center bg-wine text-white">
    © {{ date('Y') }} Matrimonial System • Crafted with ❤️
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</body>
</html>
