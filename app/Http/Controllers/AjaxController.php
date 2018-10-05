<?php

namespace App\Http\Controllers;

use App\Demanda;
use App\Funcionalidade;
use App\Tabelas;
use Illuminate\Support\Facades\DB;

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

    public function autocompletefuncionalidade() {
        $funcionalidades = DB::table('funcionalidade')->select('funnome')
            ->where('funnome', 'like', '%'.$_REQUEST['funnome'].'%')
            ->get();

        $data=array();
        foreach ($funcionalidades as $funcionalidade) {
            $data[]=strtoupper($funcionalidade->funnome);
        }
        return $data;
    }

    public function autocompleteowner() {
        $owners = DB::table('tabelas')->select('tabowner')
            ->where('tabowner', 'like', '%'.$_REQUEST['tabowner'].'%')
            ->get()->sortBy('tabowner');

        $data=array();
        foreach ($owners as $owner) {
            $data[]=strtoupper($owner->tabowner);
        }
        return $data;
    }

    public function autocompletetabela() {
        $tabelas = DB::table('tabelas')->select('tabnome')
            ->where('tabnome', 'like', '%'.$_REQUEST['tabnome'].'%')
            ->get()->sortBy('tabnome');

        $data=array();
        foreach ($tabelas as $tabela) {
            $data[]=strtoupper($tabela->tabnome);
        }
        return $data;
    }

}
