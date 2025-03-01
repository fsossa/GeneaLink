<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title ?? env("APP_NAME")}}</title>

    <!-- Intégration de Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<style>
    /* Utiliser Flexbox pour étirer la page */
    html, body {
        height: 100%; /* Définit la hauteur totale de la page */
        margin: 0;
    }

    /* Wrapper qui occupe toute la hauteur de la page */
    .wrapper {
        min-height: 100%;
        display: flex;
        flex-direction: column;
    }

    /* Contenu principal qui prend l'espace restant */
    .content {
        flex: 1;
    }

    /* Footer fixé en bas */
    footer {
        background-color: #343a40;
        color: white;
        text-align: center;
        padding: 20px 0;
    }
</style>

<body>

    <!-- Header avec menu de navigation -->
    <header class="bg-dark text-white py-3">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="{{route('people.index')}}">Généalogie</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item {{$index ?? '' }}">
                        <a class="nav-link " href="{{route('people.index')}}">Accueil</a>
                    </li>

                    @if(Auth::check())
                    <li class="nav-item {{$invitation ?? '' }}">
                        <a class="nav-link  " href="{{route('people.invitations')}}">Invitations</a>
                    </li>
                    <li class="nav-item {{$create ?? '' }}">
                        <a class="nav-link " href="{{route('people.create')}}">Créer une personne</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('login')}}">Se connecter</a>
                    </li>
                    @endif

                </ul>
            </div>
        </nav>
    </header>

    <!-- Contenu principal de la page -->
    <div class="container mt-5"  style="min-height: 375px" >
        @yield('content')
    </div>

    <!-- Pied de page -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2025 Généalogie. Tous droits réservés.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    @stack('scripts')


    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
        };
    </script>

    @if(Session::has('success'))
    <script>
        var message = "{{Session::get('success')}}";
        toastr.success(message, 'Succès');
    </script>
    @endif

    @if(Session::has('error'))
    <script>
        var message = "{{Session::get('error')}}";
        toastr.error(message, 'Succès');
    </script>
    @endif

</body>
</html>