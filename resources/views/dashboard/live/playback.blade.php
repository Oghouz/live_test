@extends('dashboard.layout.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Playback</h4>
                    <p class="card-description">
                        List de diffusion
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>
                                    Titre
                                </th>
                                <th>
                                    Lancer par
                                </th>
                                <th>
                                    Durée de diffusion
                                </th>
                                <th>
                                    Commencer le
                                </th>
                                <th>
                                    Terminer le
                                </th>
                                <th class="text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lives as $live)
                                <tr>
                                <td class="fw-bold">
                                    {{ $live->title }}
                                </td>
                                <td>
                                    <i class="mdi mdi-account"></i> {{ $live->user->name }}
                                </td>
                                <td>
                                    <i class="mdi mdi-clock-alert-outline"></i>
                                    {{ \App\Http\Controllers\DashboardController::calcTimeDiff($live->started_at, $live->ended_at) }}
                                </td>
                                <td>
                                    {{ $live->started_at }}
                                </td>
                                <td>
                                    {{ $live->ended_at }}
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-danger btn-rounded btn-icon">
                                        <i class="ti-control-play"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-info btn-rounded btn-icon">
                                        <i class="mdi mdi-file-move"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
