@php
    use App\Enums\RouteEnum;
    use App\Tools\CalendarTools;
@endphp
<div class="offcanvas offcanvas-start glass" data-bs-scroll="true" tabindex="-1" id="sidebar"
     aria-labelledby="sidebar">
    <div class="offcanvas-header">
        <h4 class="offcanvas-title" id="sidebar">
            My finances planner
        </h4>
    </div>
    <div class="offcanvas-body">
        <h6 class="text-center mt-3">
            {{ CalendarTools::salutation(Auth::user()->name, date('H')) }}
        </h6>
        <nav class="nav flex-column ms-4 mt-5">
            <a class="nav-link sidebar-item a-default" aria-current="page" href="{{ route(RouteEnum::WEB_DASHBOARD) }}">
                <i class="fa-solid fa-chart-line me-2"></i>
                Dashboard
            </a>
            <a class="nav-link sidebar-item a-default" aria-current="page" href="{{ route(RouteEnum::WEB_MOVEMENT) }}">
                <i class="fa-solid fa-money-bill-transfer me-2"></i>
                Movimentações
            </a>
            <a class="nav-link sidebar-item a-default" aria-current="page" href="#">
                <i class="fa-solid fa-money-bill-trend-up me-2"></i>
                Panorama
            </a>
            <a class="nav-link sidebar-item a-default" aria-current="page" href="#">
                <i class="fa-solid fa-money-bill-wave me-2"></i>
                Meus Ganhos
            </a>
            <a class="nav-link sidebar-item a-default" aria-current="page" href="{{ route(RouteEnum::WEB_WALLET) }}">
                <i class="fa-solid fa-wallet me-2"></i>
                Carteiras
            </a>
            <a class="nav-link sidebar-item a-default" aria-current="page" href="#">
                <i class="fa-solid fa-credit-card me-2"></i>
                Cartões
            </a>
        </nav>
    </div>
</div>