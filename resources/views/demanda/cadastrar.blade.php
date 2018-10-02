<html>
<meta charset="utf-8"/>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <meta charset="utf-8"/>

</head>
<style>
    html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 200;
        height: 100vh;
        margin: 0;
    }

    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 84px;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .m-b-md {
        margin-bottom: 30px;
    }
</style>
<body>
<div class="flex-center position-ref">
    <div class="content">
        <div class="title m-b-md">
            SISDM
        </div>
    </div>
</div>
<div class="well center">
    <form action="{{ url('/add') }}" method="POST">
        {{ csrf_field() }}
        <div class="input-group">
            <span class="input-group-addon">Demanda</span>
            <input type="text" class="form-control" name="demnumero"
                   placeholder="Demanda" size="60">
            <span class="input-group-addon" id="basic-addon1">Sistema</span>
            <select class="form-control" name="sisid">
                @foreach($sistemas as $sistema)
                    <option value="{{$sistema->sisid}}">{{$sistema->siscodigo}} - {{$sistema->sisnome}}</option>
                @endforeach
            </select>
        </div>
        <br>
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Descrição</span>
            <input type="text" name="demdescricao" class="form-control" placeholder="Descrição da demanda"
                   aria-describedby="basic-addon1">
        </div>
        <br>
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Tipo de Alteração</span>
            <select class="form-control" name="demtipo">
                <option value="E">Evolutiva</option>
                <option value="N">Nova Funcionalidade</option>
                <option value="S">Sustentação</option>
            </select>
            <span class="input-group-addon" id="basic-addon1">Data Finalização</span>
            <input type="text" name="demdatafinalizacao" class="form-control" placeholder="##/##/####"
                   aria-describedby="basic-addon1">
            <input type="text" class="form-control cpf-mask" placeholder="Ex.: 000.000.000-00">
        </div>
        <br>

        <div class="panel panel-danger">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <center><b>Informações da Sustentação</b></center>
            </div>
            <!-- Table -->
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">O que foi feito na demanda?</th>
                    <th scope="col">Sim</th>
                    <th scope="col">Não</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Descrição</th>
                </tr>
                </thead>
                <tbody>
                @foreach($atendimentos as $atendimento)
                    <tr>
                        <th scope="row" width="30%">{{ $atendimento->atedescricao }}</th>
                        <td><input type="radio" name="atendimento[{{ $atendimento->ateid }}][ocorrido]" value="S"
                                   onchange="liberaCampos('s',{{ $atendimento->ateid }})"></td>
                        <td><input type="radio" name="atendimento[{{ $atendimento->ateid }}][ocorrido]" value="N"
                                   onchange="liberaCampos('n',{{ $atendimento->ateid }})" checked></td>
                        <td width="5%"><input type="text" disabled class="form-control" placeholder="QTD"
                                              name="atendimento[{{ $atendimento->ateid }}][quantidade]"
                                              id="quantidade_{{ $atendimento->ateid }}" aria-describedby="basic-addon1"
                                              size="8"></td>
                        <td><input type="text" disabled class="form-control" placeholder="Descrição"
                                   name="atendimento[{{ $atendimento->ateid }}][descricao]"
                                   id="descricao_{{ $atendimento->ateid }}"
                                   aria-describedby="basic-addon1"></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="panel panel-danger" id="funcionaldades">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <center><b>Correções de Código / Tabelas</b></center>
            </div>
            <br>
            <button type="button" onclick="AddFuncionalidade()" type="button">Nova Funcionalidade</button>
            <input type="hidden" name="idfunc" value="0" id="idfunc">
            <br><br>
            <div id="divFuncionalidades">

            </div>

        </div>
        <br>
        <div class="input-group">
            <button type="button" style="margin-top: 5px; float: outside" class="btn btn-danger" onclick="window.location.href='/'">Voltar
            </button>
            <button style="margin-top: 5px; float: right" class="btn btn-primary">Salvar</button>
        </div>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
</body>
</html>

<script>
    $(document).ready(function () {
        $('#funcionaldades').hide();
    });

    function liberaCampos(liberar, id) {
        if (liberar == 's') {
            $('#descricao_' + id).prop('disabled', false);
            $('#quantidade_' + id).prop('disabled', false);

            if (id == 3) {
                $('#funcionaldades').show();
            }

        } else {
            $('#descricao_' + id).val('');
            $('#descricao_' + id).prop('disabled', true);
            $('#quantidade_' + id).val('');
            $('#quantidade_' + id).prop('disabled', true);

            if (id == 3) {
                $('#funcionaldades').hide();
            }
        }
    }

    //Adiciona e remove funcionalidades inteiras
    (function ($) {
        AddFuncionalidade = function () {
            var idfunc = $('#idfunc').val();

            var func = "";
            func += '<div class="panel panel-success" id="funcionaldades_'+idfunc+'">';
            func += '<div class="panel-heading">';
            func += '<button type="button"  style="margin-top: 5px; float: outside" class="btn btn-danger btn-sm"';
            func += 'onclick="RemoveFuncionalidade('+idfunc+')">X';
            func += '</button> &nbsp;<span class="badge badge-pill badge-primary">Funcionalidade '+idfunc+'</span>';
            func += '</div>';
            func += '<div class="input-group">';
            func += '<span class="input-group-addon">Funcionalidade</span>';
            func += '<input type="text" class="form-control" name="funcionalidade['+idfunc+'][funcnome]"';
            func += 'placeholder="Demanda" size="60">';
            func += '<span class="input-group-addon">Tipo de Mudança</span>';
            func += '<select class="form-control" name="funcionalidade['+idfunc+'][demtipo]">';
            func += '<option value="E">Evolutiva</option>';
            func += '<option value="N">Nova Funcionalidade</option>';
            func += '<option value="S">Sustentação</option>';
            func += '</select>';
            func += '</div>';
            func += '<br>';
            func += '<div class="input-group">';
            func += '<span class="input-group-addon">Descrição da Manutenção</span>';
            func += '<textarea class="form-control" aria-label="With textarea" name="funcionalidade['+idfunc+'][funcdescricao]"></textarea>';
            func += '</div>';
            func += '<br>';
            func += '<div class="input-group">';
            func += '<span class="input-group-addon">Alteração em Arquivos ou Tabelas?</span>';
            func += '<textarea class="form-control" aria-label="With textarea" name="funcionalidade['+idfunc+'][funcdescalteracao]"></textarea>';
            func += '</div>';
            func += '<br>';
            func += '<div class="input-group">';
            func += '<span class="input-group-addon">Carga de Dados</span>';
            func += '<textarea class="form-control" aria-label="With textarea name="funcionalidade['+idfunc+'][funcdesccargadados]"></textarea>';
            func += '</div>';
            func += '<br>';
            func += '<button onclick="AddTableRow()" type="button">Adicionar Tabelas a funcionalidade</button>';
            func += '<input type="hidden" value="0" name="funcionalidade['+idfunc+'][qtdtabelas]">';
            func += '<table id="tabela_funcionalidades" class="table table-striped">';
            func += '<tbody>';
            func += '<tr>';
            func += '<th width="10%"></th>';
            func += '<th width="50%">Tabela</th>';
            func += '<th width="20%">Já era Utilizada</th>';
            func += '<th width="20%">Tipo de Acesso</th>';
            func += '</tr>';
            func += '<tr>';
            func += '<td>';
            func += '<center>';
            func += '<button type="button" onclick="RemoveRow(this)" style="margin-top: 5px; float: outside"';
            func += 'class="btn btn-danger btn-sm">X';
            func += '</button>';
            func += '</center>';
            func += '</td>';
            func += '<td><input type="text" class="form-control" name="funcionalidade['+idfunc+'][tabelas][][tabnome]"';
            func += 'placeholder="Demanda" size="60"></td>';
            func += '<td>';
            func += '<input type="radio" name="funcionalidade['+idfunc+'][tabelas][][tabutilizacao]" value="S">Sim';
            func += '&nbsp;&nbsp;';
            func += '<input type="radio" name="funcionalidade['+idfunc+'][tabelas][][tabutilizacao]" value="N" checked>Não';
            func += '</td>';
            func += '<td><select class="form-control" name="funcionalidade['+idfunc+'][tabelas][][tabtipoacesso]">';
            func += '<option value="E">Escrita</option>';
            func += '<option value="L">Leitura</option>';
            func += '<option value="EL">Escrita e Leitura</option>';
            func += '</select>';
            func += '</td>';
            func += '</tr>';
            func += '</tbody>';
            func += '</table>';
            func += '</div>';

            $("#divFuncionalidades").prepend(func);

            idfunc++;
            $('#idfunc').val(idfunc);
        };
    })(jQuery);

    (function ($) {
        RemoveFuncionalidade = function (idfunc) {
            $("div").remove( "#funcionaldades_"+idfunc );
            return false;
        }
    })(jQuery);


    //Adiciona e remove linhas
    (function ($) {
        AddTableRow = function () {
            var qtd = $('#qtd_funcionalidade').val();

            var newRow = $("<tr>");
            var cols = "";
            cols += '<td><center>';
            cols += '<button type="button" onclick="RemoveRow(this)" style="margin-top: 5px; float: outside" class="btn btn-danger btn-sm">X</button>';
            cols += '</center></td>';
            cols += '<td><input type="text" class="form-control" name="funcionalidade['+qtd+'][tabnome]"\n' +
                '    placeholder="Nome da Tabela (schema.nometabela)" size="60"></td>';
            cols += '<td><input type="radio" name="funcionalidade['+qtd+'][tafutilizacao]" value="S" >Sim &nbsp;&nbsp; <input type="radio" name="funcionalidade['+qtd+'][tafutilizacao]" value="N" checked>Não</td>';
            cols += '<td><select class="form-control" name="funcionalidade['+qtd+'][tabpermissao]">\n' +
                '        <option value="E">Escrita</option>\n' +
                '        <option value="L">Leitura</option>\n' +
                '        <option value="EL">Escrita e Leitura</option>\n' +
                '    </select></td>';
            newRow.append(cols);
            $("#tabela_funcionalidades_" + qtd).append(newRow);
            return false;
        };
    })(jQuery);

    (function ($) {
        RemoveRow = function (item) {
            var tr = $(item).closest('tr');
            tr.fadeOut(400, function () {
                tr.remove();
            });
            return false;
        }
    })(jQuery);

</script>