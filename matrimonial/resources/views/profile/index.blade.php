@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row" style="margin-bottom: 5%;">

            <!-- ===================== FILTER SIDEBAR ===================== -->
            <div class="col-lg-3">
                <div class="card shadow-sm p-3 border-0 rounded-4">
                    <div class="section-header text-center">
                        <h4 style="font-size: 24px;">🔍 Filter Profiles</h4>
                    </div>

                    <form id="filterForm">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter name"
                                value="{{ request('name') }}">
                        </div>

                        <!-- Age Range -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Age Between</label>
                            <div class="d-flex gap-2">
                                <input type="number" name="age_from" class="form-control" placeholder="From"
                                    value="{{ request('age_from') }}">
                                <input type="number" name="age_to" class="form-control" placeholder="To"
                                    value="{{ request('age_to') }}">
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Gender</label>
                            <select class="form-select" name="gender">
                                <option value="">Any</option>
                                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                        <!-- Marital Status -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Marital Status</label>
                            <select class="form-select" name="marital_status">
                                <option value="">Any</option>
                                <option value="single" {{ request('marital_status') == 'single' ? 'selected' : '' }}>Single
                                </option>
                                <option value="married" {{ request('marital_status') == 'married' ? 'selected' : '' }}>Married
                                </option>
                                <option value="divorced" {{ request('marital_status') == 'divorced' ? 'selected' : '' }}>
                                    Divorced
                                </option>
                            </select>
                        </div>

                        <!-- Religion -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Religion</label>
                            <input type="text" name="religion" class="form-control" placeholder="Enter religion"
                                value="{{ request('religion') }}">
                        </div>

                        <!-- Community -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Community</label>
                            <input type="text" name="community" class="form-control" placeholder="Enter community"
                                value="{{ request('community') }}">
                        </div>

                        <!-- Profession -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Profession</label>
                            <input type="text" name="profession" class="form-control" placeholder="e.g., Engineer"
                                value="{{ request('profession') }}">
                        </div>

                        <!-- Country -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Country</label>
                            <input type="text" name="country" class="form-control" placeholder="e.g., India"
                                value="{{ request('country') }}">
                        </div>

                        <!-- State -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">State</label>
                            <input type="text" name="state" class="form-control" placeholder="e.g., Maharashtra"
                                value="{{ request('state') }}">
                        </div>

                        <!-- City -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">City</label>
                            <input type="text" name="city" class="form-control" placeholder="e.g., Mumbai"
                                value="{{ request('city') }}">
                        </div>

                        <!-- Buttons -->
                        <div class="d-grid gap-2 mt-3">
                            <button type="submit" formaction="{{ route('profile.search') }}" formmethod="GET"
                                class="btn btn-primary search-btn px-4">Search</button>
                            <button type="submit" formaction="{{ route('filter.save') }}" formmethod="POST"
                                class="btn btn-success px-4">
                                Save your search
                            </button>
                            <a href="{{ route('profile.index') }}" class="btn btn-secondary px-4">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ===================== PROFILES GRID ===================== -->
            <div class="col-lg-9 mt-4 mt-lg-0">

                <!-- ================= SUGGESTED FILTER BADGES ================= -->
                @if($myFilter && $myFilter->count())
                    <div class="mb-4 d-flex flex-wrap gap-2">

                        @php $printed = []; @endphp

                        @foreach($myFilter as $filter)
                            @foreach((array) $filter as $key => $value)

                                @php
                                    $identifier = $key.'|'.$value;
                                    $query = request()->query();
                                    $query[$key] = $value;
                                @endphp

                                @if(!empty($value) && !in_array($identifier, $printed))
                                    @php
                                        $printed[] = $identifier;
                                        $isActive = request($key) == $value;
                                    @endphp

                                    <a href="{{ route('profile.search', $query) }}"
                                    class="badge filter_badge d-inline-flex align-items-center gap-1
                                            {{ $isActive ? 'filter-badge-active' : '' }}">

                                        {{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}

                                        @if($isActive)
                                            <button type="button"
                                                class="btn-close btn-sm ms-1"
                                                onclick="removeFilter(event, '{{ $key }}')">
                                            </button>
                                        @endif

                                    </a>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                @endif


                <div class="section-header text-center mb-5">
                    <h3>Featured Profiles</h3>
                </div>

                <div class="row g-4">
                    @forelse($profiles as $profile)
                        <div class="col-md-4">
                            <div class="profile-card-modern">
                                <div class="profile-img-wrapper">
                                    <img src="{{ $profile->images->first()
                                        ? asset($profile->images->first()->file_path)
                                        : 'https://via.placeholder.com/300' }}" class="w-100">

                                    @if($profile->is_premium)
                                        <span class="premium-badge">Premium</span>
                                    @endif
                                </div>

                                <div class="profile-info">
                                    <h5 class="hover-name">{{ $profile->user->name }}, {{ $profile->age }}</h5>
                                    <p class="hover-sub">{{ $profile->profession }}</p>

                                    <div class="profile-tags my-3">
                                        <span>{{ $profile->religion }}</span>
                                        <span>{{ $profile->community }}</span>
                                    </div>

                                    <a href="{{ route('user.show', $profile->id) }}" class="btn btn-view-modern">
                                        View Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <h4 class="text-muted">No profiles found.</h4>
                        </div>
                    @endforelse

                </div>
            </div>

        </div>
    </div>

    <script>
        function removeFilter(key) {
            const url = new URL(window.location.href);
            url.searchParams.delete(key);
            window.location.href = url.toString();
        }
    </script>

    <script>
        function removeFilter(event, key) {
            event.preventDefault();
            event.stopPropagation();

            const url = new URL(window.location.href);
            url.searchParams.delete(key);

            // 🔥 If no filters left → go to index page
            if ([...url.searchParams.keys()].length === 0) {
                window.location.href = "{{ route('profile.index') }}";
            } else {
                window.location.href = url.toString();
            }
        }
    </script>

@endsection