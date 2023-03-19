@php
    use App\Enums\RouteEnum;
    use App\Enums\ViewEnum;

    $dataHeader = [
        'modalId' => 'updateWallet',
        'title' => 'Atualizar Carteira',
        'action' => route(RouteEnum::WEB_UPDATE_WALLET),
        'formName' => 'updateWalletForm'
    ]
@endphp
@include(ViewEnum::VIEW_HEADER_MODAL, $dataHeader)
@include(ViewEnum::VIEW_DEFAULT_INPUT_MODAL, ['title' => 'Nome:', 'name' => 'name-update'])
@include(ViewEnum::VIEW_WALLET_TYPE_SELECT_MODAL, ['name' => 'type-update'])
@include(ViewEnum::VIEW_AMOUNT_INPUT_MODAL, ['title' => 'Valor:', 'name' => 'amount-update'])
<input type="hidden" id="id-update" name="id" value="">
@include(ViewEnum::VIEW_FOOTER_MODAL)