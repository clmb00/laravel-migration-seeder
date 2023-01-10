@extends('layouts.main')

@section('content')
<div class="container">
    <h1 class="my-4 fw-bold">Trains</h1>
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
                    <p>Tempo impiegato:
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
                    <p>Carrozze: {{ $train->numero_carrozze}} </p>
                    @if (!$train->cancellato)
                        <p>In orario: {{ $train->in_orario ? 'Si' : 'No' }}</p>
                    @else
                        <p>CANCELLATO</p>
                    @endif
                    <p></p>
                </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
</div>
@endsection
