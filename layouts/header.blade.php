<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="Logo" width="40" class="me-2">
            <span class="fw-bold text-primary">Matrimony</span>
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Matches</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Requests</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Premium</a></li>

                @auth
                    @php
                        $profile = Auth::user()->profiles->first();
                        $profileImage = $profile && $profile->images->first()
                                        ? asset($profile->images->first()->file_path)
                                        : 'https://via.placeholder.com/50';
                    @endphp
                    <li class="nav-item mx-2">
                        <img src="{{ $profileImage }}" alt="Profile Image" class="rounded-circle shadow"
                             style="width:50px; height:50px; object-fit:cover;">
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="rounded-circle me-2" width="32">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary ms-2" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary ms-2 text-white" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
