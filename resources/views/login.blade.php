@extends('shared.base')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading"><h3>Entrar no sistema</h3></div>
        <div class="panel-body">
            <form class="form-horizontal" method="post" action="{{route('logar')}}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="login" class="col-sm-2 control-label">Login</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="login"
                               placeholder="Digite seu login">
                    </div>
                </div>
                <div class="form-group">
                    <label for="senha" class="col-sm-2 control-label">Senha</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="senha"
                               placeholder="Digite seu senha">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="reset" class="btn btn-default">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection