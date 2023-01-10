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
                                $diff = new DateTime('00:00');
                                $mezzanotteprima=date_create('24:59:59');
                                $mezzanottedopo=date_create('00:00:00');
                                $interval1=date_diff($mezzanotteprima,$partenza);
                                $interval2=date_diff($arrivo,$mezzanottedopo);
                                dump($diff);
                                $diff->add($interval1);
                                dump($diff);
                                $diff->add($interval2);
                                dump($diff);
                                echo date_format($diff, 'G:i');
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
                </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
</div>
@endsection
