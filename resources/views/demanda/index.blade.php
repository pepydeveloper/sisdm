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
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading links"><a href="cadastrar"><span class="glyphicon glyphicon-paste" aria-hidden="true"> Nova Demanda</a></div>
        <!-- Table -->
        <table class="table">
            <tr>
                <th>Ação</th>
                <th>Demanda</th>
                <th>Descrição</th>
                <th>Sistema</th>
                <th>Tipo</th>
            </tr>

        @foreach($demandas as $demanda)
            <tr>
                <td>
                    <span class="glyphicon glyphicon-download-alt"></span>
                    <span class="glyphicon glyphicon-remove-sign"></span>
                    <span class="glyphicon glyphicon-eye-open"></span>
                </td>
                <td>{{$demanda->demnumero}}</td>
                <td>{{$demanda->demdescricao}}</td>
                <td>{{$demanda->sisid}}</td>
                <td>{{$demanda->demtipo}}</td>
            </tr>
        @endforeach
        </table>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
</body>
</html>
