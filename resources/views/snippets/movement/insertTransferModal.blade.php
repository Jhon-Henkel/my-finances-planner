@php
    use App\Enums\RouteEnum;
@endphp
@php
    $dataHeader = [
        'modalId' => 'insertTransfer',
        'title' => 'Cadastar Transferência',
        'action' => route(RouteEnum::WEB_INSERT_TRANSFER),
        'formName' => 'newTransfer'
    ]
@endphp
@include('snippets.modal.headerModal', $dataHeader)
@include('snippets.modal.formGroupInputModal', ['title' => 'Descrição:', 'name' => 'description'])
@include('snippets.movement.insertGainSpentSelect', ['title' => 'Carteira de saida:', 'name' => 'walletOut'])
@include('snippets.movement.insertGainSpentSelect', ['title' => 'Carteira de entrada:', 'name' => 'walletIn'])
@include('snippets.modal.amountInputModal', ['title' => 'Valor da transferência:', 'name' => 'amountTransfer'])
@include('snippets.modal.footerModal')