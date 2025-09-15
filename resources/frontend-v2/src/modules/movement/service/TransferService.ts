import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {ITransferForm} from "@/modules/movement/service/ITransferForm"

export const TransferService = {
    create: async (transfer: ITransferForm) => {
        return await ApiRouter.movement.transfer.post(transfer).then((response: any) => {
            return response
        })
    },
    emptyTransfer: (): ITransferForm => {
        return {
            amount: 0,
            originId: 0,
            destinationId: 0
        }
    }
}
