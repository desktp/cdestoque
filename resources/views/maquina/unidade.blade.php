@extends('layouts.app')

@section('content')

    <div class="panel-body">
        @include('common.errors')

        <form action="/maquinas/unidade" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Unidades -->
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
                        <a class="btn" href="/filials">Nenhuma unidade cadastrada. Clique aqui para cadastrar.</a>
                    </div>
                @endif
            </div>

            <!-- Fabricantes -->
            <div class="form-group">
                <label for="selectFabricante" class="col-sm-3 control-label">Fabricante</label>

                @if (count($fabricantes) > 0)
                    <div class="col-sm-6">
                        <select name="fabricante_id" id="selectFabricante" class="form-control">
                            @foreach ($fabricantes as $fabricante)
                                <option value='{{ $fabricante->id }}'>{{ $fabricante->fabricante }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="col-sm-6">
                        <a class="btn" href="/fabricantes">Nenhuma fabricante cadastrada. Clique aqui para cadastrar.</a>
                    </div>
                @endif
            </div>

            <!-- Modelos -->
            <div class="form-group">
                <label for="selectModelo" class="col-sm-3 control-label">Modelo</label>
                    <div class="col-sm-6">
                        <select name="maquina_modelo_id" id="selectModelo" class="form-control">
                            <!-- Carregar via AJAX -->
                        </select>
                        <i class="fa fa-spinner fa-spin" aria-hidden="true" style="display: none;"></i>
                    </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus fa-fw"></i> Associar
                </div>
            </div>
        </form>
    </div>
    <script>
        $(function(){
            $('#selectFabricante').change(function(){
            $.getJSON("/maquinas/fabricante/"+$("#selectFabricante").val(), {})
                .always(function(data){
                    $('.fa-spinner').show();
                })
                .done(function(data){
                    $('#selectModelo').children().remove();
                    $.each(data, function(i, item){
                        $("#selectModelo").append("<option value=\"" + item.id + "\" >" + item.nome + "</option>")
                    });
                    $('.fa-spinner').hide();  
                });
            }).change();
        });
    </script>
@endsection