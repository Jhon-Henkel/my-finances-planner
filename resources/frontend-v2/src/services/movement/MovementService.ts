import {MovementModel} from "@/model/movement/MovementModel"
import {ApiRouter} from "@/api/ApiRouter"
import {IMovementForm} from "@/services/movement/IMovementForm"
import {alertOutline, arrowDownOutline, arrowUpOutline, repeatOutline} from "ionicons/icons"
import {useMovementStore} from "@/stores/movement/MovementStore"
import {IMovementFormView} from "@/services/movement/IMovementFormView"

const movementType = {
    income: 6,
    expense: 5,
    transfer: 7,
    all: 0
}

export const MovementService = {
    index: async (quest: null | string = null): Promise<Array<MovementModel>> => {
        const data = quest ? await ApiRouter.movement.indexFiltered(quest) : await ApiRouter.movement.index()
        return data.map((item: any) => new MovementModel(item))
    },
    create: async (data: IMovementForm): Promise<MovementModel> => {
        return await ApiRouter.movement.post(data).then((response: any) => {
            return new MovementModel(response)
        })
    },
    update: async (data: IMovementForm): Promise<MovementModel> => {
        return await ApiRouter.movement.put(data.id, data).then((response: any) => {
            return new MovementModel(response)
        })
    },
    delete: async (id: number): Promise<void> => {
        await ApiRouter.movement.delete(id)
    },
    deleteTransfer: async (id: number): Promise<void> => {
        await ApiRouter.movement.transfer.delete(id)
    },
    emptyMovement: (): IMovementFormView => {
        return {
            id: undefined,
            walletId: 0,
            description: '',
            walletName: '',
            amount: 0,
            type: movementType.expense,
        }
    },
    getTypesList: (): Array<{ value: number, label: string }> => {
        return [
            {value: movementType.income, label: 'Entrada'},
            {value: movementType.expense, label: 'Saída'}
        ]
    },
    getTypesListForFilter: (): Array<{ value: number, label: string }> => {
        return [
            {value: movementType.income, label: 'Entradas'},
            {value: movementType.expense, label: 'Saídas'},
            {value: movementType.transfer, label: 'Transferências'},
            {value: movementType.all, label: 'Todas'}
        ]
    },
    sumTotalValues: (movements: Array<MovementModel>): { incomes: number, expenses: number, balance: number } => {
        let incomes: number = 0
        let expenses: number = 0
        let balance: number = 0
        if (movements.length > 0) {
            movements.forEach((movement: MovementModel) => {
                if (movement.type === movementType.income) {
                    incomes += parseFloat(String(movement.amount))
                } else if (movement.type === movementType.expense) {
                    expenses += parseFloat(String(movement.amount))
                }
            })
            balance = incomes - expenses
        }
        return {incomes, expenses, balance}
    },
    getColorForMovementType: (type: number): string => {
        switch (type) {
            case movementType.income:
                return 'success'
            case movementType.expense:
                return 'danger'
            case movementType.transfer:
                return 'primary'
            default:
                return 'warning'
        }
    },
    getIconForMovementType: (type: number): string => {
        switch (type) {
            case movementType.income:
                return arrowUpOutline
            case movementType.expense:
                return arrowDownOutline
            case movementType.transfer:
                return repeatOutline
            default:
                return alertOutline
        }
    },
    geLabelForMovementType: (type: number): string => {
        switch (type) {
            case movementType.income:
                return 'Entrada'
            case movementType.expense:
                return 'Saída'
            case movementType.transfer:
                return 'Transferência'
            case movementType.all:
                return 'Todas'
            default:
                return 'Tipo desconhecido'
        }
    },
    updateMovementList: async () => {
        const store= useMovementStore()
        if (! store.isLoaded) {
            await store.loadMovements()
        }
    },
    forceUpdateMovementList: async () => {
        const store= useMovementStore()
        store.loadAgainOnNextTick()
        if (! store.isLoaded) {
            await store.loadMovements()
        }
    },
    incomeType: movementType.income,
    expenseType: movementType.expense,
    transferType: movementType.transfer,
    allType: movementType.all,
}