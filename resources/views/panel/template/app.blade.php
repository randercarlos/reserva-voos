<!DOCTYPE html>
<html>
    <head>
        <title>{{ $title ?? 'Painel' }}</title>

        <!--Favicon-->
        <link rel="icon" type="image/png" href="{{ url('assets/panel/imgs/favicon.png') }}">

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
            integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!--Fonts-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css"
            integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">

        <!--CSS Person-->
        <link rel="stylesheet" href="{{ url('assets/panel/css/especializati-reset.css') }}">
        <link rel="stylesheet" href="{{ url('assets/panel/css/especializati.css') }}">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        @yield('css')

    </head>
<body>

<section class="menu">

    <div class="logo">
        <img src="{{ url('assets/panel/imgs/icone-especializati.png') }}" alt="EspecializaTi" class="logo-painel">
    </div>

    <div class="list-menu">
        <ul class="menu-list">

            <li>
                <a href="{{ route('site.index') }}">
                    <i class="far fa-file-alt"></i>
                    Site
                </a>
            </li>

            <li>
                <a href="{{ route('panel.index') }}">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    Home
                </a>
            </li>

            <li>
                <a href="{{ route('brands.index') }}">
                    <i class="fa fa-university" aria-hidden="true"></i>
                    Marcas
                </a>
            </li>

            <li>
                <a href="{{ route('airplanes.index') }}">
                    <i class="fa fa-plane" aria-hidden="true"></i>
                    Aviões
                </a>
            </li>

            <li>
                <a href="{{ route('states.index') }}">
                    <i class="fa fa-globe" aria-hidden="true"></i>
                    Estados
                </a>
            </li>

            <li>
                <a href="{{ route('flights.index') }}">
                    <i class="fa fa-fighter-jet" aria-hidden="true"></i>
                    Voos
                </a>
            </li>

            <li>
                <a href="{{ route('airports.index') }}">
                    <i class="fas fa-road" aria-hidden="true"></i>
                    Aeroportos
                </a>
            </li>

            <li>
                <a href="{{ route('users.index') }}">
                    <img src="{{ asset('assets/panel/imgs/users.png') }}" />
                    Usuários
                </a>
            </li>

             <li>
                <a href="{{ route('reserves.index') }}">
                    <i class="fa fa-check-square"></i>
                    Reservas
                </a>
            </li>

        </ul>
    </div>

</section><!--End Menu-->

<section class="content">
    <div class="top-dashboard">

        <div class="titulo-sistema" style="width: 60%">
            <h3>{{ env('APP_NAME') }}</h3>
        </div>

        <div class="dropdown user-dash" style="margin-right: 100px">
            <div class="dropdown-toggle" id="dropDownCuston" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="true">

                @if (auth()->user()->image)
                    <img src="{{ asset('uploads/users/' . auth()->user()->image) }}"
                        alt="{{ auth()->user()->name }}" class="img-header-user" style="width: 40px; height: 40px">

                @else
                     <img src="{{ url('assets/site/images/no-image.png') }}"
                        alt="{{ auth()->user()->name }}" class="img-header-user" style="width: 50px">
                @endif

                <p class="user-name">{{ auth()->user()->name }}</p>
                <span class="caret"></span>
            </div>

            <ul class="dropdown-menu dp-menu" aria-labelledby="dropDownCuston">
                <li><a href="{{ route('site.user.profile') }}">Perfil</a></li>
                <li><a href="{{ route('site.logout') }}">Logout</a></li>
            </ul>
        </div>
    </div><!--Top Dashboard-->

    <div class="content-ds">


        @yield('content')


    </div><!--End Content DS-->

</section><!--End Content-->


    <!--jQuery-->
    <script src="{{ url('assets/panel/js/jquery-3.1.1.min.js') }}"></script>

    <!-- jS Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

    <!-- bootstrap datepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/locales/bootstrap-datepicker.pt-BR.min.js" integrity="sha512-mVkLPLQVfOWLRlC2ZJuyX5+0XrTlbW2cyAwyqgPkLGxhoaHNSWesYMlcUjX8X+k45YB8q90s88O7sos86636NQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
    <!-- bootstrap datepicker -->

    @yield('js')
</body>
</html>
