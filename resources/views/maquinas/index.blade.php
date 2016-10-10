@extends('layouts.app')

@section('content')

    <div class="panel-body">
        @include('common.errors')

        <form action="/maquina" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="maquina-modelo" class="col-sm-3 control-label">Máquina</label>

                <div class="col-sm-6">
                    <input type="text" name="modelo" id="maquina-modelo" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="maquina-fabricante" class="col-sm-3 control-label">Fabricante</label>

                @if (count($fabricantes) > 0)
                    <div class="col-sm-6">
                        <select name="fabricante_id" id="maquina-fabricante" class="form-control">
                            @foreach ($fabricantes as $fabricante)
                                <option value='{{ $fabricante->id }}'>{{ $fabricante->fabricante }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="col-sm-6">
                        <a class="btn" href="/fabricantes">Nenhum fabricante cadastrado. Clique aqui para cadastrar.</a>
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="maquina-tipo" class="col-sm-3 control-label">Tipo Máquina</label>

                <div class="col-sm-6" id="maquina-tipo">
                    @foreach ($tipoMaquinas as $tipoMaquina)
                        <label class="radio-inline"><input type="radio" name="tipoMaquina_id" value="{{ $tipoMaquina->id }}">{{ $tipoMaquina->tipoMaquina }}</label>
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

    @if (count($maquinas) > 0)
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
                        @foreach ($maquinas as $maquina)
                            <tr>
                                <td class="table-text">
                                    <div>{{ $maquina->modelo }}</div>
                                </td>

                                <td class="table-text">
                                    <div>{{ $maquina->fabricante->fabricante }}</div>
                                </td>

                                <td class="table-text">
                                    <div>{{ $maquina->tipoMaquina->tipoMaquina }}</div>
                                </td>

                                <td>
                                    <form action="/fabricante/{{ $fabricante->id }}" method="POST">
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