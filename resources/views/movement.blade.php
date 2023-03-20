@php
    use App\Enums\MovementEnum;
    use App\Enums\RouteEnum;
    use App\Enums\ViewEnum;
    use App\Services\WalletService;
    use App\Tools\StringTools;
    use App\Tools\CalendarTools;
@endphp
@extends(ViewEnum::VIEW_BASE)
@section('content')
    <h3 class="mt-2">Movimentações</h3>
    @include(ViewEnum::VIEW_MOVEMENT_TOP_BUTTONS)
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
                    <span class="badge
                    @if($movement->getType() == MovementEnum::SPENT)
                        text-bg-danger
                    @else
                        text-bg-success
                    @endif">
                        @if($movement->getType() == MovementEnum::SPENT)
                            <i class="fa-solid fa-arrow-up"></i>
                        @else
                            <i class="fa-solid fa-arrow-down"></i>
                        @endif
                        <i class="fa-solid fa-money-bill-1-wave"></i>
                    </span>
                </td>
                <td class="text-center">{{ ucfirst($movement->getDescription()) }}</td>
                <td class="text-center">{{ ucfirst($movement->getWalletName() ?? 'Não informado') }}</td>
                <td class="text-center">{{ CalendarTools::usToBrDate($movement->getCreatedAt()) }}</td>
                <td class="text-center">{{ StringTools::moneyBr($movement->getAmount()) }}</td>
                <td class="text-center">
                    {{-- todo adicionar ação de editar --}}
                    {{-- todo No delete deve desfazer a movimentação, ou seja, retirar ou acrescentar os valores --}}
                    <form method="post" action="{{ route(RouteEnum::WEB_DELETE_MOVEMENT, $movement->getId()) }}">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $movement->getId() }}">
                        <button class="btn btn-sm btn-danger rounded-5" type="submit" title="Deletar">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @php($totalByType[$movement->getType()] = ($totalByType[$movement->getType()] ?? 0) + $movement->getAmount())
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
    @php($wallets = app(WalletService::class)->findAll())
    {{-- todo deixar modais com fundo preto --}}
    {{-- todo validar se o nome que está sendo inserido na modal é único, senão a aplicação quebra --}}
    @include(ViewEnum::VIEW_SPENT_MODAL)
    @include(ViewEnum::VIEW_GAIN_MODAL)
    @include(ViewEnum::VIEW_TRANSFER_MODAL)
    <script type="text/javascript" src="resources/js/dataTable.js"></script>
    <script type="text/javascript" src="resources/js/tools/stringTools.js"></script>
@endsection