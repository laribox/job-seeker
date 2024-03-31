<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    </head>
    <body>
        <script script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <nav class="navbar navbar-expand-lg bg-body-tertiary"  data-bs-theme="dark">
            <div class="container">
              <a class="navbar-brand" href="#">Job Seeker</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                  </li>
                  @if (!Auth::check())
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                  </li>
                  @endif

                  @if (!Auth::check())
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.register') }}">Job Seeker</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link"  href="{{ route('user.employerRegister') }}">Employer</a>
                  </li>
                  @endif
                  @if (Auth::check())
                  <li class="nav-item">
                    <a class="nav-link" href="#" id="logout">Logout</a>
                  </li>
                  @endif
                  <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                    @csrf
                  </form>
                </ul>
              </div>
            </div>
          </nav>
          @yield('content')
            <script>
                let logout = document.querySelector('#logout');
                let form = document.querySelector('#logoutForm');
                if (logout != null) {

                logout.addEventListener('click', function(){
                    form.submit();
                })
                }


            </script>
    </body>
</html>
