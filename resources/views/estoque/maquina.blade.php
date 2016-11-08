@extends('layouts.app')

@section('content')

    <div class="panel-body">
        @include('common.errors')

        <form action="/estoque/maquina" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Filiais -->
            <div class="form-group">
                <label for="selectUnidade" class="col-sm-3 control-label">Unidade</label>

                @if (count($unidades) > 0)
                    <div class="col-sm-6">
                        <select name="unidade_id" id="selectUnidade" class="form-control">
                            @foreach ($unidades as $unidade)
                                <option value='{{ $unidade->id }}'>{{ $unidade->unidade }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="col-sm-6">
                        <a class="btn" href="/unidades">Nenhuma unidade cadastrada. Clique aqui para cadastrar.</a>
                    </div>
                @endif
            </div>

            <!-- Maquinas -->
            <div class="form-group">
                <label for="selectMaquina" class="col-sm-3 control-label">Maquina</label>
                    <div class="col-sm-6">
                        <select name="maquina_id" id="selectMaquina" class="form-control">
                            <!-- Carregar via AJAX -->
                        </select>
                        <i class="fa fa-spinner fa-spin" aria-hidden="true" style="display: none;"></i>
                    </div>
            </div>

            <table class="table table-striped">
                    <thead>
                        <th>Marca</th>
                        <th>Produto</th>
                        <th>Mola</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                        <th>&nbsp;</th>
                    </thead>

                    <tbody>
                            <tr id="firstRow">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                    </tbody>
                </table>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button id="addProduto" class="btn" type="button">
                        <i class="fa fa-plus fa-fw" aria-hidden="true"></i>Adicionar Produto
                    </button>
                                    
                    <button id="saveAll" type="button" class="btn btn-success">
                        Salvar alterações
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script>
        $(function(){
            // Popula combobox máquinas
            $('#selectUnidade').change(function(){
                // Pega todas as máquinas da unidade
                $.getJSON("/maquinas/unidades/"+$("#selectUnidade").val(), {})
                    
                    .always(function(data){
                        $('.fa-spinner').show();
                    })
                    
                    .done(function(data){
                        
                        $('#selectMaquina').children().remove();
                        
                        // Pega informacoes detalhadas de cada máquina
                        $.each(data, function(i, item){
                            $.getJSON("/maquina_modelo/"+item.maquina_modelo_id, {})
                                
                                .done(function(data){
                                    $("#selectMaquina").append("<option value=\"" + data[0].id + "\" >" + data[0].nome + "</option>")        
                                });
                            
                        });
                        
                        $('.fa-spinner').hide();  

                    });
            }).change();

            // Popula tabela produtos
            $('#selectMaquina').change(function(){
                // Se tipo maquina Snack, mola combobox=disabled
            }).change();

            // Adiciona novo produto
            $('#addProduto').click(function(){
                
                // Pegar marcas e produtos via JSON
                $("#firstRow").after("<tr id=\"newProduto\"></tr>");
                $("#newProduto").append("<td><select id=\"selectMarca\" class=\"form-control\"></select></td><td><select id=\"selectProduto\" class=\"form-control\"></select></td><td><select id=\"selectMola\" class=\"form-control\"></select></td><td><input type=\"number\" id=\"qtd\" min=\"1\" class=\"form-control\"></td><td><input type=\"number\" step=\"0.01\" min=\"0.01\" name=\"pcoSaida\" id=\"pcoSaida\" class=\"form-control\"></td><td><button id=\"saveProduto\" class=\"btn btn-success\" type=\"button\"><i class=\"fa fa-plus fa-fw\" aria-hidden=\"true\"></i>Salvar Produto</button>");

                for (var i = 1; i <= 50; i++) {
                    $("#selectMola").append("<option value=" + i + ">" + i + "</option>");
                }

                $.getJSON("/marcas/all", {})
                    .done(function(data){
                        $.each(data, function(i, item){
                            $("#selectMarca").append("<option value="+item.id+">"+item.marca+"</option>");
                        })
                    })

                // Popula Produtos
                $("#selectMarca").change(function(){
                    $.getJSON("/produtos/marcas/" + $("#selectMarca").val(), {})
                    .always(function(data){
                        $("#selectProduto").children().remove();
                    })
                    .done(function(data){
                        $.each(data, function(i, item){
                            $("#selectProduto").append("<option value="+item.id+">"+item.nome+"</option>");
                        })
                    })                    
                }).change(); //fim Popula Produtos

                // Adiciona produto à tabela para ser salvo posteriormente
                $("#saveProduto").click(function(){
                    marca = {
                        id: $("#selectMarca").val(),
                        marca: $("#selectMarca option:selected").text()
                    };
                    produto = {
                        id: $("#selectProduto").val(),
                        nome: $("#selectProduto option:selected").text()
                    };                  
                    mola = $("#selectMola option:selected").text();
                    qtd  = $("#qtd").val();
                    pcoSaida = $("#pcoSaida").val();

                    $("#firstRow").after("<tr id=\"produto_"+produto.id+"\"><td>"+marca.marca+"</td><td>"+produto.nome+"</td><td>"+mola+"</td><td>"+qtd+"</td><td>"+pcoSaida+"</td></tr>");
                    $("#newProduto").remove();
                });
            }); // Fim addProduto

            $("#saveAll").click(function(){
                // WIP
            });
        }); // Fim onpageload
    </script>
@endsection