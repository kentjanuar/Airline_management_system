<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centered Form</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900   flex justify-center">

<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="container"
            style="max-width: 400px; border: 1px solid #ccc; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <h3 class="mt-4 bg-blue text-center">Login</h3>
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <label for="email">Email</label>
                <input class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                    value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <label for="password">Password</label>
                <input class="form-control" type="password" name="password">

                <button type="submit" class="btn btn-primary mt-2 w-100">Login</button>
            </form>
        </div>
    </div>

</body>
</html>
