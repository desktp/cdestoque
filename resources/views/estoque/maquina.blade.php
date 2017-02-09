@extends('layouts.app')

@section('content')

    <div class="panel-body">
        @include('common.errors')

        <form action="/estoque/maquina" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Filiais -->
            <div class="form-group">
                <label for="selectFilial" class="col-sm-3 control-label">Estoque</label>
                @if (count($filiais) > 0)
                    <div class="col-sm-6">
                        <select name="filial_id" id="selectFilial" class="form-control">
                            @foreach ($filiais as $filial)
                                <option value='{{ $filial->id }}'>{{ $filial->filial }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>

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

            <div class="form-group">
                <!-- Maquinas (por apelido) -->
                <label for="selectMaquina" class="col-sm-3 control-label">Maquina</label>
                <div class="col-sm-6">
                    <select name="maquina_id" id="selectMaquina" class="form-control">
                        <!-- Carregar via AJAX -->
                    </select>
                </div>
            </div>

            <div id="estoque-container">
                <div class="produto produto-new">
                    <span class="add-produto">
                        <i class="fa fa-plus-circle fa-3x" aria-hidden="true"></i><br>
                        Adicionar produto...
                    </span>
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
                    
                    .done(function(data){
                        
                        $('#selectMaquina').children().remove();
                        
                        // Pega informacoes detalhadas de cada máquina
                        $.each(data, function(i, item){
                            $("#selectMaquina").append("<option value=\"" + data[i].id + "\" >" + data[i].apelido + "</option>").change();
                        });

                    });
            }).change();

            // Popula tabela produtos
            $('#selectMaquina').change(function(){
                $.getJSON("/estoque/maquina/" + $("#selectMaquina").val(), {})
                    
                    // WIP
                    // .always(function(data){
                    //     $("#estoque-container").html("<i class=\"fa fa-spinner fa-spin\" aria-hidden=\"true\"></i>");
                    // });

                    .done(function(data){
                        $(".produto-new").siblings().remove();
                        // $(".produto-new").html("<span class=\"add-produto\"><i class=\"fa fa-plus-circle fa-3x\" aria-hidden=\"true\"></i><br>Adicionar produto...</span>");
                        $.each(data, function(i, item){
                            $(".produto-new").before("<div class=\"produto\"><span class=\"mola\">" + data[i].mola + "</span><br><span class=\"nome-produto\">" + data[i].produto_nome + "</span><br><span class=\"pco\">R$ "+ data[i].pcoSaida + "</span><br></div>")
                        });
                });
            });

            // Adiciona novo produto
            $('.add-produto').click(function(){
                
                // Pegar marcas e produtos via JSON
                $(".produto-new").html("<div class=\"form-group col-md-6\"><label for=\"selectMarca\" class=\"control-label\">Marca</label><select id=\"selectMarca\" class=\"form-control input-sm\"></select><label for=\"selectProduto\" class=\"control-label\">Produto</label><select id=\"selectProduto\" class=\"form-control\"></select><label for=\"selectMola\" class=\"control-label\">Mola</label><select id=\"selectMola\" class=\"form-control\"></select><label for=\"qtd\" class=\"controle-label\">Quantidade</label><input type=\"number\" id=\"qtd\" min=\"1\" class=\"form-control\"><label for=\"pcoSaida\" class=\"controle-label\">Preço Saída</label><input type=\"number\" step=\"0.01\" min=\"0.01\" name=\"pcoSaida\" id=\"pcoSaida\" class=\"form-control\"><br><button id=\"saveProduto\" type=\"button\" class=\"btn btn-success\">Salvar</button></div>");

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
                    var filial = {
                        id: $("#selectFilial").val()
                    }

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.post("/estoque/maquina", {estoqueMaquina, filial})
                        .done(function(data){
                            alert("Abastecimento salvo");
                            $(".produto-new").html("<span class=\"add-produto\"><i class=\"fa fa-plus-circle fa-3x\" aria-hidden=\"true\"></i><br>Adicionar produto...</span>")
                            $("#selectMaquina").change();
                        })
                        .fail(function(data){
                            alert(data.responseText);
                        });
                });
            }); // Fim addProduto
        }); // Fim onpageload
    </script>
@endsection