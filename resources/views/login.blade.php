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
                <div class="form-group">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="user@mail.com" name="login">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa-solid fa-key"></i>
                        </span>
                        <input type="password" class="form-control" placeholder="********" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-primary btn-full">
                        <i class="fa-solid fa-unlock-keyhole me-2"></i>
                        Entrar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection