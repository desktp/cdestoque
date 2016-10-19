@extends('layouts.app')

@section('content')

    <div class="panel-body">
        @include('common.errors')

        <form action="/estoque" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Filiais -->
            <div class="form-group">
                <label for="selectFilial" class="col-sm-3 control-label">Filial</label>

                @if (count($filiais) > 0)
                    <div class="col-sm-6">
                        <select name="filial_id" id="selectFilial" class="form-control">
                            @foreach ($filiais as $filial)
                                <option value='{{ $filial->id }}'>{{ $filial->filial }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="col-sm-6">
                        <a class="btn" href="/filials">Nenhuma filial cadastrada. Clique aqui para cadastrar.</a>
                    </div>
                @endif
            </div>

            <!-- Marcas -->
            <div class="form-group">
                <label for="selectMarca" class="col-sm-3 control-label">Marca</label>

                @if (count($marcas) > 0)
                    <div class="col-sm-6">
                        <select name="marca_id" id="selectMarca" class="form-control">
                            @foreach ($marcas as $marca)
                                <option value='{{ $marca->id }}'>{{ $marca->marca }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="col-sm-6">
                        <a class="btn" href="/marcas">Nenhuma marca cadastrada. Clique aqui para cadastrar.</a>
                    </div>
                @endif
            </div>

            <!-- Produtos -->
            <div class="form-group">
                <label for="selectProduto" class="col-sm-3 control-label">Produto</label>
                    <div class="col-sm-6">
                        <select name="produto_id" id="selectProduto" class="form-control">
                            <!-- Carregar via AJAX -->
                        </select>
                        <i class="fa fa-spinner fa-spin" aria-hidden="true" style="display: none;"></i>
                    </div>
            </div>

            <!-- Quantidade -->
            <div class="form-group">
                <label for="qtd" class="col-sm-3 control-label">Quantidade</label>

                <div class="col-sm-6">
                    <input type="number" min="1" name="qtd" id="qtd" class="form-control">
                </div>
            </div>

            <!-- Pco Entrada -->
            <div class="form-group">
                <label for="pcoEntrada" class="col-sm-3 control-label">Preço de Entrada</label>

                <div class="col-sm-6">
                    <input type="number" step="0.01" name="pcoEntrada" id="pcoEntrada" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus fa-fw"></i> Cadastrar entrada
                </div>
            </div>
        </form>
    </div>
    <script>
        $(function(){
            $('#selectMarca').change(function(){
            $.getJSON("/produtos/marcas/"+$("#selectMarca").val(), {})
                .always(function(data){
                    $('.fa-spinner').show();
                })
                .done(function(data){
                    $('#selectProduto').children().remove();
                    $.each(data, function(i, item){
                        $("#selectProduto").append("<option value=\"" + item.id + "\" >" + item.nome + "</option>")
                    });
                    $('.fa-spinner').hide();  
                });
            }).change();
        });
    </script>
@endsection