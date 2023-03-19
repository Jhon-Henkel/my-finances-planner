@php
    use App\Enums\RouteEnum;
    use App\Enums\ViewEnum;

    $dataHeader = [
        'modalId' => 'insertTransfer',
        'title' => 'Cadastar Transferência',
        'action' => route(RouteEnum::WEB_INSERT_TRANSFER),
        'formName' => 'newTransfer'
    ]
@endphp
@include(ViewEnum::VIEW_HEADER_MODAL, $dataHeader)
@include(ViewEnum::VIEW_DEFAULT_INPUT_MODAL, ['title' => 'Descrição:', 'name' => 'description'])
@include(ViewEnum::VIEW_GAIN_SPENT_SELECT_MODAL, ['title' => 'Carteira de saida:', 'name' => 'walletOut'])
@include(ViewEnum::VIEW_GAIN_SPENT_SELECT_MODAL, ['title' => 'Carteira de entrada:', 'name' => 'walletIn'])
@include(ViewEnum::VIEW_AMOUNT_INPUT_MODAL, ['title' => 'Valor da transferência:', 'name' => 'amountTransfer'])
@include(ViewEnum::VIEW_FOOTER_MODAL)