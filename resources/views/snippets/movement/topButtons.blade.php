@php
    use App\Enums\RouteEnum;
    use App\Enums\MovementEnum;
@endphp
<div class="nav justify-content-end">
    {{-- todo tansformar o filtro em selet --}}
    <a href="{{ route(RouteEnum::WEB_MOVEMENT, ['filter' => MovementEnum::FILTER_THIS_MONTH]) }}"
       class="btn btn-info rounded-5 me-2">
        <i class="fa-solid fa-filter"></i>
        {{ MovementEnum::getDescription(MovementEnum::FILTER_THIS_MONTH) }}
    </a>
    <a href="{{ route(RouteEnum::WEB_MOVEMENT, ['filter' => MovementEnum::FILTER_LAST_MONTH]) }}"
       class="btn btn-info rounded-5 me-2">
        <i class="fa-solid fa-filter"></i>
        {{ MovementEnum::getDescription(MovementEnum::FILTER_LAST_MONTH) }}
    </a>
    <a href="{{ route(RouteEnum::WEB_MOVEMENT, ['filter' => MovementEnum::FILTER_THIS_YEAR]) }}"
       class="btn btn-info rounded-5 me-2">
        <i class="fa-solid fa-filter"></i>
        {{ MovementEnum::getDescription(MovementEnum::FILTER_THIS_YEAR) }}
    </a>
    <a href="{{ route(RouteEnum::WEB_MOVEMENT, ['filter' => MovementEnum::FILTER_ALL]) }}"
       class="btn btn-info rounded-5 me-2">
        <i class="fa-solid fa-filter"></i>
        {{ MovementEnum::getDescription(MovementEnum::FILTER_ALL) }}
    </a>
    <button class="btn btn-success rounded-5" data-bs-toggle="modal" data-bs-target="#insertMovement">
        <i class="fa-solid fa-money-bill-transfer me-2"></i>
        Nova Movimentação
    </button>
</div>