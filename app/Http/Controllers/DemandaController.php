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
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DemandaController extends Controller
{
    private $totalPage = 10;

    public function index(){
        if(isset($_REQUEST['demnumero'])&& !isset($_REQUEST['todos'])){
            $listDemandas = Demanda::where('demnumero','=', $_REQUEST['demnumero'])
                ->paginate($this->totalPage);
        }else{
            $listDemandas = Demanda::paginate($this->totalPage);
        }

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

    public function editar($id){
        $atendimentos = Atendimento::all();
        $sistemas = Sistema::all();
        $tabelas = Tabelas::all();
        $owners = Tabelas::all('tabowner')->sortBy("tabowner")->groupBy('tabowner');

        $demanda = DB::table('demanda')
            ->join('sistema', 'demanda.sisid', '=', 'sistema.sisid')
            ->where('demid','=',$id)
            ->get();

        $atendimentosDemanda = DB::table('atendimento')
            ->leftjoin('demanda_atendimento', 'demanda_atendimento.ateid', '=', 'atendimento.ateid')
            ->leftjoin('demanda', 'demanda.demid', '=', 'demanda_atendimento.demid')
            ->where('demanda.demid','=',$id)
            ->get();

        return view('demanda.editar',[
            'atendimentos' => $atendimentos,
            'sistemas' => $sistemas,
            'tabelas' => $tabelas,
            'owners' => $owners,
            'demanda' => $demanda,
            '$atendimentosDemanda' => $atendimentosDemanda,
        ]);
    }

    public function add(Request $request)
    {
        DB::beginTransaction();
        try {
            $encoding = mb_internal_encoding();

            //Salva a demanda
            $_REQUEST['demdescricao'] = mb_strtoupper($_REQUEST['demdescricao'], $encoding);
            $demid = Demanda::create($_REQUEST);
            $demnumero = $_REQUEST['demnumero'];

            //Salva os arquivos de evidencias.
            if(!is_dir("demandas\dem_{$demnumero}")){
                mkdir("demandas\dem_{$demnumero}");
            }

            //Salva os tipos de atendimento
            foreach ($_REQUEST['atendimento'] as $ateid => $atendimento) {
                if ($atendimento['ocorrido'] == 'S') {
                    $dat['datdescricao'] = mb_strtoupper($atendimento['descricao'], $encoding);
                    $dat['datquantidade'] = $atendimento['quantidade'];
                    $dat['ateid'] = $ateid;
                    $dat['demid'] = $demid->id;

                    DemandaAtendimento::create($dat);
                }
            }

            if (isset($request->funcionalidade)) {
                foreach ($request->funcionalidade as $nrFunc => $funcionalidade) {
                    $funcionalidade['sisid'] = $_REQUEST['sisid'];
                    $funcionalidade['demid'] = $demid->id;
                    $funcionalidade['funnome'] = mb_strtoupper($funcionalidade['funnome'], $encoding);
                    $funid = Funcionalidade::create($funcionalidade);

                    $funcionalidade['funid'] = $funid->id;
                    $funcionalidade['defdescricao'] = mb_strtoupper($funcionalidade['defdescricao'], $encoding);
                    $funcionalidade['defalteracaoarquivos'] = mb_strtoupper($funcionalidade['defalteracaoarquivos'], $encoding);
                    $funcionalidade['defcargadados'] = mb_strtoupper($funcionalidade['defcargadados'], $encoding);

                    if (isset($funcionalidade['evidencia1'])) {
                        $funcionalidade['evidencia1']->storeAs("dem_{$demnumero}", $funcionalidade['funnome'].'_'.$funcionalidade['evidencia1']->getClientOriginalName());
                        $funcionalidade['evidencia1'] = $funcionalidade['evidencia1']->getClientOriginalName();
                    }
                    if (isset($funcionalidade['evidencia2'])) {
                        $funcionalidade['evidencia2']->storeAs("dem_{$demnumero}", $funcionalidade['funnome'].'_'.$funcionalidade['evidencia2']->getClientOriginalName());
                        $funcionalidade['evidencia2'] = $funcionalidade['evidencia2']->getClientOriginalName();
                    }
                    if (isset($funcionalidade['evidencia3'])) {
                        $funcionalidade['evidencia3']->storeAs("dem_{$demnumero}", $funcionalidade['funnome'].'_'.$funcionalidade['evidencia3']->getClientOriginalName());
                        $funcionalidade['evidencia3'] = $funcionalidade['evidencia3']->getClientOriginalName();
                    }

                    DemandaFuncionalidade::create($funcionalidade);

                    if (isset($funcionalidade['tabela'])) {
                        foreach ($funcionalidade['tabela'] as $tabela) {
                            $tabela['tabid'] = $tabela['tabid'];
                            $tabela['funid'] = $funcionalidade['funid'];
                            FuncionalideTabelas::create($tabela);
                        }
                    }
                }
            }

            //Monta o XLS documento de metricas
            $montaExcel = $this->montaExcel($demid->id);
            file_put_contents("demandas\dem_{$demnumero}\\$montaExcel[nomeDoc].xls", $montaExcel['xls']);

            //cria o zip para download
            $zipper = new \Chumper\Zipper\Zipper;
            $files = glob(public_path('demandas/dem_'.$demnumero.'/*'));
            $zipper->make('demandas/dem_'. $demnumero.'/dem_'. $demnumero.'.zip')->add($files);

            DB::commit();
            return redirect('/');
        }catch(\Exception $e) {
            DB::rollback();
            throw $e;
        }

    }

    public function exportar(){
        return response()->download(public_path('demandas/dem_'.$_REQUEST['demid'].'/dem_'.$_REQUEST['demid'].'.zip'));
    }

    public function montaExcel($demid){

        $todosAtendimentos = Atendimento::all();

        $demanda = DB::table('demanda')
            ->join('sistema', 'demanda.sisid', '=', 'sistema.sisid')
            ->where('demid','=',$demid)
            ->get();

        $atendimentosDemanda = DB::table('atendimento')
        ->leftjoin('demanda_atendimento', 'demanda_atendimento.ateid', '=', 'atendimento.ateid')
        ->leftjoin('demanda', 'demanda.demid', '=', 'demanda_atendimento.demid')
        ->where('demanda.demid','=',$demid)
        ->get();

        $funcionaliaddes = DB::table('funcionalidade')
        ->leftjoin('demanda_funcionalidade', 'demanda_funcionalidade.funid', '=', 'funcionalidade.funid')
        ->leftjoin('demanda', 'demanda.demid', '=', 'demanda_funcionalidade.demid')
        ->where('demanda.demid','=',$demid)
        ->get();

        $xls = "";
        $xls .= "<table border='1'>";
        $xls .= "<tr style='font-size: 25px;'>";
        $xls .= "<th>#{$demanda[0]->demnumero}</th>";
        $xls .= "<th colspan='4'>Informações de Sustentação</th>";
        $xls .= "</tr>";
        $xls .= "<tr>";
        $xls .= "<th>O que foi feito para atender a demanda?</th>";
        $xls .= "<th>Sim</th>";
        $xls .= "<th>Não</th>";
        $xls .= "<th>Quantidade</th>";
        $xls .= "<th>Descrição da Solução</th>";
        $xls .= "</tr>";
        foreach($todosAtendimentos as $id => $atendimento){
            $zebra = ($id % 2 == 0) ? 'style="background-color: #dcf5f6;"' : '';
            $xls .= "<tr $zebra>";
            $xls .= "<td>$atendimento->atedescricao</td>";
            $imprime = true;
            foreach($atendimentosDemanda as $ateDemanda){
                if($atendimento->ateid == $ateDemanda->ateid){
                    $imprime = false;
                    $xls .= "<td><center>X</center></td>";
                    $xls .= "<td></td>";
                    $xls .= "<td><center>$ateDemanda->datquantidade</center></td>";
                    $xls .= "<td style='text-align: left'>$ateDemanda->datdescricao</td>";
                }
            }
            if($imprime){
                $xls .= "<td></td>";
                $xls .= "<td><center>X</center></td>";
                $xls .= "<td><center>0</center></td>";
                $xls .= "<td><center>---</center></td>";
            }
            $xls .= "</tr>";
        }
        $xls .= "</table>";

        $xls .= "<br>";

        $xls .= "<table border='1'>";
        $xls .= "<tr style='font-size: 25px;'>";
        $xls .= "<th colspan='9'>Informações Necessárias para Contagem</th>";
        $xls .= "</tr>";
        $xls .= "<tr>";
        $xls .= "<th rowspan='2' >#</th>";
        $xls .= "<th rowspan='2'>Funcionalidades<br>Impactadas</th>";
        $xls .= "<th rowspan='2'>Descrição da<br>Manutenção</th>";
        $xls .= "<th rowspan='2'>Tipo de<br>Mudança</th>";
        $xls .= "<th colspan='3'>Tabelas Utilizadas<br>pela Funcionalidade</th>";
        $xls .= "<th rowspan='2'>Alteração em <br>arquivos ou tabelas</th>";
        $xls .= "<th rowspan='2'>Carga de<br>Dados</th>";
        $xls .= "</tr>";
        $xls .= "<tr>";
        $xls .= "<th>Nome da Tabela</th>";
        $xls .= "<th>Já era Utilizada</th>";
        $xls .= "<th>tipo de Acesso</th>";
        $xls .= "</tr>";
        foreach($funcionaliaddes as $qtd => $funcionalidade){
            $zebra = ($qtd % 2 == 0) ? 'style="background-color: #dcf5f6;"' : '';
            $tabelas = DB::table('tabelas')
                ->leftjoin('funcionalidade_tabelas', 'funcionalidade_tabelas.tabid' ,'=','tabelas.tabid')
                ->where('funcionalidade_tabelas.funid','=', $funcionalidade->funid )
                ->get();
            $qtdTabelas = count($tabelas);

            $rowspan = "rowspan='$qtdTabelas'";
            foreach($tabelas as $id => $tabela){
            $xls .= "<tr $zebra>";
            if($id == 0){
                $xls .= "<td $rowspan>$qtd</td>";
                $xls .= "<td $rowspan>$funcionalidade->funnome</td>";
                $xls .= "<td $rowspan>$funcionalidade->defdescricao</td>";
                $xls .= "<td $rowspan><center>$funcionalidade->deftipomudanca</center></td>";
            }
            $xls .= "<td>";
            $xls .= $tabela->tabowner . "." . $tabela->tabnome;
            $xls .="</td>";
            $xls .= "<td><center>$tabela->tafutilizada</center></td>";
            $xls .= "<td><center>$tabela->taftipoacesso</center></td>";
            if($id == 0){
                $xls .= "<td $rowspan>$funcionalidade->defalteracaoarquivos</th>";
                $xls .= "<td $rowspan>$funcionalidade->defcargadados</td>";
                $xls .= "</tr>";
                }
            }
        }
        $xls .= "</table>";
        $retorno['nomeDoc'] = $demanda[0]->sisnome . ' - ' . $demanda[0]->demnumero . ' - ' . $demanda[0]->demtipo;
        $retorno['xls'] = $xls;

        return $retorno;
    }

}
