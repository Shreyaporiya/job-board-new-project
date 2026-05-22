@extends('layouts.app')

@section('title', 'Create Profile')

@section('content')

<div class="wrapper">
    <div class="profile-card">

        <h2 class="title">Create Your Profile</h2>
        <p class="subtitle">Complete your details to find better matches</p>

        <!-- Stepper -->
        <div class="stepper mb-4">
            <div class="step active" id="indicator1">1</div>
            <div class="step" id="indicator2">2</div>
            <div class="step" id="indicator3">3</div>
        </div>

        <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- STEP 1 -->
            <div id="step1">
                <div class="section">
                    <h4>Personal Details</h4>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Age</label>
                            <input type="number" name="age" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label>Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="">Select</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Religion</label>
                            <input type="text" name="religion" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label>Community</label>
                            <input type="text" name="community" class="form-control">
                        </div>
                    </div>
                </div>

                <button type="button" class="btn-main w-100" onclick="nextStep(2)">Next</button>
            </div>

            <!-- STEP 2 -->
            <div id="step2" class="hidden">
                <div class="section">
                    <h4>Professional & Location</h4>

                    <input type="text" name="education" class="form-control mb-3" placeholder="Education">
                    <input type="text" name="profession" class="form-control mb-3" placeholder="Profession">

                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="country" class="form-control" placeholder="Country">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="state" class="form-control" placeholder="State">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="city" class="form-control" placeholder="City">
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <button type="button" class="btn btn-secondary w-50" onclick="prevStep(1)">Previous</button>
                    <button type="button" class="btn-main w-50" onclick="nextStep(3)">Next</button>
                </div>
            </div>

            <!-- STEP 3 -->
            <div id="step3" class="hidden">
                <div class="section">
                    <h4>Partner Preferences</h4>

                    <input type="number" name="preferences[age_min]" class="form-control mb-3" placeholder="Age Min">
                    <input type="number" name="preferences[age_max]" class="form-control mb-3" placeholder="Age Max">
                </div>

                <div class="d-flex gap-3">
                    <button type="button" class="btn btn-secondary w-50" onclick="prevStep(2)">Previous</button>
                    <button type="submit" class="btn-main w-50">Submit</button>
                </div>
            </div>

        </form>
    </div>
</div>


<script>
    // Create profile
window.nextStep = function (step) {
    document.querySelectorAll('[id^="step"]').forEach(s => {
        s.classList.add('hidden');
    });

    document.getElementById('step' + step).classList.remove('hidden');
    updateIndicator(step);
    window.scrollTo(0, 0);
};

window.prevStep = function (step) {
    nextStep(step);
};

function updateIndicator(step) {
    document.querySelectorAll('[id^="indicator"]').forEach(i => {
        i.classList.remove('active');
    });

    document.getElementById('indicator' + step).classList.add('active');
}
</script>

@endsection
