import {MfpConfirmAlert} from "@/components/alert/MfpConfirmAlert"

export const MfpSubscriptionService = {
    openModal: async (massageConcatBefore: string = '') => {
        const confirmAlert: MfpConfirmAlert = new MfpConfirmAlert("Bora fazer upgrade!")
        const confirm = await confirmAlert.open(massageConcatBefore + ' Vamos fazer um upgrade?')
        if (confirm) {
            await MfpSubscriptionService.openPlanPayment()
        }
    },
    openPlanPayment: async () => {
        console.log('openPlanPayment')
    }
}
