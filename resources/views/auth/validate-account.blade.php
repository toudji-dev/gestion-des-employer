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
    <form method="post" action="{{ route('submitDefineAccess', $email) }}">

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

                <h4>Définissez vos accès</h4>

                @if (Session::get('success_msg'))
                    <div class="success_span">{{ Session::get('success_msg') }}</div>
                @endif
                <input type="email" name="email" class="email" value="{{ $email }}" readonly />

                <input type="text" name="code" class="email" value="{{ old('code') }}"
                    placeholder="saisir le code recu par email" />

                @error('code')
                    <span class="error_span"">{{ $message }}</span>
                @enderror

                <input type="password" name="password" placeholder="Nouveau mot de passe" />

                @error('password')
                    <div class="error_span">{{ $message }}</div>
                @enderror

                <input type="password" name="confirm_password" placeholder="Mot de passe de confirmation" />
                @error('confirm_password')
                    <span class="error_span">{{ $message }}</span>
                @enderror

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
