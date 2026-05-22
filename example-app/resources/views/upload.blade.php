<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Upload File</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
</head>

<body style="padding-top:8%;">

<div class="container" style="width:450px;">
<h2 class="text-center">Profile Picture</h2>

@if(session('success'))
    <p class="text-success text-center">{{ session('success') }}</p>
@endif


{{-- Last Uploaded File --}}
@if($upload)

    <!-- <p>Last Uploaded: {{ $upload->name }}</p> -->

    @php
        $extension = pathinfo($upload->path, PATHINFO_EXTENSION);
    @endphp

    @if(in_array(strtolower($extension), ['jpg','jpeg','png','gif','ico']))

        <!-- <div class="mt-3 text-center">
            <img id="profileImage"
                 src="{{ asset('storage/' . $upload->path) }}"
                 class="img-fluid rounded-circle shadow"
                 style="height:150px; width:150px; object-fit:cover; cursor:pointer;">
            <p class="text-muted mt-2">(Click image to change)</p>
        </div> -->

        <div class="text-center mt-4">
            <div id="profileImage"
                class="rounded-5 bg-light border shadow d-flex align-items-center justify-content-center"
                style="height:50px; width:100%; cursor:pointer;">
                change favicon icon
            </div>
        </div>

        <!-- Hidden Upload Form -->
        <form id="changeImageForm" action="{{ route('upload.handle') }}"
              method="POST" enctype="multipart/form-data" class="d-none">
            @csrf
            <input type="file" id="changeImage" name="file" accept="image/*">
            <input type="hidden" name="name" value="profile">
        </form>

        <script>
            document.getElementById("profileImage").onclick = function () {
                document.getElementById("changeImage").click();
            };
            document.getElementById("changeImage").onchange = function () {
                document.getElementById("changeImageForm").submit();
            };
        </script>

    @else
        <p><i class="fa fa-file"></i> Last upload is not an image.</p>
    @endif


@else
    <!-- WHEN NO IMAGE EXISTS -->
    <div class="text-center mt-4">
        <div id="placeholderImage"
            class="rounded-5 bg-light border shadow d-flex align-items-center justify-content-center"
            style="height:50px; width:100%; cursor:pointer;">
            change favicon icon
        </div>
    </div>

    <!-- Hidden Upload Form -->
    <form id="uploadImageForm" action="{{ route('upload.handle') }}"
          method="POST" enctype="multipart/form-data" class="d-none">
        @csrf
        <input type="file" id="fileInput" name="file" accept="image/*">
        <input type="hidden" name="name" value="profile">
    </form>

    <script>
        document.getElementById("placeholderImage").onclick = function () {
            document.getElementById("fileInput").click();
        };
        document.getElementById("fileInput").onchange = function () {
            document.getElementById("uploadImageForm").submit();
        };
    </script>

@endif


</div>
</body>
</html>
