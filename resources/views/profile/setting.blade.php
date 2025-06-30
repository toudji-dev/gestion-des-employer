@extends('layouts.template')

@section('content')
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <h1 class="app-page-title">Paramètres</h1>
            @if (Session::get('success_message'))
                <div class="alert alert-success">{{ Session::get('success_message') }}</div>
            @endif

            @if (Session::get('error_message'))
                <div class="alert alert-danger">{{ Session::get('error_message') }}</div>
            @endif


            <hr class="mb-4">
            <div class="row g-4 settings-section">
                <div class="col-12 col-md-4">
                    <h3 class="section-title">Générale</h3>
                    <div class="section-intro">Vous pouvez afficher et gérer les informations et les paramètres de votre
                        compte utilisateur à partir de cette page. </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="app-card app-card-settings shadow-sm p-4">


                        <div class="app-card-body px-4 w-100">




                            <div class="app-card-body">
                                <form class="settings-form" method="POST" action="{{ route('profile.update') }}">
                                    @csrf





                                    <div class="mb-3">










                                        <div class="right">



                                            <label for="setting-input-1" class="form-label"><strong>Nom</strong><span
                                                    class="ms-2" data-container="body" data-bs-toggle="popover"
                                                    data-trigger="hover" data-placement="top"
                                                    data-content="This is a Bootstrap popover example. You can use popover to provide extra info."><svg
                                                        width="1em" height="1em" viewBox="0 0 16 16"
                                                        class="bi bi-info-circle" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                        <path
                                                            d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z" />
                                                        <circle cx="8" cy="4.5" r="1" />
                                                    </svg></span></label>
                                            <input type="text" class="form-control" id="setting-input-1" placeholder=""
                                                name="name" value="{{ Auth::user()->name }}" required>


                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="setting-input-3" class="form-label"><STRONG>Email</STRONG></label>
                                            <input type="email" class="form-control" id="setting-input-3" name="email"
                                                placeholder="Entrer le mail" value="{{ Auth::user()->email }}">


                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="setting-input-3" class="form-label"><STRONG>mot de
                                                    passe</STRONG>
                                            </label>
                                            <input type="password" class="form-control" id="setting-input-3"
                                                name="old-password" placeholder="" value="">


                                            @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="setting-input-3" class="form-label"><STRONG>Nouveau mot de
                                                    passe</STRONG></label>
                                            <input type="password" class="form-control" id="setting-input-3"
                                                name="new-password" value="" placeholder="">


                                            @error('montant_journalier')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="setting-input-3" class="form-label"><strong>Confirmez le mot
                                                    de
                                                    passe</strong></label>
                                            <input type="password" class="form-control" id="setting-input-3"
                                                name="confirm-new-password" value="" placeholder="">


                                            @error('confirm-new-password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn app-btn-primary">Mettre a jour</button>
                                </form>
                            </div>







                        </div><!--//app-card-body-->


                    </div><!--//app-card-->
                </div><!--//col-->





            </div><!--//row-->

        </div><!--//container-fluid-->
    </div><!--//app-content-->
@endsection
