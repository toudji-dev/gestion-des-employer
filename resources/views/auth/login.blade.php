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

    <form method="post" action="{{ route('handleLogin') }}">

        @csrf
        @method('POST')

        <div class="home-box">




            <div class="left">

                <img src="{{ asset('assets/images/undraw_task_list_6x9d.svg') }}" alt="">
            </div>

            <div class="right">



                <h4>Espace administrateur</h4>




                @if (Session::get('error_msg'))
                    <b class="error_span">{{ Session::get('error_msg') }}</b>
                @endif



                <input type="email" name="email" class="email"
                    @if (Cookie::has('adminemail')) value="{{ Cookie::get('adminemail') }}" @endif />
                @error('email')
                    <div class="error_span">{{ $message }}</div>
                @enderror

                <input type="password" name="password" class="email"
                    @if (Cookie::has('adminpswd')) value="{{ Cookie::get('adminpswd') }}" @endif />


                @error('password')
                    <div class="error_span">{{ $message }}</div>
                @enderror


                <div class="btn-container">
                    <button type="submit"> Connexion</button>
                </div>


                <div class="row justify-content-between align-items-center">

                    <div class="col-6">

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="remember"
                                name="remember"
                                @if (Cookie::has('adminchek')) {{ Cookie::get('adminchek') }} @endif />
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>

                        </div><!--//col-6-->
                    </div>
                    <div class="col-6">
                        <div class="forgot-password">
                            <a class="forgot-password" href="{{ route('reset.password') }}">Forgot password?</a>
                        </div>
                    </div>
                </div><!--//col-6-->




            </div>




        </div>
        <!-- End Right -->






    </form>



</body>

</html>
