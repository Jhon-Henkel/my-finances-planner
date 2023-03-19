@php
    use App\Enums\RouteEnum;
    use App\Enums\MovementEnum;
@endphp
<div class="nav justify-content-end">
    {{-- todo tansformar o filtro em selet --}}
    <a href="{{ route(RouteEnum::WEB_MOVEMENT, ['filter' => MovementEnum::FILTER_THIS_MONTH]) }}"
       class="btn btn-info rounded-5 me-2"
       title="Filtrar por todos deste mês">
        <i class="fa-solid fa-filter"></i>
        {{ MovementEnum::getDescription(MovementEnum::FILTER_THIS_MONTH) }}
    </a>
    <a href="{{ route(RouteEnum::WEB_MOVEMENT, ['filter' => MovementEnum::FILTER_LAST_MONTH]) }}"
       class="btn btn-info rounded-5 me-2"
       title="Filtrar por todos do último mês">
        <i class="fa-solid fa-filter"></i>
        {{ MovementEnum::getDescription(MovementEnum::FILTER_LAST_MONTH) }}
    </a>
    <a href="{{ route(RouteEnum::WEB_MOVEMENT, ['filter' => MovementEnum::FILTER_THIS_YEAR]) }}"
       class="btn btn-info rounded-5 me-2"
       title="Filtrar por todos deste ano">
        <i class="fa-solid fa-filter"></i>
        {{ MovementEnum::getDescription(MovementEnum::FILTER_THIS_YEAR) }}
    </a>
    <a href="{{ route(RouteEnum::WEB_MOVEMENT, ['filter' => MovementEnum::FILTER_ALL]) }}"
       class="btn btn-info rounded-5 me-2"
       title="Filtrar por todos">
        <i class="fa-solid fa-filter"></i>
        {{ MovementEnum::getDescription(MovementEnum::FILTER_ALL) }}
    </a>
    <button class="btn btn-danger rounded-5 me-2"
            data-bs-toggle="modal"
            data-bs-target="#insertSpent"
            title="Nova despesa">
        <i class="fa-solid fa-minus"></i>
    </button>
    <button class="btn btn-success rounded-5 me-2"
            data-bs-toggle="modal"
            data-bs-target="#insertGain"
            title="Novo ganho">
        <i class="fa-solid fa-plus"></i>
    </button>
    <button class="btn btn-warning rounded-5"
            data-bs-toggle="modal"
            data-bs-target="#insertTransfer"
            title="Nova transferência">
        <i class="fa-solid fa-arrow-down-up-across-line"></i>
    </button>
</div>