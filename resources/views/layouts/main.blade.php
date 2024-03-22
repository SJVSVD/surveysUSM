<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Encuesta de evaluación USM</title>
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="{{ asset('images/usmLogo3.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Js Files -->
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        /* Estilos personalizados */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
            background-color: #f7f7f7; 
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('images/USM_Background.jpeg') }}");
            background-size: cover; /* Cubre toda la pantalla */
            opacity: 0.2; /* Ajusta la opacidad de la imagen */
            z-index: -1; /* Asegura que la imagen esté detrás del contenido */
        }


        /* Barra superior azul */
        .navbar {
            background-color: #005D8E; /* Azul */
            padding-left: 30px;
            padding-right: 30px; 
            font-size: 12px;
            font-weight: bolder;
            color: #fff; /* Texto blanco */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar img{
            height: 25px;
            width: 25px;
        }

        /* Rectángulo en el centro */
        .main-container {
            min-width: 350px;
            width: 95%;
            margin: 50px auto;
        }

    </style>
</head>

<body>
    <!-- Barra superior azul con texto a la izquierda y redes de contacto a la derecha -->
    <div class="navbar">
        <!-- Enlace a USM.cl -->
        <a href="https://usm.cl" style="cursor: pointer; text-decoration: none; color: white;">USM.cl</a>
        <div class="d-flex justify-content-end align-items-center">
            <div class="me-3" style="cursor: pointer;">Contacto</div>
            <a href="https://facebook.com/usantamaria/" target="_blank">
                <img src="{{ asset('icons/facebookIcon.png') }}" alt="Facebook Icon" style="cursor: pointer;">
            </a>
            &nbsp;
            <a href="https://twitter.com/usantamaria" target="_blank">
                <img src="{{ asset('icons/twitterIcon.png') }}" alt="Twitter Icon" style="cursor: pointer;">
            </a>
            &nbsp;
            <a href="https://www.youtube.com/channel/UCr5rEvayXIC0YnJxDAWuWtQ target="_blank">
                <img src="{{ asset('icons/youtubeIcon.png') }}" alt="YouTube Icon" style="cursor: pointer;">
            </a>
            &nbsp;
            <a href="https://www.instagram.com/usantamaria/" target="_blank">
                <img src="{{ asset('icons/instagramIcon.png') }}" alt="Instagram Icon" style="cursor: pointer;">
            </a>
            &nbsp;
            <a href="https://www.linkedin.com/school/usantamaria/" target="_blank">
                <img src="{{ asset('icons/linkedinIcon.png') }}" alt="LinkedIn Icon" style="cursor: pointer;">
            </a>
            &nbsp;
            <a href="https://www.tiktok.com/@admisionusm" target="_blank">
                <img src="{{ asset('icons/tiktokIcon.png') }}" alt="TikTok Icon" style="cursor: pointer;">
            </a>
        </div>

    </div>

    <!-- Rectángulo en el centro de la página -->
    <div class="main-container">
        @guest
            @yield('content')
        @endguest
    </div>

</body>
</html>
