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

    public function atualizaOwner() {
        $owners = Tabelas::all()->sortBy("tabowner")->groupBy('tabowner');

        $data=array();
        foreach ($owners as $owner) {
            $data[]=array('tabowner'=>$owner[0]->tabowner);
        }
        if(count($data))
            return json_encode($data);
    }

    public function addTabela(){
        $_REQUEST['tabnome'] = strtoupper($_REQUEST['tabnome']);
        $_REQUEST['tabowner'] = strtoupper($_REQUEST['tabowner']);

        $existeTabela = Tabelas::all()
            ->where('tabnome','=',$_REQUEST['tabnome'])
            ->where('tabowner','=',$_REQUEST['tabowner']);

        if(count($existeTabela) == 0){
            Tabelas::create($_REQUEST);
            return json_encode(true);
        }else{
            return json_encode(false);
        }
    }

    public function verificaDemanda(){
        $demanda = Demanda::all()->where('demnumero','=', $_REQUEST['demnumero'])->first();

        if(!is_null($demanda)){
            return json_encode(true);
        }else{
            return json_encode(false);
        }
    }

    public function verificaFuncionalidade(){

        $funcionalidade = DB::table('funcionalidade')
            ->where('funnome', 'like', '%'.$_REQUEST['funnome'].'%')
            ->where('sisid','=',$_REQUEST['sisid'])
            ->get()->sortByDesc('funid')->first();

        $tabelas = DB::table('tabelas')
            ->join('funcionalidade_tabelas', 'funcionalidade_tabelas.tabid', '=', 'tabelas.tabid')
            ->where('funcionalidade_tabelas.funid', '=', $funcionalidade->funid)
            ->get()->sortByDesc('tafid');

        if(!is_null($tabelas)){
            return json_encode($tabelas);
        }else{
            return json_encode(false);
        }
    }

    public function autoCompleteFuncionalidade() {
        $funcionalidades = DB::table('funcionalidade')->select('funnome')
            ->where('funnome', 'like', '%'.$_REQUEST['funnome'].'%')
            ->where('sisid','=',$_REQUEST['sisid'])
            ->groupBy('funnome')
            ->get();

        $data=array();
        foreach ($funcionalidades as $funcionalidade) {
            $data[]=strtoupper($funcionalidade->funnome);
        }
        return $data;
    }

    public function autoCompleteOwner() {
        $owners = DB::table('tabelas')->select('tabowner')
            ->where('tabowner', 'like', '%'.$_REQUEST['tabowner'].'%')
            ->groupBy('tabowner')
            ->sortBy('tabowner')
            ->get();

        $data=array();
        foreach ($owners as $owner) {
            $data[]=strtoupper($owner->tabowner);
        }
        return $data;
    }

    public function autoCompleteTabela() {
        $tabelas = DB::table('tabelas')->select('tabnome')
            ->where('tabnome', 'like', '%'.$_REQUEST['tabnome'].'%')
            ->sortBy('tabnome')
            ->groupBy('tabnome')
            ->get();

        $data=array();
        foreach ($tabelas as $tabela) {
            $data[]=strtoupper($tabela->tabnome);
        }
        return $data;
    }

}
