@php
    use App\Enums\RouteEnum;
    use App\Enums\ViewEnum;
    use App\Enums\WalletEnum;
    use App\Resources\WalletResource;
    use App\Services\WalletService;
    use App\Tools\CalendarTools;
    use App\Tools\StringTools;
@endphp
@extends(ViewEnum::VIEW_BASE)
@section('content')
    <h3 class="mt-2">Carteiras</h3>
    <div class="nav justify-content-end">
        <button class="btn btn-success rounded-5" data-bs-toggle="modal" data-bs-target="#insertWallet">
            <i class="fa-solid fa-wallet me-2"></i>
            Nova Carteira
        </button>
    </div>
    <hr>
    <div class="mt-4">
        <table class="table table-dark table-striped table-sm table-hover table-bordered" id="dataTable">
            <thead class="table-dark">
            <tr>
                <th class="text-center">Nome</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">Montante</th>
                <th class="text-center">Data Criação</th>
                <th class="text-center">Ultima atualização</th>
                <th class="text-center">Ações</th>
            </tr>
            </thead>
            <tbody>
            @php($wallets = app(WalletService::class)->findAll())
            @php($totalByType = [])
            @php($total = 0)
            @foreach($wallets as $wallet)
                <tr>
                    <td class="text-center">{{ ucfirst($wallet->getName()) }}</td>
                    <td class="text-center">{{ WalletEnum::getDescription($wallet->getType()) }}</td>
                    <td class="text-center">{{ StringTools::moneyBr($wallet->getAmount()) }}</td>
                    <td class="text-center">{{ CalendarTools::usToBrDate($wallet->getCreatedAt()) }}</td>
                    <td class="text-center">{{ CalendarTools::usToBrDate($wallet->getUpdatedAt()) }}</td>
                    <td class="text-center">
                        <div class="ms-5" style="display: flex">
                            <button class="btn btn-sm btn-info rounded-5 me-1"
                                    onclick="edit({{ json_encode(app(WalletResource::class)->dtoToArray($wallet)) }})">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <form method="post" action="{{ route(RouteEnum::WEB_DELETE_WALLET, $wallet->getId()) }}">
                                {{ csrf_field() }}
                                <input type="hidden" value="{{ $wallet->getId() }}">
                                <button class="btn btn-sm btn-danger rounded-5" type="submit">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @php($totalByType[$wallet->getType()] = ($totalByType[$wallet->getType()] ?? 0) + $wallet->getAmount())
                @php($total = $total + $wallet->getAmount())
            @endforeach
            </tbody>
        </table>
        <hr>
        <h6>Totais por tipo de conta:</h6>
        @foreach($totalByType as $key => $value)
            <div class="badge text-bg-info">
                {{ WalletEnum::getDescription($key) }}: {{ StringTools::moneyBr($value) }}
            </div>
        @endforeach
        <div class="badge text-bg-warning">
            Total: {{ StringTools::moneyBr($total) }}
        </div>
        <hr>
    </div>
    {{-- todo deixar moals com fundo preto --}}
    {{-- todo validar se o nome que está sendo inserido na modal é único, senão a aplicação quebra --}}
    @include(ViewEnum::VIEW_INSERT_WALLET_MODAL)
    @include(ViewEnum::VIEW_UPDATE_WALLET_MODAL)
    <script type="text/javascript" src="resources/js/dataTable.js"></script>
    <script type="text/javascript" src="resources/js/walletView.js"></script>
    <script type="text/javascript" src="resources/js/tools/stringTools.js"></script>
@endsection