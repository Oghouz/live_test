@extends('layouts.wait_live_layout')

@section('style')
    <style>
        body{
            text-align: center;
            background: #00ECB9;
            font-family: sans-serif;
            font-weight: 100;
        }
        h1{
            color: #396;
            font-weight: 100;
            font-size: 30px;
            margin: 40px 0px 20px;
        }
        #clockdiv{
            font-family: sans-serif;
            color: #fff;
            display: inline-block;
            font-weight: 100;
            text-align: center;
            font-size: 30px;
        }
        #clockdiv > div{
            padding: 10px;
            border-radius: 3px;
            background: #00BF96;
            display: inline-block;
        }
        #clockdiv div > span{
            padding: 15px;
            border-radius: 3px;
            background: #00816A;
            display: inline-block;
        }
        .smalltext{
            padding-top: 5px;
            font-size: 16px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1>LIVE COMMENCE DANS</h1>
                    <div id="clockdiv">
                        <div>
                            <span class="days"></span>
                            <div class="smalltext">Jours</div>
                        </div>
                        <div>
                            <span class="hours"></span>
                            <div class="smalltext">Heures</div>
                        </div>
                        <div>
                            <span class="minutes"></span>
                            <div class="smalltext">Minutes</div>
                        </div>
                        <div>
                            <span class="seconds" id="seconds"></span>
                            <div class="smalltext">Seconds</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h6>L'événement en direct n'a pas encore commencé</h6>
                                </div>
                                <hr>
                                <h3>{{ $live->title }}</h3>
                                <p>{!! nl2br($live->description) !!}</p>
                            </div>
                            <div class="card-footer">
                                <small>POWERED BY NEXT REACH</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection

@section('script')
    <script>
        function getTimeRemaining(endtime) {
            const total = Date.parse(endtime) - Date.parse(new Date());
            const seconds = Math.floor((total / 1000) % 60);
            const minutes = Math.floor((total / 1000 / 60) % 60);
            const hours = Math.floor((total / (1000 * 60 * 60)) % 24);
            const days = Math.floor(total / (1000 * 60 * 60 * 24));

            return {
                total,
                days,
                hours,
                minutes,
                seconds
            };
        }

        function initializeClock(id, endtime) {
            const clock = document.getElementById(id);
            const daysSpan = clock.querySelector('.days');
            const hoursSpan = clock.querySelector('.hours');
            const minutesSpan = clock.querySelector('.minutes');
            const secondsSpan = clock.querySelector('.seconds');

            function updateClock() {
                const t = getTimeRemaining(endtime);

                daysSpan.innerHTML = t.days;
                hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
                minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
                secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

                if (t.total <= 0) {
                    clearInterval(timeinterval);
                    window.location.href = "{{ route('live.loading') }}"
                }
            }

            updateClock();
            const timeinterval = setInterval(updateClock, 1000);
        }

        const deadline = new Date(Date.parse(new Date()) + 1 * 1 * 1 * 10 * 1000);
        initializeClock('clockdiv', deadline);
    </script>
@endsection
