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
            if($_GET['input_ora_part'] != '' && $_GET['input_tipologia'] != 'null'){
                $trains = Train::whereTime('orario_di_partenza', '>', $_GET['input_ora_part'])
                            ->where('stazione_di_partenza','like','%' . $_GET['input_partenza'] . '%')
                            ->where('stazione_di_arrivo', 'like', '%' . $_GET['input_arrivo'] . '%')
                            ->where('tipo_treno', 'like', $_GET['input_tipologia'])
                            ->get();
            } else if($_GET['input_ora_part'] != '') {
                $trains = Train::whereTime('orario_di_partenza', '>', $_GET['input_ora_part'])
                            ->where('stazione_di_partenza','like','%' . $_GET['input_partenza'] . '%')
                            ->where('stazione_di_arrivo', 'like', '%' . $_GET['input_arrivo'] . '%')
                            ->get();
            } else if($_GET['input_tipologia'] != 'null'){
                $trains = Train::where('stazione_di_partenza','like','%' . $_GET['input_partenza'] . '%')
                            ->where('stazione_di_arrivo', 'like', '%' . $_GET['input_arrivo'] . '%')
                            ->where('tipo_treno', 'like', $_GET['input_tipologia'])
                            ->get();
            } else {
                $trains = Train::where('stazione_di_partenza','like','%' . $_GET['input_partenza'] . '%')
                            ->where('stazione_di_arrivo', 'like', '%' . $_GET['input_arrivo'] . '%')
                            ->get();
            }
        } else {
            $trains = Train::all();
        }

        return view('home', compact('trains'));
    }
}
