<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('public/css/error.css') }}">
</head>

<body>

    <div class="error-container animate__animated animate__fadeIn">
        @yield('content')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const shapesContainer = document.querySelector('.floating-shapes');
            for (let i = 0; i < 5; i++) {
                const shape = document.createElement('div');
                const size = Math.random() * 100 + 50;
                const left = Math.random() * 100;
                const delay = Math.random() * 10;
                const duration = Math.random() * 10 + 10;

                shape.style.left = `${left}%`;
                shape.style.width = `${size}px`;
                shape.style.height = `${size}px`;
                shape.style.animationDelay = `${delay}s`;
                shape.style.animationDuration = `${duration}s`;

                shapesContainer.appendChild(shape);
            }
        });
    </script>
</body>

</html>
