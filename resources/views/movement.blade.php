@php
    use App\Enums\MovementEnum;
    use App\Tools\StringTools;
    use App\Tools\CalendarTools;
@endphp
@extends('snippets.base')
@section('content')
    <h3 class="mt-2">Movimentações</h3>
    @include('snippets.movement.topButtons')
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