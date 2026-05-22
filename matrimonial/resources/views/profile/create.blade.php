<x-guest-layout>

    <!-- INLINE CSS -->
    <style>
        body {
            /* background: linear-gradient(135deg, #fdf3e6, #fbe9d3, #f8d7c4) !important; */
            background-size: cover;
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid #e3c7a0 !important;
            border-radius: 25px !important;
            padding: 40px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
        }

        .section-box {
            background: #fdf3e6 !important;
            padding: 25px !important;
            border-radius: 18px;
            box-shadow: inset 0 4px 10px rgba(0, 0, 0, 0.05) !important;
        }

        .main-title {
            color: #7a1f28 !important;
            font-weight: 800;
        }

        label {
            font-weight: 600;
            color: #7a1f28 !important;
            font-size: 14px;
        }

        input,
        select {
            font-size: 14px;
            height: 45px;
        }

        .btn-primary-custom {
            background-color: #7a1f28 !important;
            border-color: #7a1f28 !important;
            color: white !important;
            padding: 10px;
        }

        .btn-primary-custom:hover {
            background-color: #9d2b34 !important;
            border-color: #9d2b34 !important;
            color: white !important;
        }

        .hidden {
            display: none !important;
        }
    </style>

    <div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="profile-card w-100" style="max-width: 900px;">

            <h2 class="text-center main-title mb-4">Create Your Profile</h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data" id="profileForm">
                @csrf

                <!-- STEP 1 -->
                <div id="step1">
                    <div class="section-box mb-4">
                        <h4 class="main-title mb-3">Personal Details</h4>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Age</label>
                                <input type="number" name="age" value="{{ old('age') }}"
                                       class="form-control @error('age') is-invalid @enderror" required>
                                @error('age') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label>Gender</label>
                                <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label>Religion</label>
                                <input type="text" name="religion" value="{{ old('religion') }}"
                                       class="form-control @error('religion') is-invalid @enderror" required>
                                @error('religion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label>Community</label>
                                <input type="text" name="community" value="{{ old('community') }}"
                                       class="form-control @error('community') is-invalid @enderror" required>
                                @error('community') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <label>Marital Status</label>
                            <select name="marital_status"
                                    class="form-select @error('marital_status') is-invalid @enderror" required>
                                <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Single</option>
                                <option value="divorced" {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                <option value="widow" {{ old('marital_status') == 'widow' ? 'selected' : '' }}>Widow</option>
                            </select>
                            @error('marital_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <button type="button" id="nextBtn1" class="btn btn-primary-custom w-100">Next</button>
                </div>

                <!-- STEP 2 -->
                <div id="step2" class="hidden">
                    <div class="section-box mb-4">
                        <h4 class="main-title mb-3">Professional Details</h4>

                        <label>Education</label>
                        <input type="text" name="education" value="{{ old('education') }}" class="form-control mb-3">

                        <label>Profession</label>
                        <input type="text" name="profession" value="{{ old('profession') }}" class="form-control mb-3">
                    </div>

                    <div class="section-box mb-4">
                        <h4 class="main-title mb-3">Location & Image</h4>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label>Country</label>
                                <input type="text" name="country" value="{{ old('country') }}" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>State</label>
                                <input type="text" name="state" value="{{ old('state') }}" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>City</label>
                                <input type="text" name="city" value="{{ old('city') }}" class="form-control">
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label>Profile Visibility</label>
                                <select name="visibility" class="form-select">
                                    <option value="public">Public</option>
                                    <option value="private">Private</option>
                                </select>
                                <input type="hidden" name="typofimage" value="Profile">
                            </div>

                            <div class="col-md-6">
                                <label>Profile Image</label>
                                <input type="file" name="profile_image" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="button" id="prevBtn1" class="btn btn-secondary w-50">Previous</button>
                        <button type="button" id="nextBtn2" class="btn btn-primary-custom w-50">Next</button>
                    </div>
                </div>

                <!-- STEP 3 -->
                <div id="step3" class="hidden">
                    <div class="section-box mb-4">
                        <h5 class="main-title mb-3">Partner Preferences</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Preferred Age (Min)</label>
                                <input type="number" name="preferences[age_min]" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Preferred Age (Max)</label>
                                <input type="number" name="preferences[age_max]" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Preferred Religion</label>
                                <input type="text" name="preferences[religion]" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Preferred Cast</label>
                                <input type="text" name="preferences[Cast]" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Preferred Marital Status</label>
                                <select name="preferences[marital_status][]" class="form-select">
                                    <option value="single">Single</option>
                                    <option value="divorced">Divorced</option>
                                    <option value="widow">Widow</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Preferred Profession(s)</label>
                                <input type="text" name="preferences[profession][]" class="form-control"
                                       placeholder="Engineer, Doctor">
                            </div>

                            <div class="col-md-12">
                                <label>Preferred Location</label>
                                <input type="text" name="preferences[location][]" class="form-control"
                                       placeholder="India, Gujarat, Ahmedabad">
                            </div>

                            <div class="col-md-12">
                                <label>Preferred Personality Traits</label>
                                <input type="text" name="preferences[personality][]" class="form-control"
                                       placeholder="Caring, Calm, Supportive">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="button" id="prevBtn2" class="btn btn-secondary w-50">Previous</button>
                        <button type="submit" class="btn btn-primary-custom w-50">Submit Profile</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- STEP SCRIPT -->
    <script>
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step3 = document.getElementById('step3');

        nextBtn1.onclick = () => {
            step1.classList.add('hidden');
            step2.classList.remove('hidden');
        };

        prevBtn1.onclick = () => {
            step2.classList.add('hidden');
            step1.classList.remove('hidden');
        };

        nextBtn2.onclick = () => {
            step2.classList.add('hidden');
            step3.classList.remove('hidden');
        };

        prevBtn2.onclick = () => {
            step3.classList.add('hidden');
            step2.classList.remove('hidden');
        };
    </script>

</x-guest-layout>
