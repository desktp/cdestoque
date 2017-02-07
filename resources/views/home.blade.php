<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>C&D Estoque</title>

        <!-- Fonts -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

        <!-- Styles -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="css/home.css">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Coffee & Drinks
                </div>

                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                      <div class="panel-heading" data-toggle="collapse" data-target="#collapse1" data-parent="#accordion">
                        Cadastros
                      </div>
                      <div id="collapse1" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul>
                                <li><a class="btn btn-default" href="/maquinas">Máquinas</a></li>
                                <li><a class="btn btn-default" href="/fabricantes">Fabricantes</a></li>
                                <li><a class="btn btn-default" href="/unidades">Unidades</a></li>
                                <li><a class="btn btn-default" href="/marcas">Marcas</a></li>
                                <li><a class="btn btn-default" href="/produtos">Produtos</a></li>
                                <li><a class="btn btn-default" href="/filials">Filiais</a></li>
                                <li><a class="btn btn-default" href="/maquinas/unidades">Associar unidade/máquina</a></li>
                            </ul>
                        </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading" data-toggle="collapse" data-target="#collapse2" data-parent="#accordion">
                        Estoque
                      </div>
                      <div id="collapse2" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul>
                                <li><a class="btn btn-default" href="/estoque">Entrada Estoque</a></li>
                            </ul>
                        </div>
                      </div>
                    </div>
                </div> 
            </div>
        </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
