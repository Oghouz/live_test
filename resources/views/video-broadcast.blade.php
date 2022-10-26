@extends('layouts.app')


@section('content')
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
@endsection
