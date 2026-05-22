@extends('layouts.app')

@section('content')
    @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    {{-- HERO --}}
    <section class="hero-elegant">
        <div class="container">
            <div class="row align-items-center">

                <!-- TEXT -->
                <div class="col-lg-6">
                    <span class="hero-badge">
                        💍 Trusted Matrimonial Platform
                    </span>

                    <h1 class="hero-title">
                        Find Love That<br>
                        <span>Lasts Forever</span>
                    </h1>

                    <p class="hero-text">
                        Connecting hearts with verified profiles, secure privacy,
                        and meaningful matches crafted just for you.
                    </p>

                    <a href="{{ route('matches.show') }}" class="btn app-btn-primary">
                        Browse Matches
                    </a>
                </div>

                <!-- IMAGE -->
                <div class="col-lg-6 text-center">
                    <div class="hero-image-wrapper">
                        <img src="{{ asset('images/couple2.jpeg') }}" alt="Happy Couple"
                            style="height: 600px; width: 400px;">
                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- FEATURED PROFILES --}}
    <section class="profiles-section py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h3>Featured Profiles</h3>
            </div>

            <div class="row g-4">
                @forelse($profiles as $profile)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="profile-card-modern">
                                <div class="profile-img-wrapper">
                                    <img src="{{ $profile->images->first()
                    ? asset($profile->images->first()->file_path)
                    : 'https://via.placeholder.com/300' }}">

                                    @if($profile->is_premium)
                                        <span class="premium-badge">Premium</span>
                                    @endif
                                </div>

                                <div class="profile-info">
                                    <h5>{{ $profile->user->name }}, {{ $profile->age }}</h5>
                                    <p>{{ $profile->profession }}</p>

                                    <div class="profile-tags mb-3">
                                        <span>{{ $profile->religion }}</span>
                                        <span>{{ $profile->community }}</span>
                                    </div>

                                    <a href="{{ route('user.show', $profile->id) }}" class="btn btn-view-modern">
                                        View Profile
                                    </a>
                                    <div class="mb-3"></div>
                                </div>
                            </div>
                        </div>
                @empty
                    <p class="text-center text-muted">No profiles available.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Counters --}}
    <section class="counters-section py-5 bg-light">
        <div class="container">
            <div class="row text-center g-4">

                <div class="col-md-3">
                    <div class="counter-card">
                        <h2 class="counter" data-count="200000">0</h2>
                        <p>Verified Profiles</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="counter-card">
                        <h2 class="counter" data-count="5000">0</h2>
                        <p>Happy Couples</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="counter-card">
                        <h2 class="counter" data-count="100">0</h2>
                        <p>Privacy Secured</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="counter-card">
                        <h2 class="counter" data-count="24">0</h2>
                        <p>Support Hours</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- SUCCESS STORIES --}}
    <section class="success-stories-modern">
        <div class="container">

            <!-- Section Header -->
            <div class="text-center mb-5">
                <h4 class="stories-title">Love Stories That Inspire</h4>
                <p class="stories-subtitle">
                    Real journeys of couples who found their forever here
                </p>
            </div>

            <!-- Stories -->
            <div class="row g-4">

                <div class="col-md-4">
                    <div class="story-card-modern">
                        <div class="quote-icon">“</div>
                        <p class="story-text">
                            This platform helped us find each other with trust and comfort.
                        </p>

                        <div class="story-user">
                            <img src="{{ asset('images/couple.jpeg') }}">
                            <div>
                                <strong>Rohan & Priya</strong>
                                <span>Married in 2024</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="story-card-modern">
                        <div class="quote-icon">“</div>
                        <p class="story-text">
                            Genuine profiles and a very respectful experience throughout.
                        </p>

                        <div class="story-user">
                            <img src="{{ asset('images/couple.jpeg') }}">
                            <div>
                                <strong>Akash & Neha</strong>
                                <span>Engaged</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="story-card-modern">
                        <div class="quote-icon">“</div>
                        <p class="story-text">
                            A beautifully designed platform that truly values relationships.
                        </p>

                        <div class="story-user">
                            <img src="{{ asset('images/couple.jpeg') }}">
                            <div>
                                <strong>Vijay & Ritu</strong>
                                <span>Married</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection