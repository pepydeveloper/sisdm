<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SISDM</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
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

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
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
</head>
<body>
<div class="flex-center position-ref">
    <div class="content">
        <div class="title m-b-md">
            SISDM
        </div>

    </div>
</div>
<div class="links">

</div>
<div>
    <form method="GET" enctype="multipart/form-data">
        <input type="hidden" id="pesquisar" name="pesquisar" value="pesquisar"/>
        {{ csrf_field() }}
        <div class="panel panel-success">
            <div class="panel-heading links"><a href="cadastrar">
                    <span class="btn btn-success glyphicon glyphicon-paste"
                          aria-hidden="true"> Nova Demanda</span></a>
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    @if(count($demandas))
                        <th>
                            <button type="submit" class="btn btn-danger" name="todos">Limpar</button>
                            <button type="submit" class="btn btn-info">Filtrar</button>
                        </th>
                        <th>
                            <input type="text" name="demnumero" class="form-control" placeholder="Nº Demanda"
                                   aria-describedby="basic-addon1">
                        </th>
                        <th>Descrição</th>
                        <th>Sistema</th>
                        <th>Tipo</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($demandas as $demanda)
                    <tr>
                        <td>
                            <a class="btn btn-success glyphicon glyphicon-download-alt"
                               href="javascript:exportarXls({{$demanda->demnumero}});" target="_blank" title="Download"></a>
                            <a class="btn btn-warning glyphicon glyphicon-pencil"
                               href="editar/{{$demanda->demid}}" title="Editar"></a>
                            <a class="btn btn-primary glyphicon glyphicon-link"
                               href="http://sape-sistemas.ebserh.gov.br/sistemas/issues/{{$demanda->demnumero}}" title="Abrir Sape" target="_blank"></a>
                            {{--<a class="btn btn-danger glyphicon glyphicon-remove-sign" href="excluir/{{$demanda->demid}}"></a>--}}
                        </td>
                        <td>{{$demanda->demnumero}}</td>
                        <td>{{$demanda->demdescricao}}</td>
                        <td>{{$demanda->sistema->sisnome}}</td>
                        <td>{{$demanda->demtipo}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot class="table-active">
                <tr>
                    <td colspan="5"> Quantidade: {{count($demandas)}}</td>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="panel-heading links" align="right">{{$demandas->links()}}</div>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
</body>
</html>
<script>
    (function ($) {
        exportarXls = function (demid) {
            window.open('/exportar?demid=' + demid, '_blank');
        };
    })(jQuery);
</script>