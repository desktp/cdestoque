@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- New Task Form -->
        <form action="/fabricante" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Task Name -->
            <div class="form-group">
                <label for="fabricante" class="col-sm-3 control-label">Fabricante</label>

                <div class="col-sm-6">
                    <input type="text" name="fabricante" id="fabricante" class="form-control">
                </div>
            </div>

            <!-- Add Task Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus fa-fw"></i> Cadastrar Fabricante
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if (count($fabricantes) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Fabricantes
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Fabricante</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($fabricantes as $fabricante)
                            <tr>
                                <!-- Task Name -->
                                <td class="table-text">
                                    <div>{{ $fabricante->fabricante }}</div>
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