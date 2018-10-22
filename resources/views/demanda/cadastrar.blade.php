<html>
<meta charset="utf-8"/>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link href="http://demo.expertphp.in/css/jquery.ui.autocomplete.css" rel="stylesheet">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <meta charset="utf-8">
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
    .ui-autocomplete { position: absolute; cursor: default;z-index:1600 !important;}
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
    <form action="{{ url('/add') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="input-group">
            <span class="input-group-addon">Demanda</span>
            <input type="number" class="form-control" name="demnumero" id="demnumero"
                   placeholder="Demanda" size="60" onblur="verificaDemanda()">
            <span class="input-group-addon" id="basic-addon1">Sistema</span>
            <select class="form-control" name="sisid" id="sisid">
                @foreach($sistemas as $sistema)
                    <option value="{{$sistema->sisid}}">{{$sistema->sisnome}}</option>
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
                <option value="Evolutiva">Evolutiva</option>
                <option value="Nova Funcionalidade">Nova Funcionalidade</option>
                <option value="Sustentação">Sustentação</option>
            </select>
            <span class="input-group-addon" id="basic-addon1">Data Início</span>
            <input type="date" name="demdatainicio" id="demdatainicio" class="form-control" >
            <span class="input-group-addon" id="basic-addon1">Data Finalização</span>
            <input type="date" name="demdatafinalizacao" id="demdatafinalizacao" class="form-control" >
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
                        <td width="5%"><input type="number" disabled class="form-control" placeholder="QTD"
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
            <div class="panel-heading">
                <center><b>Correções de Código / Tabelas</b></center>
            </div>
            <div id="divFuncionalidades"></div>
            <br>
            <button type="button" onclick="addFuncionalidade()" type="button" class="btn btn-success">Nova
                Funcionalidade
            </button>
            <input type="hidden" name="idfunc" value="0" id="idfunc">
            <br><br>
        </div>
        <br>
        <div class="input-group">
            <button type="button" style="margin-top: 5px; float: outside" class="btn btn-danger"
                    onclick="window.location.href='/'">Voltar
            </button>
            <button style="margin-top: 5px; float: right" class="btn btn-primary">Salvar</button>
        </div>
        <div class="modal fade pac-container" id="modalCadastroTabela" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">
                            <center>Cadastro de Tabelas</center>
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Owner:</label>
                                <input type="text" class="form-control" id="tabowner" name="tabowner" id="tabowner" onkeyup="autoCompleteOwner();">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Tabela:</label>
                                <input type="text" class="form-control" id="tabnome" name="tabnome" id="tabnome" onkeyup="autoCompleteTabela();">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">fechar</button>
                        <button type="button" class="btn btn-primary" onclick="cadastrarTabela()" data-dismiss="modal">Cadastrar</button>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="http://demo.expertphp.in/js/jquery.js"></script>
<script src="http://demo.expertphp.in/js/jquery-ui.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
</body>
</html>

<script>
    (function ($) {
        autoCompleteFuncionalidade = function(funcionalidade) {
            src = "{{ route('autoCompleteFuncionalidade') }}";
            $.ajax({
                url: src,
                dataType: "json",
                type: "get",
                data: {
                    funnome:  $("#funnome_"+funcionalidade).val(), sisid: sisid.val()
                },
                success: function (data) {
                    $("#funnome_"+funcionalidade).autocomplete({
                        source: data
                    });
                }
            });
        };

        autoCompleteOwner = function() {
            if($('#tabowner').val().length > 3){
                src = "{{ route('autoCompleteOwner') }}";
                $.ajax({
                    url: src,
                    dataType: "json",
                    type: "get",
                    data: {
                        tabowner:  $('#tabowner').val()
                    },
                    success: function (data) {
                        $("#tabowner").autocomplete({
                            source: data
                        });
                    }
                });
            }
        };

        autoCompleteTabela = function() {
            if($('#tabnome').val().length > 3){
                src = "{{ route('autoCompleteTabela') }}";
                $.ajax({
                    url: src,
                    dataType: "json",
                    type: "get",
                    data: {
                        tabnome:  $('#tabnome').val()
                    },
                    success: function (data) {
                        $("#tabnome").autocomplete({
                            source: data
                        });
                    }
                });
            }
        };

        addFuncionalidade = function () {
            if ($('#sisid').val() == 0) {
                $('#sisid').focus();
                alert('Selecione um sistema');
            } else {
                var idfunc = $('#idfunc').val();

                var func = "";
                func += '<div class="panel panel-success" id="funcionaldades_' + idfunc + '">';
                func += '<div class="panel-heading">';
                func += '<button type="button"  style="margin-top: 5px; float: outside" class="btn btn-danger btn-sm"';
                func += 'onclick="removeFuncionalidade(' + idfunc + ')" >X';
                func += '</button> &nbsp;<span class="badge badge-pill badge-primary">Funcionalidade ' + idfunc + '</span>';
                func += '</div>';
                func += '<div class="input-group">';
                func += '<span class="input-group-addon">Funcionalidade</span>';
                func += '<input type="text" class="form-control" name="funcionalidade[' + idfunc + '][funnome]"';
                func += 'placeholder="Nome da Funcionalidade" id="funnome_'+idfunc+'" size="60" ';
                func += 'onkeyup="autoCompleteFuncionalidade('+idfunc+');" onblur="verificaFuncionalidade(this)">';
                func += '<span class="input-group-addon">Tipo de Mudança</span>';
                func += '<select class="form-control" name="funcionalidade[' + idfunc + '][deftipomudanca]">';
                func += '<option value="Alterada">Alterada</option>';
                func += '<option value="Incluída">Incluída</option>';
                func += '<option value="Excluída">Excluída</option>';
                func += '</select>';
                func += '</div>';
                func += '<br>';
                func += '<div class="input-group">';
                func += '<span class="input-group-addon">Descrição da Manutenção</span>';
                func += '<textarea class="form-control" placeholder="Descrição detalhada da manutenção" aria-label="With textarea" name="funcionalidade[' + idfunc + '][defdescricao]"></textarea>';
                func += '</div>';
                func += '<br>';
                func += '<div class="input-group">';
                func += '<span class="input-group-addon">Alteração em Arquivos ou Tabelas?</span>';
                func += '<textarea class="form-control" placeholder="Informação dos arquivos e tabelas alterados" aria-label="With textarea" name="funcionalidade[' + idfunc + '][defalteracaoarquivos]"></textarea>';
                func += '</div>';
                func += '<br>';
                func += '<div class="input-group">';
                func += '<span class="input-group-addon">Carga de Dados</span>';
                func += '<textarea class="form-control" placeholder="Informação detalhada da carga de dados." aria-label="With textarea" name="funcionalidade[' + idfunc + '][defcargadados]"></textarea>';
                func += '</div>';
                func += '<br>';
                func += '<div class="input-group">';
                func += '<span class="input-group-addon">Evidência 1</span>';
                func += '<input type="file" class="form-control"   name="funcionalidade[' + idfunc + '][evidencia1]">';
                func += '<span class="input-group-addon">Evidência 2</span>';
                func += '<input type="file" class="form-control"  name="funcionalidade[' + idfunc + '][evidencia2]">';
                func += '<span class="input-group-addon">Evidência 3</span>';
                func += '<input type="file" class="form-control"  name="funcionalidade[' + idfunc + '][evidencia3]">';
                func += '</div>';
                func += '<br>';
                func += '<button onclick="addTableRow(' + idfunc + ')" type="button" class="btn btn-primary">Adicionar Tabelas a funcionalidade</button>&nbsp;&nbsp;';
                func += '<input type="hidden" value="0" id="qtdtabelas_' + idfunc + '">';
                func += '<button type="button" data-toggle="modal" data-target="#modalCadastroTabela" class="btn btn-warning">Cadastrar Nova Tabela</button>';
                func += '<br>';
                func += '<br>';
                func += '<table id="tabela_funcionalidades_' + idfunc + '" class="table table-striped">';
                func += '<tbody>';
                func += '<tr>';
                func += '<th width="10%"></th>';
                func += '<th width="20%">Owner</th>';
                func += '<th width="50%">Tabela</th>';
                func += '<th width="10%">Já era Utilizada</th>';
                func += '<th width="10%">Tipo de Acesso</th>';
                func += '</tr>';
                func += '</tbody>';
                func += '</table>';
                func += '</div>';
                $("#divFuncionalidades").append(func);

                idfunc++;
                $('#idfunc').val(idfunc);
            }
        };

        addTableRow = function (idfunc) {
            var nrTabela = $('#qtdtabelas_' + idfunc).val();
            var newRow = $("<tr>");
            var cols = "";
            cols += '<td><center>';
            cols += '<button type="button" onclick="removeRow(this)" style="margin-top: 5px; float: outside" class="btn btn-danger btn-sm">X</button>';
            cols += '</center></td>';
            cols += '<td><select class="form-control" id="tabowner_' + idfunc + '_' + nrTabela + '" name="funcionalidade[' + idfunc + '][tabela][' + nrTabela + '][tabwoner]" ';
            cols += 'onchange="buscaTabelas(' + idfunc + ',' + nrTabela + ')">';
            cols += '<option value="0">Selecione o Owner.. </option>';
            cols += '</select></td>';
            cols += '<td><select class="form-control" id="tabnome_' + idfunc + '_' + nrTabela + '" name="funcionalidade[' + idfunc + '][tabela][' + nrTabela + '][tabid]" ';
            cols += '<option value="0">Selecione a tabela.. </option>';
            cols += '</select></td>';
            cols += '<td><input type="radio" name="funcionalidade[' + idfunc + '][tabela][' + nrTabela + '][tafutilizada]" value="S" >Sim &nbsp;&nbsp; ' +
                '<input type="radio" name="funcionalidade[' + idfunc + '][tabela][' + nrTabela + '][tafutilizada]" value="N" checked>Não</td>';
            cols += '<td><select class="form-control" name="funcionalidade[' + idfunc + '][tabela][' + nrTabela + '][taftipoacesso]">\n' +
                '        <option value="Escrita">Escrita</option>\n' +
                '        <option value="Leitura">Leitura</option>\n' +
                '        <option value="Escrita e Leitura">Escrita e Leitura</option>\n' +
                '    </select></td>';
            newRow.append(cols);
            $("#tabela_funcionalidades_" + idfunc).append(newRow);
            buscaOwners(idfunc,nrTabela);
            nrTabela++;
            $('#qtdtabelas_' + idfunc).val(nrTabela);
            return false;
        };

        removeFuncionalidade = function (idfunc) {
            $("div").remove("#funcionaldades_" + idfunc);
            return false;
        }

        removeRow = function (item) {
            var tr = $(item).closest('tr');
            tr.fadeOut(400, function () {
                tr.remove();
            });
            return false;
        }

        liberaCampos = function (liberar, id) {
            if (liberar == 's') {
                $('#descricao_' + id).prop('disabled', false);
                $('#quantidade_' + id).prop('disabled', false);
            } else {
                $('#descricao_' + id).val('');
                $('#descricao_' + id).prop('disabled', true);
                $('#quantidade_' + id).val('');
                $('#quantidade_' + id).prop('disabled', true);
            }
        }

        cadastrarTabela = function () {
            src = "{{ route('addTabela') }}";
            $.ajax({
                url: src,
                dataType: "json",
                type: "get",
                data: {
                    tabowner: $('#tabowner').val(), tabnome: $('#tabnome').val()
                },
                success: function (data) {
                    if (data) {
                        $('#modalCadastroTabela').modal('hide')
                    } else {
                        alert('Tabela já existente.')
                    }
                }
            });
        }

        buscaOwners = function (funcionalidade, tabela) {
            $('#tabowner_' + funcionalidade + '_' + tabela + '').html('<option value="">Buscando...</option>');
            src = "{{ route('atualizaOwner') }}";
            $.ajax({
                url: src,
                dataType: "json",
                type: "get",
                success: function (dados) {
                    if (dados.length > 0) {
                        var option = '<option>Selecione o Owner.. </option>';
                        $.each(dados, function (i, obj) {
                            option += '<option value="' + obj.tabowner + '">' + obj.tabowner + '</option>';
                        })
                    } else {
                        Reset();
                    }
                    $('#tabowner_' + funcionalidade + '_' + tabela + '').html(option).show();
                    $('#tabnome_' + funcionalidade + '_' + tabela + '').html('')
                }
            });
        }

        buscaTabelas = function (funcionalidade, tabela) {
            $('#tabnome_' + funcionalidade + '_' + tabela + '').html('<option value="">Buscando...</option>');
            var val = $('#tabowner_' + funcionalidade + '_' + tabela + ' :selected').val();
            if(val == 0) {
                alert('Selecione um Owner');
            }else{
                var owner = $('#tabowner_' + funcionalidade + '_' + tabela + ' :selected').text();
                src = "{{ route('atualizaTabelas') }}";
                $.ajax({
                    url: src,
                    dataType: "json",
                    type: "get",
                    data: {
                        tabowner: owner
                    },
                    success: function (dados) {
                        if (dados.length > 0) {
                            var option = '<option>Selecione a Tabela.. </option>';
                            $.each(dados, function (i, obj) {
                                option += '<option value="' + obj.tabid + '">' + obj.tabnome + '</option>';
                            })
                        } else {
                            Reset();
                        }
                        $('#tabnome_' + funcionalidade + '_' + tabela + '').html(option).show();
                    }
                });
            }
        }

        verificaDemanda = function () {
            src = "{{ route('verificaDemanda') }}";
            $.ajax({
                url: src,
                dataType: "json",
                type: "get",
                data: {
                    demnumero: $('#demnumero').val()
                },
                success: function (data) {
                    if (data) {
                        var r = confirm("Demanda já existe, deseja carregar os dados?");
                        if (r == true) {

                            //busca a demanda e redireciona para a tela dela.
                            

                        } else {
                            $('#demnumero').val('');
                            $('#demnumero').focus();
                        }
                    }
                }
            });
        }

        verificaFuncionalidade = function (funnome) {
            src = "{{ route('verificaFuncionalidade') }}";
            $.ajax({
                url: src,
                dataType: "json",
                type: "get",
                data: {
                    funnome: funnome.value
                },
                success: function (data) {
                    if (data) {
                        var r = confirm("Funcionalidade já existe, deseja carregar os dados do ultimo documento?");
                        if (r == true) {


                            // carregar tabelas

                        } else {
                            $('#demnumero').val('');
                            $('#demnumero').focus();
                        }
                    }
                }
            });
        }
    })(jQuery);

</script>