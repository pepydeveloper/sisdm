<?php

namespace App\Http\Controllers;

use App\Atendimento;
use App\Demanda;
use App\Funcionalidade;
use App\Sistema;
use App\DemandaAtendimento;
use App\DemandaFuncionalidade;
use App\FuncionalideTabelas;
use App\Tabelas;

class DemandaController extends Controller
{
    public function index(){
        $listDemandas = Demanda::all();
        return view('demanda.index', ['demandas' => $listDemandas]);
    }

    public function cadastrar(){
        $atendimentos = Atendimento::all();
        $sistemas = Sistema::all();
        $tabelas = Tabelas::all();
        $owners = Tabelas::all('tabowner')->sortBy("tabowner")->groupBy('tabowner');

        return view('demanda.cadastrar',[
            'atendimentos' => $atendimentos,
            'sistemas' => $sistemas,
            'tabelas' => $tabelas,
            'owners' => $owners,
        ]);
    }

    public function add()
    {
        //Salva a demanda
        $data = explode('/', $_REQUEST['demdatafinalizacao']);
        $_REQUEST['demdatafinalizacao'] = $data[2] . '-' . $data[1] . '-' . $data[0];
        $demid = Demanda::create($_REQUEST);

        //Salva os tipos de atendimento
        foreach ($_REQUEST['atendimento'] as $ateid => $atendimento) {
            if ($atendimento['ocorrido'] == 'S') {
                $dat['datdescricao'] = $atendimento['descricao'];
                $dat['datquantidade'] = $atendimento['quantidade'];
                $dat['ateid'] = $ateid;
                $dat['demid'] = $demid->id;

                DemandaAtendimento::create($dat);
            }
        }

        if (isset($_REQUEST['funcionalidade'])) {
            foreach ($_REQUEST['funcionalidade'] as $funcionalidade) {
                $funcionalidade['sisid'] = $_REQUEST['sisid'];
                $funcionalidade['demid'] = $demid->id;
                $funcionalidade['funnome'] = strtoupper($funcionalidade['funnome']);
                $funid = Funcionalidade::create($funcionalidade);
                $funcionalidade['funid'] = $funid->id;
                DemandaFuncionalidade::create($funcionalidade);

                if(isset($funcionalidade['tabela'])){
                    foreach ($funcionalidade['tabela'] as $tabela) {
                        $tabela['tabid'] = $tabela['tabid'];
                        $tabela['funid'] = $funcionalidade['funid'];
                        FuncionalideTabelas::create($tabela);
                    }
                }
            }
        }
        return redirect('/');
    }

}
