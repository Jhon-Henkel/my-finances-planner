interface IActionSheetItem {
    text: string
    role?: string
    data: {
        action: string
    }

}

const cancelObject: IActionSheetItem = {
    text: 'Cancelar',
    role: 'cancel',
    data: {
        action: 'cancel'
    }
}

const editObject: IActionSheetItem = {
    text: 'Editar',
    data: {
        action: 'edit'
    }
}

const deleteObject: IActionSheetItem = {
    text: 'Deletar',
    role: 'destructive',
    data: {
        action: 'delete',
    }
}

const detailsObject: IActionSheetItem = {
    text: 'Detalhes',
    data: {
        action: 'details'
    }
}

const payObject: IActionSheetItem = {
    text: 'Pagar',
    data: {
        action: 'pay'
    }
}

export const UtilActionSheet = {
    makeButtons(edit: boolean = false, del: boolean = false, cancel: boolean = false): Array<IActionSheetItem> {
        const buttons: Array<IActionSheetItem> = []
        if (edit) {
            buttons.push(editObject)
        }
        if (del) {
            buttons.push(deleteObject)
        }
        if (cancel) {
            buttons.push(cancelObject)
        }
        return buttons
    },
    makeButtonsToPanorama(): Array<IActionSheetItem> {
        const buttons: Array<IActionSheetItem> = []
        buttons.push(payObject)
        buttons.push({
            text: 'Adicionar Valor',
            data: {
                action: 'add-value'
            }
        })
        buttons.push(editObject)
        buttons.push(detailsObject)
        buttons.push(deleteObject)
        buttons.push(cancelObject)
        return buttons
    },
    makeButtonsToFutureProfits(): Array<IActionSheetItem> {
        const buttons: Array<IActionSheetItem> = []
        buttons.push({
            text: 'Receber',
            data: {
                action: 'receive'
            }
        })
        buttons.push(editObject)
        buttons.push(detailsObject)
        buttons.push(deleteObject)
        buttons.push(cancelObject)
        return buttons
    },
    makeButtonsToCards(): Array<IActionSheetItem> {
        const buttons: Array<IActionSheetItem> = []
        buttons.push(editObject)
        buttons.push(payObject)
        buttons.push({
            text: 'Adicionar Compra',
            data: {
                action: 'new-invoice-item'
            }
        })
        buttons.push({
            text: 'Ver Faturas',
            data: {
                action: 'see-invoices'
            }
        })
        buttons.push(detailsObject)
        buttons.push(deleteObject)
        buttons.push(cancelObject)
        return buttons
    }
}