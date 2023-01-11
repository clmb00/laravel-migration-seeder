@extends('layouts.main')

@section('content')
<div class="container">
    <h1 class="my-4 fw-bold">Trains</h1>
    <div class="card mb-5">
        <div class="card-body">
            <h3 class="card-title mb-3">Cerca un treno</h3>
            <div class="card-text">
                <form method="get">

                    <div class="row">
                        <div class="col-auto me-5">
                            <div class="row align-items-center">
                                <div class="col-auto mb-2">
                                    <label for="input_partenza" class="col-form-label fs-4 fw-bolder"><i class="bi bi-arrow-up-right"></i></label>
                                </div>
                                <div class="col-auto mb-2">
                                    <input type="text" id="input_partenza" name="input_partenza" class="form-control" placeholder="Partenza">
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-auto mb-2">
                                    <label for="input_arrivo" class="col-form-label fs-4 fw-bolder"><i class="bi bi-arrow-down-right"></i></label>
                                </div>
                                <div class="col-auto mb-2">
                                    <input type="text" id="input_arrivo" name="input_arrivo" class="form-control" placeholder="Arrivo">
                                </div>
                            </div>
                        </div>
                        <div class="col-auto me-5">
                            <div class="row align-items-center">
                                <div class="col-auto mb-2">
                                    <label for="input_tipologia" class="col-form-label"><i class="bi bi-train-front-fill fs-4"></i> <span class="ps-2" style="font-size: 1.1rem">Tipologia treni: </span></label>
                                </div>
                                <div class="col-auto mb-2">
                                    <select class="form-select" name="input_tipologia" id="input_tipologia" aria-label="Selezione tipo di Treno">
                                        <option selected value="null">Tutti</option>
                                        <option value="AV">AV - Altavelocità</option>
                                        <option value="IC">IC - Intercity</option>
                                        <option value="REG">REG - Regionale</option>
                                        <option value="RV">RV - Regionale Veloce</option>
                                        <option value="SUB">SUB - Suburbano</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-auto mb-2">
                                    <label for="input_ora_part" class="col-form-label"><i class="bi bi-clock-history fs-4"></i> <span class="ps-2" style="font-size: 1.1rem">Orario di Partenza: </span></label>
                                </div>
                                <div class="col-auto mb-2">
                                    <input type="time" id="input_ora_part" name="input_ora_part" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="row align-items-center">
                                <div class="col-auto mb-2">
                                    <label for="order_by" class="col-form-label"><i class="bi bi-list-ol fs-4"></i> <span class="ps-2" style="font-size: 1.1rem">Ordina per: </span></label>
                                </div>
                                <div class="col-auto mb-2">
                                    <select class="form-select" name="order_by" id="order_by" aria-label="Selezione tipo di Treno">
                                        <option selected value="null">--</option>
                                        <option value="numero_carrozze">Numero carrozze</option>
                                        <option value="orario_di_partenza">Orario di partenza</option>
                                        <option value="orario_di_arrivo">Orario di arrivo</option>
                                        <option value="codice_treno">Codice Treno</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="card-subtitle">Treni trovati: {{ count($trains) }}</h6>
                        </div>
                        <div class="col" style="text-align: right">
                            <button class="btn btn-outline-danger mx-2" type="reset">Reset <i class="bi bi-x-lg"></i></button>
                            <button class="btn btn-primary mx-2" type="submit">Cerca  <i class="bi bi-search"></i></button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    @foreach ($trains as $train)
    <div class="card mb-4 text-bg-success {{$train->in_orario ? '' : 'text-bg-warning'}} {{$train->cancellato ? 'text-bg-danger' : ''}}">
        <div class="card-body">
            <h3 class="card-title">{{ $train->tipo_treno }} {{ $train->codice_treno }}</h3>
            <h5 class="card-subtitle mb-2">{{ $train->azienda }}</h5>
            <div class="card-text pt-3 fs-4">
                <div class="row">
                    <div class="col">
                    <p>P - <strong>{{ date_format(date_create($train->orario_di_partenza), "G:i")}}</strong> {{$train->stazione_di_partenza}}</p>
                    <p>A - <strong>{{ date_format(date_create($train->orario_di_arrivo), "G:i")}}</strong> {{$train->stazione_di_arrivo}}</p>
                    <p>Durata:
                        <strong>
                        <?php
                            $arrivo=date_create($train->orario_di_arrivo);
                            $partenza=date_create($train->orario_di_partenza);
                            if($partenza < $arrivo){
                                $diff=date_diff($arrivo,$partenza);
                                echo $diff->format("%H:%I");
                            } else {
                                $array_partenza = explode(':', $train->orario_di_partenza);
                                $ora_partenza = $array_partenza[0];
                                $min_partenza = $array_partenza[1];
                                $array_arrivo = explode(':', $train->orario_di_arrivo);
                                $ora_arrivo = $array_arrivo[0];
                                $min_arrivo = $array_arrivo[1];
                                $diff_ore = (24 - $ora_partenza) + ($ora_arrivo);
                                $diff_min = $min_partenza + $min_arrivo;
                                if ($diff_min >= 60) {
                                    $diff_ore++;
                                    $diff_min -= 60;
                                }
                                $diff_tot = date_create($diff_ore . ':' . $diff_min);
                                echo date_format($diff_tot,"H:i");
                            }
                        ?>
                        </strong>
                    </p>
                    </div>
                    <div class="col" style="text-align: right">
                    @if (!$train->cancellato)
                        <p>{{ $train->in_orario ? 'IN ORARIO' : 'IN RITARDO' }}</p>
                    @else
                        <p>CANCELLATO</p>
                    @endif
                    <span>{{ $train->numero_carrozze}}</span>
                    @for ($i = 0; $i < (14 - $train->numero_carrozze); $i++)
                    <i class="bi bi-train-front"></i>
                    @endfor
                    @for ($i = 0; $i < $train->numero_carrozze; $i++)
                        <i class="bi bi-train-front-fill"></i>
                    @endfor
                    {{-- <a href="#" class="card-link">ajnanj</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
