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
        @php($totalByType = [])
        @foreach($movements as $movement)
            <tr>
                <td class="text-center">
                    <span class= "badge
                    @if($movement->getType() == MovementEnum::SPENT)
                        text-bg-danger
                    @else
                        text-bg-sucess
                    @endif">
                        {{ MovementEnum::getDescription($movement->getType()) }}
                    </span>
                </td>
                <td class="text-center">{{ ucfirst($movement->getDescription()) }}</td>
                <td class="text-center">{{ ucfirst($movement->getWalletName() ?? 'Não informado') }}</td>
                <td class="text-center">{{ CalendarTools::usToBrDate($movement->getCreatedAt()) }}</td>
                <td class="text-center">{{ StringTools::moneyBr($movement->getAmount()) }}</td>
                <td class="text-center">
                    {{-- todo adicionar ação de editar --}}
                    <form method="post" action="#">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $movement->getId() }}">
                        <button class="btn btn-sm btn-danger rounded-5" type="submit">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @php($totalByType[$movement->getType()] = ($totalByType[$movement->getType()] ?? 0) + $movement->getAmount());
        @endforeach
        </tbody>
    </table>
    <hr>
    @php($gain = $totalByType[MovementEnum::GAIN] ?? 0)
    @php($spent = $totalByType[MovementEnum::SPENT] ?? 0)
    <div class="text-center">
        <div class="badge text-bg-danger">
            {{ StringTools::moneyBr($spent) }}
        </div>
        -
        <div class="badge text-bg-success">
            {{ StringTools::moneyBr($gain) }}
        </div>
        =
        <div class="badge text-bg-warning">
            {{ StringTools::moneyBr($gain - $spent) }}
        </div>
    </div>
    <hr>
    <script type="text/javascript" src="resources/js/dataTable.js"></script>
@endsection