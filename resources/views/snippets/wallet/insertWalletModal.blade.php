@php
    use App\Enums\RouteEnum;
    use App\Enums\WalletEnum;
@endphp
<div class="modal fade" id="insertWallet" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1"
     aria-labelledby="staticBackdropLabel"
     aria-hidden="true"
     style="color: #000000">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                    Cadastar Carteira
                </h1>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="{{ route(RouteEnum::WEB_NEW_WALLET) }}"
                      name="newWallet">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="form-label" for="name">Nome:</label>
                        <input type="text" class="form-control" placeholder="My wallet" name="name" required>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label" for="type">Tipo:</label>
                        <select class="form-control" name="type" required>
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
                                   id="amount"
                                   onkeyup="formatValueToBr('amount')"
                                   required
                            >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            <i class="fa-solid fa-circle-xmark me-2"></i>
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-regular fa-circle-check me-2"></i>
                            Cadastrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>