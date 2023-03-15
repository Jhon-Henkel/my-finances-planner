@php
    use App\Enums\RouteEnum;
    use App\Enums\WalletEnum;
@endphp
{{-- todo essa modal está praticamente igual a de insert--}}
<div class="modal fade" id="updateWallet" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1"
     aria-labelledby="staticBackdropLabel"
     aria-hidden="true"
     style="color: #000000">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                    Atualizar Carteira
                </h1>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="{{ route(RouteEnum::WEB_UPDATE_WALLET) }}"
                      name="updateWalletForm">
                    {{ csrf_field() }}
                    <div class="form-group">
                        {{-- todo nome não pode existir em outra carteira, validar em tempo real --}}
                        <label class="form-label" for="name">Nome:</label>
                        <input type="text" class="form-control" placeholder="My wallet" id="name-update" name="name" required>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label" for="type">Tipo:</label>
                        <select class="form-control" name="type" id="type-update" required>
                            @foreach(WalletEnum::getList() as $item)
                                <option value="{{ WalletEnum::getCode($item) }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label" for="amount">Valor inicial:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="fa-solid fa-brazilian-real-sign"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="12,34" name="amount" maxlength="10"
                                   id="amount-update"
                                   onkeyup="formatValueToBr('amount-update')"
                                   required
                            >
                        </div>
                    </div>
                    <input type="hidden" id="id-update" name="id" value="">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            <i class="fa-solid fa-circle-xmark me-2"></i>
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-regular fa-circle-check me-2"></i>
                            Atualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>