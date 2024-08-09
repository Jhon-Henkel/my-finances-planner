import {ApiRouter} from "@/api/ApiRouter"
import {CardModel} from "@/model/card/CardModel"
import {useCardsStore} from "@/stores/cards/CardsStore"
import {ICardForm} from "@/services/cards/ICardForm"
import {MfpConfirmAlert} from "@/components/alert/MfpConfirmAlert"
import {MfpToast} from "@/components/toast/MfpToast"

export const CardsService = {
    index: async () => {
        const data = await ApiRouter.cards.index()
        return data.map((item: any) => new CardModel(item))
    },
    update: async (data: ICardForm) => {
        await ApiRouter.cards.put(data.id, data)
        await CardsService.forceReloadStore()
    },
    create: async (data: ICardForm) => {
        await ApiRouter.cards.post(data)
        await CardsService.forceReloadStore()
    },
    delete: async (data: CardModel): Promise<void> => {
        const deleteConfirmAlert = new MfpConfirmAlert('Deseja realmente deletar o cartão?')
        const confirmDelete = await deleteConfirmAlert.open(`Deseja realmente excluir o cartão ${data.name}?`)
        if (confirmDelete) {
            await ApiRouter.cards.delete(data.id)
            const toast = new MfpToast()
            await toast.open('Cartão deletado com sucesso!')
            await CardsService.forceReloadStore()
        }
    },
    forceReloadStore: async () => {
        const store = useCardsStore()
        store.loadAgainOnNextTick()
        await store.load()
    },
    makeEmptyCard: (): ICardForm => {
        return {
            id: null,
            name: '',
            limit: 0,
            dueDate: undefined,
            closingDay: undefined
        }
    }
}
