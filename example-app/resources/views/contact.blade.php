<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Contact Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
</head>
<body>

<div class="container" style="padding-top:100px; padding-left:25%;">
    @if(session('success'))
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                {{ session('success') }}
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        </div>
    @endif

    @if(session('headerValue'))
        <div class="alert alert-info w-50">
            <strong>Custom Header:</strong> {{ session('headerValue') }} <br>
            <strong>Host:</strong> {{ session('host') }} <br>
            <strong>bearerToken:</strong> {{ session('bearerToken') }} <br>
            <strong>ipAddresses:</strong> {{ session('ipAddresses') }} <br>
            <strong>HTTP Host:</strong> {{ session('httpHost') }} <br>
            <strong>Scheme + Host:</strong> {{ session('schemeAndHttpHost') }}
        </div>
    @endif

    <form action="/contact" method="POST" class="w-50">
        @csrf
        <input type="text" name="name" class="form-control" placeholder="Your Name" value="{{ old('name') }}">
        @error('name') 
            <p class="text-danger">{{ $message }}</p> 
        @enderror
        <br>

        <input type="email" name="email" class="form-control" placeholder="Your Email" value="{{ old('email') }}">
        @error('email') 
            <p class="text-danger">{{ $message }}</p> 
        @enderror
        <br>

        <textarea name="message" class="form-control" placeholder="Your Message">{{ old('message') }}</textarea>
        @error('message') 
            <p class="text-danger">{{ $message }}</p> 
        @enderror
        <br>

        <button class="btn btn-primary" type="submit">Send</button>
    </form>
</div>

</body>
</html>
