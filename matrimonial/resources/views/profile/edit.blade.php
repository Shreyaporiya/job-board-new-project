@extends('layouts.app')

@section('content')

@php
    $prefs = is_array($profile->preferences)
        ? $profile->preferences
        : json_decode($profile->preferences, true);

    $prefs = $prefs ?? [];
@endphp

<div class="container" style="margin-bottom: 5%;">

    <!-- PAGE HEADER -->
    <div class="edit-header mb-4 text-center">
        <h2 class="text-white animate-slide-down">Edit Profile</h2>
        <p class="text-light animate-slide-down delay-1">Update your personal details</p>

        @can('changeActivation', $profile)
            <div class="mt-3">
                @if($profile->is_active)
                    <button class="btn btn-deactive"
                            data-bs-toggle="modal"
                            data-bs-target="#activationModal"
                            data-action="deactivate">
                        Deactivate Profile
                    </button>
                @else
                    <button class="btn btn-active"
                            data-bs-toggle="modal"
                            data-bs-target="#activationModal"
                            data-action="activate">
                        Activate Profile
                    </button>
                @endif
            </div>
        @endcan
    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <strong>{{ session('status') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- MAIN CARD -->
    <div class="edit-card shadow-lg p-4 rounded-4 animate-fade-in">

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="row">

                <!-- LEFT COLUMN -->
                <div class="col-lg-4 text-center border-end border-light-subtle">

                    <!-- PROFILE IMAGE -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Profile Photo</label><br>

                        <img id="profileImage"
                             src="{{ $profile->images->first()
                                ? asset($profile->images->first()->file_path)
                                : 'https://via.placeholder.com/300' }}"
                             class="rounded-circle shadow"
                             width="250" height="250"
                             style="object-fit:cover;cursor:pointer">

                        <input type="file" id="profileUpload" name="profile_image"
                               class="d-none" accept="image/*">

                        @error('profile_image')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- BASIC INFO -->
                    <div class="mt-4 text-start">

                        <!-- SECTION: BASIC INFORMATION -->
                        <div class="profile-section text-start mb-4">
                            <h5 class="section-title">Basic Information</h5>
                            <div class="section-divider"></div>
                        </div>

                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control modern-input"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="text-danger mt-2">{{ $message }}</div> @enderror

                        <label class="form-label mt-3">Email</label>
                        <input type="email" name="email" class="form-control modern-input"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="text-danger mt-2">{{ $message }}</div> @enderror

                        <label class="form-label mt-3">Age</label>
                        <input type="number" name="age" class="form-control modern-input"
                               value="{{ old('age', $profile->age) }}" required>
                        @error('age') <div class="text-danger mt-2">{{ $message }}</div> @enderror

                        <label class="form-label mt-3">Visibility</label>
                        <select name="visibility" class="form-select modern-input">
                            <option value="public" {{ $profile->visibility === 'public' ? 'selected' : '' }}>Public</option>
                            <option value="private" {{ $profile->visibility === 'private' ? 'selected' : '' }}>Private</option>
                        </select>

                        <label class="form-label mt-3">Gender</label>
                        <select name="gender" class="form-select modern-input">
                            <option value="Male" {{ $profile->gender === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $profile->gender === 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                        <label class="form-label mt-3">Marital Status</label>
                        <select name="marital_status" class="form-select modern-input">
                            <option value="single" {{ $profile->marital_status === 'single' ? 'selected' : '' }}>Single</option>
                            <option value="divorced" {{ $profile->marital_status === 'divorced' ? 'selected' : '' }}>Divorced</option>
                            <option value="widow" {{ $profile->marital_status === 'widow' ? 'selected' : '' }}>Widow</option>
                        </select>


                    </div>
                </div>

                <!-- RIGHT COLUMN -->
                <div class="col-lg-8 ps-lg-4">
                    <div class="row">

                        <!-- SECTION: PERSONAL DETAILS -->
                        <div class="profile-section mb-4">
                            <h5 class="section-title">Personal Details</h5>
                            <p class="section-subtitle">Tell us about yourself</p>
                            <div class="section-divider"></div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label class="form-label">Religion</label>
                            <input type="text" name="religion" class="form-control modern-input"
                                   value="{{ old('religion', $profile->religion) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Community</label>
                            <input type="text" name="community" class="form-control modern-input"
                                   value="{{ old('community', $profile->community) }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control modern-input"
                                   value="{{ old('country', $profile->country) }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">State</label>
                            <input type="text" name="state" class="form-control modern-input"
                                   value="{{ old('state', $profile->state) }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control modern-input"
                                   value="{{ old('city', $profile->city) }}" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Profession</label>
                            <input type="text" name="profession" class="form-control modern-input"
                                   value="{{ old('profession', $profile->profession) }}" required>
                        </div>

                        <!-- PARTNER PREFERENCES -->
                        <div class="col-md-12 mb-3">
                            <div class="profile-section mt-4 mb-4">
                                <h5 class="section-title">Partner Preferences</h5>
                                <p class="section-subtitle">
                                    Help us find the best match for you
                                </p>
                                <div class="section-divider"></div>
                            </div>

                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input type="number" name="preferences[age_min]"
                                           class="form-control modern-input"
                                           placeholder="Minimum Age"
                                           value="{{ $prefs['age_min'] ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="preferences[age_max]"
                                           class="form-control modern-input"
                                           placeholder="Maximum Age"
                                           value="{{ $prefs['age_max'] ?? '' }}">
                                </div>
                            </div>

                            <input type="text" name="preferences[religion]"
                                   class="form-control modern-input mt-2"
                                   placeholder="Preferred Religion"
                                   value="{{ $prefs['religion'] ?? '' }}">

                            <input type="text" name="preferences[Cast]"
                                   class="form-control modern-input mt-2"
                                   placeholder="Preferred Cast"
                                   value="{{ $prefs['Cast'] ?? '' }}">

                            <input type="text" name="preferences[location][]"
                                   class="form-control modern-input mt-2"
                                   placeholder="India,Gujarat,Ahemdabad"
                                   value="{{ isset($prefs['location']) ? implode(', ', $prefs['location']) : '' }}">


                            <label class="mt-3 form-label">Preferred Marital Status</label>
                            <div class="d-flex gap-3 flex-wrap">

                                @foreach(['single','divorced','widow'] as $status)
                                    <label class="pref-chip shadow-sm"
                                        style="background:#f8f9fa; cursor:pointer;">
                                        <input type="checkbox"
                                            name="preferences[marital_status][]"
                                            value="{{ $status }}" {{ in_array($status, $prefs['marital_status'] ?? []) ? 'checked' : '' }}>

                                            <span class="fw-semibold text-capitalize">{{ $status }}</span>
                                    </label>
                                @endforeach

                            </div>

                            <label class="mt-3">Preferred Profession(s)</label>
                            <input type="text" name="preferences[profession][]"
                                   class="form-control modern-input"
                                   placeholder="Example: Engineer, Doctor"
                                   value="{{ isset($prefs['profession']) ? implode(', ', $prefs['profession']) : '' }}">

                            <label class="mt-3">Personality Traits</label>
                            <input type="text" name="preferences[personality][]"
                                   class="form-control modern-input"
                                   placeholder="Kind, Caring, Calm"
                                   value="{{ isset($prefs['personality']) ? implode(', ', $prefs['personality']) : '' }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- BUTTONS -->
            <div class="text-end mt-4">
                <a href="{{ route('profile.myprofile') }}" class="btn edit-cancel-btn">Cancel</a>
                <button type="submit" class="btn save-btn">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- ACTIVATION MODAL -->
<div class="modal fade" id="activationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <h5 id="modalTitle" class="fw-bold"></h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <p id="modalText"></p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <form method="POST" action="{{ route('profile.changeactivation') }}">
                    @csrf
                    <input type="hidden" name="activation_action" id="activationInput">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn" id="modalConfirm">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
const img = document.getElementById('profileImage');
const upload = document.getElementById('profileUpload');
img.onclick = () => upload.click();
upload.onchange = e => img.src = URL.createObjectURL(e.target.files[0]);

const modal = document.getElementById('activationModal');
modal.addEventListener('show.bs.modal', e => {
    const action = e.relatedTarget.dataset.action;
    document.getElementById('activationInput').value = action;

    if(action === 'deactivate'){
        modalTitle.innerText = 'Deactivate Profile?';
        modalText.innerText = 'Your profile will be hidden from others.';
        modalConfirm.className = 'btn btn-danger';
    }else{
        modalTitle.innerText = 'Activate Profile?';
        modalText.innerText = 'Your profile will be visible to others.';
        modalConfirm.className = 'btn btn-success';
    }
});
</script>

@endsection
