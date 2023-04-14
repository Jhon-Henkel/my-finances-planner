@php
    use App\Enums\RouteEnum;
    use App\Enums\ViewEnum;
@endphp
@extends(ViewEnum::VIEW_BASE)
@section('content')
    <div class="card text-center login-box glass">
        <div>
            <h3>Login</h3>
            <hr>
        </div>
        <div class="card-body">
            <form class="form-horizontal" method="post" action="{{ route(RouteEnum::WEB_MAKE_LOGIN) }}">
                {{ csrf_field() }}
                {{-- todo imputs estão quadrados, arrumar --}}
                {{-- todo usar icones do fontawesome --}}
                <div class="form-group">
                    <div class="input-group mb-3">
                        <span class="input-group-text input-addon" id="basic-addon1">
                            <span class="material-symbols-outlined">person</span>
                        </span>
                        <input type="text" class="form-control" placeholder="user@mail.com" name="login">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group mb-3">
                        <span class="input-group-text input-addon" id="basic-addon1">
                            <span class="material-symbols-outlined">password</span>
                        </span>
                        <input type="password" class="form-control" placeholder="********" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-primary btn-full">
                        <span class="material-symbols-outlined me-2">lock_open</span>
                        <span class="text-button-login">Entrar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection