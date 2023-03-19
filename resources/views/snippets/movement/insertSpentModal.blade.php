@php
    use App\Enums\RouteEnum;
@endphp
@php
    $dataHeader = [
        'modalId' => 'insertSpent',
        'title' => 'Cadastar Despesa',
        'action' => route(RouteEnum::WEB_INSERT_SPENT),
        'formName' => 'newSpent'
    ]
@endphp
@include('snippets.modal.headerModal', $dataHeader)
@include('snippets.modal.formGroupInputModal', ['title' => 'Descrição:', 'name' => 'description'])
@include('snippets.movement.insertGainSpentSelect', ['title' => 'Carteira:', 'name' => 'wallet'])
@include('snippets.modal.amountInputModal', ['title' => 'Valor do ganho:', 'name' => 'amountSpent'])
@include('snippets.modal.footerModal')