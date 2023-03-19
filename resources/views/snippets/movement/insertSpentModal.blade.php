@php
    use App\Enums\RouteEnum;
    use App\Enums\ViewEnum;

    $dataHeader = [
        'modalId' => 'insertSpent',
        'title' => 'Cadastar Despesa',
        'action' => route(RouteEnum::WEB_INSERT_SPENT),
        'formName' => 'newSpent'
    ]
@endphp
@include(ViewEnum::VIEW_HEADER_MODAL, $dataHeader)
@include(ViewEnum::VIEW_DEFAULT_INPUT_MODAL, ['title' => 'Descrição:', 'name' => 'description'])
@include(ViewEnum::VIEW_GAIN_SPENT_SELECT_MODAL, ['title' => 'Carteira:', 'name' => 'wallet'])
@include(ViewEnum::VIEW_AMOUNT_INPUT_MODAL, ['title' => 'Valor do ganho:', 'name' => 'amountSpent'])
@include(ViewEnum::VIEW_FOOTER_MODAL)