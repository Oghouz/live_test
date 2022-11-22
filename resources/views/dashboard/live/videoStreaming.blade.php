@extends('dashboard.layout.app')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $live->title }}</h4>
                    <p class="card-description">{{ $live->description }}</p>
                    <p>Créer le {{ $live->created_at }}, par : {{ $live->user->name }}</p>
                    <hr>
                    <div class="media">
                        <i class="ti-files pe-2"></i>
                        <div class="media-body">
                            <p class="card-text text-primary">Test.mp4</p>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-info">Sélectionner le fichier</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <video-broadcaster :auth_user_id="{{ $id }}"
                         home_url="{{ env('APP_URL') }}"
                         env="{{ env('APP_ENV') }}"
                         live_id="{{ $live->id }}"
                         turn_url="{{ env('TURN_SERVER_URL') }}"
                         turn_username="{{ env('TURN_SERVER_USERNAME') }}"
                         turn_credential="{{ env('TURN_SERVER_CREDENTIAL') }}" />

        </div>
    </div>
@endsection
