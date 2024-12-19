import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {MfpConfirmAlert} from "@/modules/@shared/components/alert/MfpConfirmAlert"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"
import {CreditCardModel} from "@/modules/credit-card/model/CreditCardModel"
import {useCreditCardStore} from "@/modules/credit-card/store/CreditCardStore"
import {ICreditCardForm} from "@/modules/credit-card/service/ICreditCardForm"

export const CreditCardService = {
    index: async () => {
        const data = await ApiRouter.cards.index()
        return data.map((item: any) => new CreditCardModel(item))
    },
    update: async (data: ICreditCardForm) => {
        await ApiRouter.cards.put(data.id, data)
        await CreditCardService.reloadStore()
    },
    create: async (data: ICreditCardForm) => {
        await ApiRouter.cards.post(data)
        await CreditCardService.reloadStore()
    },
    delete: async (data: CreditCardModel): Promise<void> => {
        const deleteConfirmAlert = new MfpConfirmAlert('Deseja realmente deletar o cartão?')
        const confirmDelete = await deleteConfirmAlert.open(`Deseja realmente excluir o cartão ${data.name}?`)
        if (confirmDelete) {
            await ApiRouter.cards.delete(data.id)
            const toast = new MfpToast()
            await toast.open('Cartão deletado com sucesso!')
            await CreditCardService.reloadStore()
        }
    },
    reloadStore: async () => {
        const store = useCreditCardStore()
        await store.load()
    },
    makeEmptyCard: (): ICreditCardForm => {
        return {
            id: null,
            name: '',
            limit: 0,
            dueDate: undefined,
            closingDay: undefined
        }
    }
}
