import messageEnum from '../enums/messageEnum'

const messageTools = {
    newMessage(type, message, header) {
        return {
            alertType: type,
            alertMessage: message,
            alertHeader: header
        }
    },
    successMessage(message) {
        return {
            alertType: messageEnum.alertTypeSuccess(),
            alertMessage: message,
            alertHeader: 'Sucesso!'
        }
    },
    infoMessage(message) {
        return {
            alertType: messageEnum.alertTypeInfo(),
            alertMessage: message,
            alertHeader: 'Informação!'
        }
    },
    errorMessage(message) {
        return {
            alertType: messageEnum.alertTypeWarning(),
            alertMessage: message,
            alertHeader: 'Ocorreu um erro!'
        }
    },
    warningMessage(message, header) {
        return {
            alertType: messageEnum.alertTypeWarning(),
            alertMessage: message,
            alertHeader: header ?? 'Atenção!'
        }
    },
    invalidFieldMessage(field) {
        return {
            alertType: messageEnum.alertTypeWarning(),
            alertMessage: 'Campo "' + field + '" é inválido!',
            alertHeader: 'Campo inválido!'
        }
    }
}

export default messageTools