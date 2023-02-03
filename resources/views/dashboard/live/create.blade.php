@extends('dashboard.layout.app')

@section('content')
    <form action="store" method="post">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Créer un live</h4>
                        <p class="card-description">
                            Information pour créer un live en direct
                        </p>
                        <form class="forms-sample">
                            @csrf
                            <div class="form-group">
                                <label for="title">Titre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" placeholder="Titre de votre live" required="required">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="title">Titre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" placeholder="Titre de votre live" required="required">
                            </div>


                            <button type="submit" class="btn btn-social-icon-text btn-twitter"><i class="ti-video-camera"></i>Créer</button>
                            <button class="btn btn-danger">Annuler</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Options</h4>
                        <p class="card-description">Les paramètre de live streaming</p>
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input">
                                                Partage caméra
                                                <i class="input-helper"></i></label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" checked="">
                                                Partage écran
                                                <i class="input-helper"></i></label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" disabled="">
                                                Partage son
                                                <i class="input-helper"></i></label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" disabled="" checked="">
                                                Partage micro
                                                <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios1" value="">
                                                Qualité Moyen
                                                <i class="input-helper"></i></label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios2" value="option2" checked="">
                                                Qualité supérieur
                                                <i class="input-helper"></i></label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optionsRadios2" id="optionsRadios3" value="option3" disabled="">
                                                Qualité HD
                                                <i class="input-helper"></i></label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optionsRadio2" id="optionsRadios4" value="option4" disabled="" checked="">
                                                Qualité 4K
                                                <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
