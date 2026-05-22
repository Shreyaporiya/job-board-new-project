@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">Country → State → City</h3>

    <div class="mb-3">
        <label>Country</label>
        <select id="country" class="form-select">
            <option value="">Select Country</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>State</label>
        <select id="state" class="form-select">
            <option value="">Select State</option>
        </select>
    </div>

    <div class="mb-3">
        <label>City</label>
        <select id="city" class="form-select">
            <option value="">Select City</option>
        </select>
    </div>
</div>

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $('#country').change(function () {
        let countryId = $(this).val();
        $('#state').html('<option value="">Loading...</option>');
        $('#city').html('<option value="">Select City</option>');

        if (countryId) {
            $.get('/get-states/' + countryId, function (data) {
                let options = '<option value="">Select State</option>';
                data.forEach(state => {
                    options += `<option value="${state.id}">${state.name}</option>`;
                });
                $('#state').html(options);
            });
        }
    });

    $('#state').change(function () {
        let stateId = $(this).val();
        $('#city').html('<option value="">Loading...</option>');

        if (stateId) {
            $.get('/get-cities/' + stateId, function (data) {
                let options = '<option value="">Select City</option>';
                data.forEach(city => {
                    options += `<option value="${city.id}">${city.name}</option>`;
                });
                $('#city').html(options);
            });
        }
    });
</script>
@endsection
