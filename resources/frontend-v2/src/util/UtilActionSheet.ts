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
        buttons.push({
            text: 'Pagar',
            data: {
                action: 'pay'
            }
        })
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
    }
}