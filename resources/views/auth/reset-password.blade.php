<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tp Salaire</title>
</head>

<body>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:700,600" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <form method="post" action="{{ route('submitResetPassword') }}">

        @csrf
        @method('POST')

        <div class="home-box">



            @if (Session::get('success_message'))
                <b style="font-size:10px; color:rgb(29, 255, 199)">{{ Session::get('error_msg') }}</b>
            @endif

            @if (Session::get('error_msg'))
                <b style="font-size:10px; color:rgb(185, 81, 81)">{{ Session::get('error_msg') }}</b>
            @endif

            <div class="left">

                <img src="{{ asset('assets/images/undraw_task_list_6x9d.svg') }}" alt="">
            </div>
            <div class="right">

                <h4>réinitialiser le mot de passe</h4>
                <div class="auth-intro mb-4 text-center">Entrez votre adresse e-mail ci-dessous. Nous vous enverrons par
                    e-mail un lien vers une page où vous pourrez facilement créer un nouveau mot de passe.</div>

                @if (Session::get('success_msg'))
                    <div class="success_span">{{ Session::get('success_msg') }}</div>
                @endif
                <input type="email" name="email" class="email" value="{{ old('email') }}"
                    placeholder="Votre e-mail">


                <div class="btn-container">
                    <button type="submit"> Valider</button>
                </div>
            </div>
            <!-- End Btn -->
            <!-- End Btn2 -->
        </div>
        <!-- End Box -->
    </form>

</body>

</html>
