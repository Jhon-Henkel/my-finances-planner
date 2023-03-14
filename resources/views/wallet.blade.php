@php
    use App\Enums\RouteEnum;
    use App\Enums\WalletEnum;
    use App\Services\WalletService;
    use App\Tools\CalendarTools;
    use App\Tools\StringTools;
@endphp
@extends('snippets.base')
@section('content')
    <h3>Carteiras</h3>
    <div class="nav justify-content-end">
        <button class="btn btn-success rounded-5" data-bs-toggle="modal" data-bs-target="#insertWallet">
            <i class="fa-solid fa-wallet me-2"></i>
            Inserir
        </button>
    </div>
    <div class="mt-4">
        <table class="table table-dark table-striped table-sm" id="dataTable">
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
                @foreach($wallets as $wallet)
                    <tr>
                        <td class="text-center">{{ ucfirst($wallet->getName()) }}</td>
                        <td class="text-center">{{ WalletEnum::getDescription($wallet->getType()) }}</td>
                        <td class="text-center">{{ StringTools::moneyBr($wallet->getAmount()) }}</td>
                        <td class="text-center">{{ CalendarTools::usToBrDate($wallet->getCreatedAt()) }}</td>
                        <td class="text-center">{{ CalendarTools::usToBrDate($wallet->getUpdatedAt()) }}</td>
                        <td class="text-center">
                            <div class="ms-5" style="display: flex">
                                <button class="btn btn-sm btn-info rounded-5 me-1" onclick="edit({{ $wallet->getId() }})">
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
                @endforeach
            </tbody>
        </table>
    </div>
    @include('snippets.wallet.insertWalletModal')
    <script type="text/javascript" src="resources/js/dataTable.js"></script>
    <script type="text/javascript" src="resources/js/walletView.js"></script>
    <script type="text/javascript" src="resources/js/tools/stringTools.js"></script>
@endsection