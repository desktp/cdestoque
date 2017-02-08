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

            <!-- Maquinas (por apelido) -->
            <div class="form-group">
                <label for="selectMaquina" class="col-sm-3 control-label">Maquina</label>
                    <div class="col-sm-6">
                        <select name="maquina_id" id="selectMaquina" class="form-control">
                            <!-- Carregar via AJAX -->
                        </select>
                        <i class="fa fa-spinner fa-spin" aria-hidden="true" style="display: none;"></i>
                    </div>
            </div>

            <div id="estoque-container">
                <div class="produto">
                    <span class="mola">1</span><br>
                    <span class="nome-produto">Toddynho</span><br>
                    <span class="pco">2,50</span><br>
                </div>
                <div class="produto produto-new">
                    <span class="add-produto">
                        <i class="fa fa-plus-circle fa-3x" aria-hidden="true"></i><br>
                        Adicionar produto...
                    </span>
                </div>
                <!-- <div class="produto produto-new">
                    <div class="form-group col-md-4">                       
                        <label for="marca_id" class="control-label">Marca</label>
                        <select name="marca_id" class="form-control input-sm">   
                        </select>

                        <label for="produto_id" class="control-label">Produto</label>
                        <select name="produto_id" class="form-control"> 
                        </select>

                        <label for="selectMola" class="control-label">Mola</label>
                        <select id="selectMola" class="form-control">
                            
                        </select>

                        <label for="qtd" class="controle-label">Quantidade</label>
                        <input type="number" id="qtd" min="1" class="form-control">

                        <label for="pcoSaida" class="controle-label">Preço Saída</label>
                        <input type="number" step="0.01" min="0.01" name="pcoSaida" id="pcoSaida" class="form-control">
                    </div>
                </div> -->
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">                                    
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
                            $("#selectMaquina").append("<option value=\"" + data[i].id + "\" >" + data[i].apelido + "</option>")
                        });
                        
                        $('.fa-spinner').hide();  

                    });
            }).change();

            // Popula tabela produtos
            $('#selectMaquina').change(function(){
                // Se tipo maquina Snack, mola combobox=disabled
            }).change();

            // Adiciona novo produto
            $('.add-produto').click(function(){
                
                // Pegar marcas e produtos via JSON
                $(".produto-new").html("<div class=\"form-group col-md-4\"><label for=\"selectMarca\" class=\"control-label\">Marca</label><select id=\"selectMarca\" class=\"form-control input-sm\"></select><label for=\"selectProduto\" class=\"control-label\">Produto</label><select id=\"selectProduto\" class=\"form-control\"></select><label for=\"selectMola\" class=\"control-label\">Mola</label><select id=\"selectMola\" class=\"form-control\"></select><label for=\"qtd\" class=\"controle-label\">Quantidade</label><input type=\"number\" id=\"qtd\" min=\"1\" class=\"form-control\"><label for=\"pcoSaida\" class=\"controle-label\">Preço Saída</label><input type=\"number\" step=\"0.01\" min=\"0.01\" name=\"pcoSaida\" id=\"pcoSaida\" class=\"form-control\"><br><button id=\"saveProduto\" type=\"button\" class=\"btn btn-success\">Salvar</button></div>");

                for (var i = 1; i <= 50; i++) {
                    $("#selectMola").append("<option value=" + i + ">" + i + "</option>");
                }

                $.getJSON("/marcas/all", {})
                    .done(function(data){
                        $.each(data, function(i, item){
                            $("#selectMarca").append("<option value="+item.id+">"+item.marca+"</option>");
                        })
                    $("#selectMarca").change();
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
                    var estoqueMaquina = {
                        maquina_id: $("#selectMaquina").val(),
                        produto_id: $("#selectProduto").val(),
                        mola: $("#selectMola option:selected").text(),
                        qtd: $("#qtd").val(),
                        pcoSaida: $("#pcoSaida").val()
                    }

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.post("/estoque/maquina", estoqueMaquina)
                        .done(function(data){
                            alert("Abastecimento salvo");
                        })
                        .fail(function(data){
                            alert(data.responseText);
                        });

                    //$("#estoque-container").append("<div class=\"produto\"><span class=\"mola\">"+estoqueMaquina.mola+"</span><br><span class=\"nome-produto\">"+estoqueMaquina.produto_id+"</span><br><span class=\"pco\">"+estoqueMaquina.pcoSaida+"</span><br></div>");
                    //$(".produto-new").html("<span class=\"add-produto\"><i class=\"fa fa-plus-circle fa-3x\" aria-hidden=\"true\"></i><br>Adicionar produto...</span>");
                });
            }); // Fim addProduto
        }); // Fim onpageload
    </script>
@endsection