<!DOCTYPE html>
<html>

<head>
    <title>Pillbox Multi Select</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Select2 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        .select2-container--default .select2-selection--multiple {
            min-height: 46px;
            padding: 6px;
            border-radius: 12px;
            border: 1px solid #ced4da;
            cursor: pointer;
        }

        .select2-selection__choice {
            background: #0d6efd !important;
            color: #fff !important;
            border-radius: 20px !important;
            padding: 4px 10px !important;
            border: none !important;
        }

        .select2-selection__choice__remove {
            color: #fff !important;
            margin-right: 6px;
        }
    </style>
    @vite(['resources/js/app.js'])

</head>

<body>

    <div class="container mt-5">
        <h4 class="mb-3">Select Your Hobbies</h4>

        <form method="POST" action="/profile/store">
            @csrf

            <div class="mb-3">
                <label class="form-label">Hobbies</label>

                <select class="select2" name="hobbies[]" id="hobbies" multiple>
                    <option value="Reading">Reading</option>
                    <option value="Traveling">Traveling</option>
                    <option value="Music">Music</option>
                    <option value="Sports">Sports</option>
                    <option value="Photography">Photography</option>
                    <option value="Cooking">Cooking</option>
                </select>
            </div>


            <select class="js-example-basic-multiple js-states form-control" id="id_label_multiple" multiple="multiple">
                <option value="Reading">Reading</option>
                <option value="Traveling">Traveling</option>
                <option value="Music">Music</option>
                <option value="Sports">Sports</option>
                <option value="Photography">Photography</option>
                <option value="Cooking">Cooking</option>
            </select>

            <button class="btn btn-primary">Save</button>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            $('#hobbies').select2({
                placeholder: "Choose hobbies",
                closeOnSelect: false,
                width: '100%'
            });
        });

        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();
        });
    </script>

</body>

</html>