@extends('dashboard.layout.app')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $live->title }}</h4>
                    <p class="card-description">{{ $live->description }}</p>
                    <p>Créer le {{ $live->created_at }}, par : {{ $live->user->name }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <broadcaster :auth_user_id="{{ $id }}"
                         home_url="{{ env('APP_URL') }}"
                         env="{{ env('APP_ENV') }}"
                         live_id="{{ $live->id }}"
                         turn_url="{{ env('TURN_SERVER_URL') }}"
                         turn_username="{{ env('TURN_SERVER_USERNAME') }}"
                         turn_credential="{{ env('TURN_SERVER_CREDENTIAL') }}" />

        </div>
    </div>
@endsection
