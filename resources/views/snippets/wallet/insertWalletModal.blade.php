@php
    use App\Enums\RouteEnum;
    use App\Enums\ViewEnum;

    $dataHeader = [
        'modalId' => 'insertWallet',
        'title' => 'Cadastar Carteira',
        'action' => route(RouteEnum::WEB_NEW_WALLET),
        'formName' => 'newWallet'
    ]
@endphp
@include(ViewEnum::VIEW_HEADER_MODAL, $dataHeader)
@include(ViewEnum::VIEW_DEFAULT_INPUT_MODAL, ['title' => 'Nome:', 'name' => 'name'])
@include(ViewEnum::VIEW_WALLET_TYPE_SELECT_MODAL, ['name' => 'type'])
@include(ViewEnum::VIEW_AMOUNT_INPUT_MODAL, ['title' => 'Valor inicial:', 'name' => 'amount'])
@include(ViewEnum::VIEW_FOOTER_MODAL)