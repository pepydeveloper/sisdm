<?php

namespace App\Http\Controllers;

use App\Demanda;
use App\Funcionalidade;
use App\Tabelas;

class AjaxController extends Controller
{
    public function atualizaTabelas() {
        $tabelas = Tabelas::all()->where('tabowner','=',$_REQUEST['tabowner'])->sortBy('tabnome');

        $data=array();
        foreach ($tabelas as $tabela) {
            $data[]=array('tabnome'=>$tabela->tabnome,'tabid'=>$tabela->tabid);
        }
        if(count($data))
            return json_encode($data);
    }

    public function addtabela(){
        $_REQUEST['tabnome'] == strtoupper($_REQUEST['tabnome']);
        Tabelas::create($_REQUEST);

        return json_encode(true);
    }

    public function verificaDemanda(){
        $demanda = Demanda::all()->where('demnumero','=', $_REQUEST['demnumero'])->first();

        if(!is_null($demanda)){
            return json_encode(true);
        }else{
            return json_encode(false);
        }
    }

    public function autoComplete() {
        $funcionalidades = Funcionalidade::all()->where('funnome', 'like', '%"'.$_REQUEST['funnome'].'"%');;


        echo '<pre>';
        print_r($funcionalidades);
        echo '</pre>';
        die;

        $data=array();
        foreach ($funcionalidades as $funcionalidade) {
            $data[]=array('funnome'=>$funcionalidade->funnome);
        }
        return $data;
    }

}
