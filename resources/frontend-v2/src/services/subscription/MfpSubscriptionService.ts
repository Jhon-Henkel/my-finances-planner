import {MfpConfirmAlert} from "@/components/alert/MfpConfirmAlert"
import {ApiRouter} from "@/api/ApiRouter"
import {MfpModal} from "@/components/modal/MfpModal"
import MfpPlanManageModal from "@/views/plan/MfpPlanManageModal.vue"
import {MfpOkAlert} from "@/components/alert/MfpOkAlert"
import router from "@/router"

export const MfpSubscriptionService = {
    openModal: async (massageConcatBefore: string = '', openConfirmation: boolean = true) => {
        let confirm = false
        if (openConfirmation) {
            const confirmAlert: MfpConfirmAlert = new MfpConfirmAlert("Bora fazer upgrade!")
            confirm = await confirmAlert.open(massageConcatBefore + ' Vamos fazer um upgrade?')
        }
        if (confirm && openConfirmation || !openConfirmation) {
            const modal = new MfpModal(MfpPlanManageModal)
            await modal.open()
        }
    },
    subscribeProPlan: async () => {
        const confirmMessage = new MfpConfirmAlert('Redirecionar para o Stripe')
        let message = 'Você será redirecionado para o Stripe para fazer sua assinatura. Após pago, basta '
        message += 'fazer o login novamente para começar a usar o plano Pro.'
        const confirm = await confirmMessage.open(message)
        if (! confirm) {
            return
        }
        const response = await ApiRouter.subscription.subscribe()
        window.location.href = response.approveLink
    },
    cancelProPlan: async (email: string) => {
        const confirmMessage = new MfpConfirmAlert('Cancelar assinatura')
        let message = 'Você tem certeza que deseja cancelar sua assinatura?'
        message += ' Após cancelado você receberá um e-mail para confirmando o cancelamento.'
        const confirm = await confirmMessage.open(message)
        if (! confirm) {
            return
        }
        await ApiRouter.subscription.cancel({reason: 'Cancelado via tela'})
        const alert = new MfpConfirmAlert('Assinatura cancelada')
        await alert.open('Sua assinatura foi cancelada com sucesso.')
        await router.push({name: 'subscribe-canceled', query: {email: email}})
    },
    syncSubscription: async (email: string) => {
        const okAlert = new MfpOkAlert('Retorno da Sincronização')
        await ApiRouter.subscription.updateAccount({email: email}).then(() => {
            okAlert.open('Sincronização realizada com sucesso.')
        }).catch(() => {
            okAlert.open('Erro ao sincronizar sua conta.')
        })
    }
}
