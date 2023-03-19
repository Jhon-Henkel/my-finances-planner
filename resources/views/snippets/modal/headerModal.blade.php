<div class="modal fade" id="{{ $modalId }}" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1"
     aria-labelledby="staticBackdropLabel"
     aria-hidden="true"
     style="color: #000000;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                    {{ $title }}
                </h1>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action=" {{ $action }}"
                      name="{{ $formName }}">
                    {{ csrf_field() }}