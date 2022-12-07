@extends('layouts.desktop')


@section('content')
    <div class="container-fluid p-3">
        <div class="row">
            <div class="col">
                <div>
                    <broadcaster :auth_user_id="{{ $id }}"
                                 home_url="{{ env('APP_URL') }}"
                                 env="{{ env('APP_ENV') }}"
                                 turn_url="{{ env('TURN_SERVER_URL') }}"
                                 turn_username="{{ env('TURN_SERVER_USERNAME') }}"
                                 turn_credential="{{ env('TURN_SERVER_CREDENTIAL') }}" />

                </div>
            </div>
        </div>
    </div>


@endsection
