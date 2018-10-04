<?php

namespace App\Http\Controllers;

use App\Demanda;
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

    public function autoComplete(Request $request) {

        echo '<pre>';
        var_dump($_REQUEST);
        echo '</pre>';
        die;

        $query = $request->get('term','');

        $products=Product::where('name','LIKE','%'.$query.'%')->get();

        $data=array();
        foreach ($products as $product) {
            $data[]=array('value'=>$product->name,'id'=>$product->id);
        }
        if(count($data))
            return $data;
        else
            return ['value'=>'No Result Found','id'=>''];
    }
}
