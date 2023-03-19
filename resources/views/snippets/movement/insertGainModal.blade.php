@php
    use App\Enums\RouteEnum;
@endphp
@php
    $dataHeader = [
        'modalId' => 'insertGain',
        'title' => 'Cadastar Ganho',
        'action' => route(RouteEnum::WEB_INSERT_GAIN),
        'formName' => 'newGain'
    ]
@endphp
@include('snippets.modal.headerModal', $dataHeader)
@include('snippets.modal.formGroupInputModal', ['title' => 'Descrição:', 'name' => 'description'])
@include('snippets.movement.insertGainSpentSelect', ['title' => 'Carteira:', 'name' => 'wallet'])
@include('snippets.modal.amountInputModal', ['title' => 'Valor do ganho:', 'name' => 'amountGain'])
@include('snippets.modal.footerModal')