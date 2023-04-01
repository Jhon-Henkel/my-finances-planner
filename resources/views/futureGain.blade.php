@php
    use App\Enums\DateEnum;
    use App\Enums\ViewEnum;
    use App\Services\WalletService;
    use App\Tools\CalendarTools;
    use App\Tools\StringTools;
@endphp
@extends(ViewEnum::VIEW_BASE)
@section('content')
    <h3 class="mt-2">Ganhos Futuros</h3>
    <hr>
    <table class="table table-dark table-striped table-sm table-hover table-bordered" id="dataTable">
        <thead class="table-dark">
        <tr class="text-center">
            <th class="text-center">Carteira</th>
            <th class="text-center">Nome</th>
            <th class="text-center">Dia</th>
            @php($rangeMonths = CalendarTools::getNextSixMonths(CalendarTools::getThisMonth()))
            @foreach($rangeMonths as $month)
                <th class="text-center">{{ DateEnum::getStrMonthByNumber($month) }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($itens as $item)
            <tr>
                <td class="text-center">
                    <button class="btn btn-sm btn-full btn-info" title="Editar">
                        {{ app(WalletService::class)->findNameById($item['wallet']) }}
                    </button>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-full btn-info" title="Editar">
                        {{ ucwords($item['name']) }}
                    </button>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-full btn-info" title="Editar">
                        {{ $item['day'] }}
                    </button>
                </td>
                @for($index = 0; $index <=5; $index++)
                    <td class="text-center">
                        @php($itemEdit = ['id' => null, 'month' => $rangeMonths[$index], 'value' => null, 'name' => $item['name']])
                        @php($itemAmount = '-')
                        @isset($item['data'][$rangeMonths[$index]])
                            @php($itemEdit = ['id' => $itemId = $item['data'][$rangeMonths[$index]]['id'], 'month' => $rangeMonths[$index], 'value' => $item['data'][$rangeMonths[$index]]['amount'], 'name' => $item['name']])
                            @php($itemAmount = StringTools::moneyBr($item['data'][$rangeMonths[$index]]['amount']))
                        @endisset
                        <button class="btn btn-sm btn-full btn-success" title="Editar" onclick="edit('{{ json_encode($itemEdit) }}')">
                            {{ $itemAmount }}
                        </button>
                    </td>
                @endfor
            </tr>
        @endforeach
        </tbody>
    </table>
    <hr>
    <script type="text/javascript" src="resources/js/dataTable.js"></script>
    <script type="text/javascript" src="resources/js/futureGainView.js"></script>
    <script type="text/javascript" src="resources/js/tools/stringTools.js"></script>
@endsection