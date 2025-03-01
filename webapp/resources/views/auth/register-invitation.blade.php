<x-guest-layout>
    <div class="row">
        <div class="offset-lg-4 col-lg-4">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <b>INSCRIVEZ VOUS AVEC VOTRE CODE D'INVITATION</b>

                <div class="form-group mt-4">
                    <label for="my-input">Code d'invitation</label>
                    <input id="my-input" class="form-control @error('code') is-invalid @enderror" type="text" name="code" value="{{old('code')}}" required >
                    @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="form-group row">

                    <div class="col-md-12">
                        <label for="pseudo" class="">Pseudo</label>

                        <input id="pseudo" type="text" class="form-control @error('pseudo') is-invalid @enderror" name="pseudo" value="{{ old('pseudo') }}" required autocomplete="pseudo">

                        @error('pseudo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-md-12">
                        <label for="password" class="">Mot de passe</label>

                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>


                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            Inscrire
                        </button>
                    </div>
                </div>
            </form>

            <hr>

            <div class="d-flex justify-content-center">
                <a href="{{route('login')}}">Se connecter</a>
            </div>
        </div>
    </div>
</x-guest-layout>
