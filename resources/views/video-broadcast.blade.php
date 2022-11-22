@extends('layouts.app')


@section('content')
<div class="container-fluid" style="margin-top: 150px; padding-bottom: 350px">
    <div class="row">
        <div class="col">
            <div class="text-center">
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
