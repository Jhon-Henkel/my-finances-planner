import {MfpConfirmAlert} from "@/components/alert/MfpConfirmAlert"
import {ApiRouter} from "@/api/ApiRouter"

export const MfpSubscriptionService = {
    openModal: async (massageConcatBefore: string = '') => {
        const confirmAlert: MfpConfirmAlert = new MfpConfirmAlert("Bora fazer upgrade!")
        const confirm = await confirmAlert.open(massageConcatBefore + ' Vamos fazer um upgrade?')
        if (confirm) {
            await MfpSubscriptionService.openPlanPayment()
        }
    },
    openPlanPayment: async () => {
        await ApiRouter.payPlan.post({aaa: 'bbb'})
    }
}
