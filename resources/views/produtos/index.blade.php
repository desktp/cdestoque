@extends('layouts.app')

@section('content')

    <div class="panel-body">
        @include('common.errors')

        <form action="/produto" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="produto-nome" class="col-sm-3 control-label">Produto</label>

                <div class="col-sm-6">
                    <input type="text" name="nome" id="produto-nome" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="produto-marca" class="col-sm-3 control-label">Marca</label>

                @if (count($marcas) > 0)
                    <div class="col-sm-6">
                        <select name="marca_id" id="produto-marca" class="form-control">
                            @foreach ($marcas as $marca)
                                <option value='{{ $marca->id }}'>{{ $marca->marca }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="col-sm-6">
                        <a class="btn" href="/marcas">Nenhuma marca cadastrado. Clique aqui para cadastrar.</a>
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="produto-tipo" class="col-sm-3 control-label">Tipo Produto</label>

                <div class="col-sm-6" id="produto-tipo">
                    @foreach ($tipoProdutos as $tipoProduto)
                        <label class="radio-inline"><input type="radio" name="tipoProduto_id" value="{{ $tipoProduto->id }}">{{ $tipoProduto->tipoProduto }}</label>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus fa-fw"></i> Cadastrar Máquina
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if (count($produtos) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Modelos cadastrados
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <thead>
                        <th>Modelo</th>
                        <th>Fabricante</th>
                        <th>Tipo</th>
                        <th>&nbsp;</th>
                    </thead>

                    <tbody>
                        @foreach ($produtos as $produto)
                            <tr>
                                <td class="table-text">
                                    <div>{{ $produto->nome }}</div>
                                </td>

                                <td class="table-text">
                                    <div>{{ $produto->marca->marca }}</div>
                                </td>

                                <td class="table-text">
                                    <div>{{ $produto->tipoProduto->tipoProduto }}</div>
                                </td>

                                <td>
                                    <form action="/marca/{{ $marca->id }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button class="btn btn-danger">
                                            <i class="fa fa-trash fa-fw" aria-hidden="true"></i>Apagar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
@endsection