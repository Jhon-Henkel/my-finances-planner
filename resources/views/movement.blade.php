@php
    use App\Enums\MovementEnum;
    use App\Enums\RouteEnum;
    use App\Tools\StringTools;
    use App\Tools\CalendarTools;
@endphp
@extends('snippets.base')
@section('content')
    <h3 class="mt-2">Movimentações</h3>
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
    <hr>
    <table class="table table-dark table-striped table-sm table-hover table-bordered" id="dataTable">
        <thead class="table-dark">
        <tr>
            <th class="text-center">Tipo</th>
            <th class="text-center">Descrição</th>
            <th class="text-center">Carteira</th>
            <th class="text-center">Data</th>
            <th class="text-center">Valor</th>
            <th class="text-center">Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach($movements as $movement)
            <tr>
                <td class="text-center">{{ MovementEnum::getDescription($movement->getType()) }}</td>
                <td class="text-center">{{ ucfirst($movement->getDescription()) }}</td>
                <td class="text-center">{{ ucfirst($movement->getWalletName() ?? 'Não informado') }}</td>
                <td class="text-center">{{ CalendarTools::usToBrDate($movement->getCreatedAt()) }}</td>
                <td class="text-center">{{ StringTools::moneyBr($movement->getAmount()) }}</td>
                <td class="text-center">
                    <form method="post" action="#">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $movement->getId() }}">
                        <button class="btn btn-sm btn-danger rounded-5" type="submit">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <hr>
    <script type="text/javascript" src="resources/js/dataTable.js"></script>
@endsection