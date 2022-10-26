@extends('layouts.app')


@section('content')
<div class="container" style="margin-top: 250px; padding-bottom: 350px">
    <div class="row">
        <div class="col">
            <div class="text-center">
                @if ($type === 'broadcaster')
                    <broadcaster :auth_user_id="{{ $id }}"
                                 home_url="{{ env('APP_URL') }}"
                                 env="{{ env('APP_ENV') }}"
                                 turn_url="{{ env('TURN_SERVER_URL') }}"
                                 turn_username="{{ env('TURN_SERVER_USERNAME') }}"
                                 turn_credential="{{ env('TURN_SERVER_CREDENTIAL') }}" />
                @else
                    <viewer stream_id="{{ $streamId }}"
                            home_url="{{ env('APP_URL') }}"
                            :auth_user_id="{{ $id }}"
                            turn_url="{{ env('TURN_SERVER_URL') }}"
                            turn_username="{{ env('TURN_SERVER_USERNAME') }}"
                            turn_credential="{{ env('TURN_SERVER_CREDENTIAL') }}" />
                @endif
            </div>
        </div>
    </div>
</div>


@endsection
