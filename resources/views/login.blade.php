@extends('shared.base')
@section('content')
    <div class="card text-center login-box">
        <div>
            <h3>Login</h3>
            <hr>
        </div>
        <div class="card-body">
            <form class="form-horizontal" method="post" action="{{route('logar')}}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="login" class="col-sm-2 control-label">E-mail</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="user@mail.com" name="login">
                    </div>
                </div>
                <div class="form-group">
                    <label for="senha" class="col-sm-2 control-label">Senha</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-solid fa-key"></i>
                        </span>
                        <input type="password" class="form-control" placeholder="********" name="senha">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-success btn-full mt-4">
                        <i class="fa-solid fa-unlock-keyhole me-2"></i>
                        Entrar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection