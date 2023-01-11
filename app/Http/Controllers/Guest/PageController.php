<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Train;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class PageController extends Controller
{
    public function index(){

        if(isset($_GET['input_partenza']) || isset($_GET['input_arrivo']) || isset($_GET['input_tipologia']) || isset($_GET['input_ora_part'])){

            $query_stazioni = Train::where('stazione_di_partenza','like','%' . $_GET['input_partenza'] . '%')
                                   ->where('stazione_di_arrivo', 'like', '%' . $_GET['input_arrivo'] . '%');

            // componi query
            if($_GET['input_ora_part'] != '' && $_GET['input_tipologia'] != 'null'){
                $query_trains = $query_stazioni
                                ->whereTime('orario_di_partenza', '>', $_GET['input_ora_part'])
                                ->where('tipo_treno', 'like', $_GET['input_tipologia']);
            } else if($_GET['input_ora_part'] != '') {
                $query_trains = $query_stazioni
                                ->whereTime('orario_di_partenza', '>', $_GET['input_ora_part']);
            } else if($_GET['input_tipologia'] != 'null'){
                $query_trains = $query_stazioni
                                ->where('tipo_treno', 'like', $_GET['input_tipologia']);
            } else {
                $query_trains = $query_stazioni;
            }

            // ordina se devi ordinare
            if($_GET['order_by'] != 'null'){
                $trains = $query_trains->orderBy($_GET['order_by'])->get();
            } else {
                $trains = $query_trains->get();
            }

        } else {
            $trains = Train::all();
        }

        return view('home', compact('trains'));
    }
}
