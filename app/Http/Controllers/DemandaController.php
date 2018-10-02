<?php

namespace App\Http\Controllers;

use App\Atendimento;
use App\Demanda;
use App\DemandaAtendimento;
use App\Sistema;

class DemandaController extends Controller
{
    public function index(){
        $listDemandas = Demanda::all();
        return view('demanda.index', ['demandas' => $listDemandas]);
    }

    public function cadastrar(){
        $atendimentos = Atendimento::all();
        $sistemas = Sistema::all();

        return view('demanda.cadastrar',[
            'atendimentos' => $atendimentos,
            'sistemas' => $sistemas,
        ]);
    }

    public function add(){

        //Salva a demanda
        $data = explode('/',$_REQUEST['demdatafinalizacao']);
        $_REQUEST['demdatafinalizacao'] = $data[2].'-'.$data[1].'-'.$data[0];
        $demid = Demanda::create($_REQUEST);

        //Salva os tipos de atendimento
        foreach($_REQUEST['atendimento'] as $ateid => $atendimento){
            if($atendimento['ocorrido'] == 'S'){
                $dat['datdescricao'] = $atendimento['descricao'];
                $dat['datquantidade'] = $atendimento['quantidade'];
                $dat['ateid'] = $ateid;
                $dat['demid'] = $demid;

                DemandaAtendimento::create($dat);
            }
        }

        return redirect('/');

    }

}
