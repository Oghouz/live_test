@extends('layouts.wait_live_layout')

@section('style')
    <style>
        .load-wrapp p {
            padding: 0 0 20px;
        }
        .ring-1 {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            padding: 10px;
            border: 7px dashed #4b9cdb;
            border-radius: 100%;
        }

        .load-4 .ring-1 {
            animation: loadingD 1.5s 0.3s cubic-bezier(0.17, 0.37, 0.43, 0.67) infinite;
        }

        @keyframes loadingA {
        0 {
            height: 15px;
        }
        50% {
            height: 35px;
        }
        100% {
            height: 15px;
        }
        }

        @keyframes loadingB {
        0 {
            width: 15px;
        }
        50% {
            width: 35px;
        }
        100% {
            width: 15px;
        }
        }

        @keyframes loadingC {
        0 {
            transform: translate(0, 0);
        }
        50% {
            transform: translate(0, 15px);
        }
        100% {
            transform: translate(0, 0);
        }
        }

        @keyframes loadingD {
        0 {
            transform: rotate(0deg);
        }
        50% {
            transform: rotate(180deg);
        }
        100% {
            transform: rotate(360deg);
        }
        }

        @keyframes loadingE {
        0 {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
        }

        @keyframes loadingF {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes loadingG {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }
            50% {
                transform: translate(70px, 0) rotate(360deg);
            }
            100% {
                transform: translate(0, 0) rotate(0deg);
            }
        }

        @keyframes loadingH {
            0% {
                width: 15px;
            }
            50% {
                width: 35px;
                padding: 4px;
            }
            100% {
                width: 15px;
            }
        }

        @keyframes loadingI {
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes bounce {
            0%,
            100% {
                transform: scale(0);
            }
            50% {
                transform: scale(1);
            }
        }

        @keyframes loadingJ {
            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(80px, 0);
                background-color: #f5634a;
                width: 25px;
            }
        }
        .card {
            background-color: #dfecf6b3;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row text-center mt-5">
            <div class="col mt-5">
                <div class="card p-5">
                    <div class="m-5">
                        <div class="load-4">
                            <div class="ring-1"></div>
                        </div>
                    </div>
                    <p class="fw-bold">Nous avons en train de se préparer le live</p>
                    <p>Merci de patienter quelques instant ...</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const delay = ms => new Promise(res => setTimeout(res, ms));
        const prepareLive = async () => {
            await delay(5000);
            console.log("OK")
            window.location.href = "https://localhost/live_test/public/streaming/17/eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c";
        }
        prepareLive();
    </script>
@endsection
