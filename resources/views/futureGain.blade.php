@php
    use App\Enums\DateEnum;
    use App\Enums\ViewEnum;
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
                        {{ app(\App\Services\WalletService::class)->findNameById($item['wallet']) }}
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
                <td class="text-center">
                    <button class="btn btn-sm btn-full btn-success" title="Editar">
                        @if(isset($item['data'][$rangeMonths[0]]))
                            {{ StringTools::moneyBr($item['data'][$rangeMonths[0]]['amount']) }}
                        @else
                            {{ '-' }}
                        @endif
                    </button>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-full btn-success" title="Editar">
                        @if(isset($item['data'][$rangeMonths[1]]))
                            {{ StringTools::moneyBr($item['data'][$rangeMonths[1]]['amount']) }}
                        @else
                            {{ '-' }}
                        @endif
                    </button>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-full btn-success" title="Editar">
                        @if(isset($item['data'][$rangeMonths[2]]))
                            {{ StringTools::moneyBr($item['data'][$rangeMonths[2]]['amount']) }}
                        @else
                            {{ '-' }}
                        @endif
                    </button>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-full btn-success" title="Editar">
                        @if(isset($item['data'][$rangeMonths[3]]))
                            {{ StringTools::moneyBr($item['data'][$rangeMonths[3]]['amount']) }}
                        @else
                            {{ '-' }}
                        @endif
                    </button>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-full btn-success" title="Editar">
                        @if(isset($item['data'][$rangeMonths[4]]))
                            {{ StringTools::moneyBr($item['data'][$rangeMonths[4]]['amount']) }}
                        @else
                            {{ '-' }}
                        @endif
                    </button>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-full btn-success" title="Editar">
                        @if(isset($item['data'][$rangeMonths[5]]))
                                {{ StringTools::moneyBr($item['data'][$rangeMonths[5]]['amount']) }}
                        @else
                            {{ '-' }}
                        @endif
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <hr>
    <script type="text/javascript" src="resources/js/dataTable.js"></script>
    <script type="text/javascript" src="resources/js/tools/stringTools.js"></script>
@endsection