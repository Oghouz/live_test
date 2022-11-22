@extends('dashboard.layout.app')

@section('content')
    <div class="row">
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <h4 class="card-title">Live streaming</h4>
                    <canvas id="lineChart" style="display: block; width: 733px; height: 366px;" width="733" height="366" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <h4 class="card-title">Utilisateur</h4>
                    <canvas id="barChart" style="display: block; width: 733px; height: 366px;" width="733" height="366" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <h4 class="card-title">Session</h4>
                    <canvas id="areaChart" style="display: block; width: 733px; height: 366px;" width="733" height="366" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <h4 class="card-title">Utilisateur device</h4>
                    <canvas id="doughnutChart" style="display: block; width: 733px; height: 366px;" width="733" height="366" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 grid-margin grid-margin-lg-0 stretch-card">
            <div class="card">
                <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <h4 class="card-title">Système d'exploitation</h4>
                    <canvas id="pieChart" style="display: block; width: 733px; height: 366px;" width="733" height="366" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 grid-margin grid-margin-lg-0 stretch-card">
            <div class="card">
                <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <h4 class="card-title">Spectateurs</h4>
                    <canvas id="scatterChart" style="display: block; width: 733px; height: 366px;" width="733" height="366" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/chart.js') }}"></script>
@endsection
