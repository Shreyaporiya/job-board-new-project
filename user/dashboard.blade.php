@extends('layouts.app')

@section('content')

<style>


</style>



<!-- ===================== FEATURED PROFILES SLIDER ===================== -->
<div class="container my-5">
    <h3 class="fw-bold text-primary mb-4">⭐ Featured Profiles</h3>
    <div class="row g-4">
        @foreach($profiles as $profile)
        <div class="col-md-3">
            <div class="profile-card hover-card">
                <div class="position-relative">
                    <img src="{{ $profile->images->first() ? asset($profile->images->first()->file_path) : 'https://via.placeholder.com/300' }}" class="w-100">
                    @if($profile->is_premium)
                        <span class="hover-badge">Premium</span>
                    @endif
                </div>
                <div class="hover-card-body">
                    <h5 class="hover-name">{{ $profile->user->name }}, {{ $profile->age }}</h5>
                    <p class="hover-sub">{{ $profile->profession }}</p>
                    <div class="hover-tags my-2">
                        <span>{{ $profile->religion }}</span>
                        <span>{{ $profile->community }}</span>
                    </div>
                    <a href="#" class="btn btn-view">View Profile</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>




<!-- ===================== SUCCESS STORIES SECTION ===================== -->
<div class="container mb-5">
    <h3 class="fw-bold text-primary text-center mb-4">💍 Success Stories</h3>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="success-box">
                <img src="/images/couple1.jpg" width="100" class="rounded-circle mb-3">
                <h5>Rohan & Priya</h5>
                <p class="text-muted">“We found our true love here.”</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="success-box">
                <img src="/images/couple2.jpg" width="100" class="rounded-circle mb-3">
                <h5>Akash & Neha</h5>
                <p class="text-muted">“Perfect match, perfect life!”</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="success-box">
                <img src="/images/couple3.jpg" width="100" class="rounded-circle mb-3">
                <h5>Vijay & Ritu</h5>
                <p class="text-muted">“Dream partner found!”</p>
            </div>
        </div>
    </div>
</div>

@endsection
