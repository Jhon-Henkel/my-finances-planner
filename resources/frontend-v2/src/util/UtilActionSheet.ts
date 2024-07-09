const cancelObject = {
    text: 'Cancelar',
    role: 'cancel',
    data: {
        action: 'cancel'
    }
}

const editObject = {
    text: 'Editar',
    data: {
        action: 'edit'
    }
}

const deleteObject = {
    text: 'Deletar',
    role: 'destructive',
    data: {
        action: 'delete',
    }
}

export const UtilActionSheet = {
    makeButtons(edit: boolean = false, del: boolean = false, cancel: boolean = false): Array<object> {
        const buttons: Array<object> = []
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
    }
}