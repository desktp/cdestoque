@extends('layouts.app')

@section('content')

    <div class="panel-body">
        @include('common.errors')

        <form action="/{{ $obj1 }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="{{ $obj1 }}-nome" class="col-sm-3 control-label">{{ ucfirst(str_replace('_', ' ', $obj1)) }}</label>

                <div class="col-sm-6">
                    <input type="text" name="nome" id="{{ $obj1 }}-nome" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="{{ $obj1 }}-{{ $obj2 }}" class="col-sm-3 control-label">{{ ucfirst($obj2) }}</label>

                @if (count($dados2) > 0)
                    <div class="col-sm-6">
                        <select name="{{ $obj2 }}_id" id="{{ $obj1 }}-{{ $obj2 }}" class="form-control">
                            @foreach ($dados2 as $dado)
                                <option value='{{ $dado->id }}'>{{ $dado->$obj2 }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="col-sm-6">
                        <a class="btn" href="/{{ $obj2 }}s">Nenhuma {{ $obj2 }} cadastrado. Clique aqui para cadastrar.</a>
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="{{ $obj1 }}-tipo" class="col-sm-3 control-label">Tipo {{ ucfirst(str_replace('_', ' ', $obj1)) }}</label>

                <div class="col-sm-6" id="{{ $obj1 }}-tipo">
                    @foreach ($dados3 as $dado)
                        <label class="radio-inline"><input type="radio" name="{{ $obj3 }}_id" value="{{ $dado->id }}">{{ $dado->$obj3 }}</label>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus fa-fw"></i> Cadastrar {{ str_replace('_', ' ', $obj1) }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if (count($dados1) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ ucfirst(str_replace('_', ' ', $obj1)) }}s cadastrados
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <thead>
                        <th>{{ ucfirst(str_replace('_', ' ', $obj1)) }}</th>
                        <th>{{ ucfirst($obj2) }}</th>
                        <th>Tipo</th>
                        <th>&nbsp;</th>
                    </thead>

                    <tbody>
                        @foreach ($dados1 as $dado)
                            <tr>
                                <td class="table-text">
                                    <div>{{ $dado->nome }}</div>
                                </td>

                                <td class="table-text">
                                    <div>{{ $dado->$obj2->$obj2 }}</div>
                                </td>

                                <td class="table-text">
                                    <div>{{ $dado->$obj3->$obj3 }}</div>
                                </td>

                                <td>
                                    <form action="/{{ $obj1 }}/{{ $dado->id }}" method="POST">
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