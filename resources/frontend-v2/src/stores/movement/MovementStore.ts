import {defineStore} from 'pinia'
import {MovementModel} from "@/model/movement/MovementModel"
import {MovementService} from "@/services/movement/MovementService"

interface IMovementStoreState {
    movements: Array<MovementModel>
    isLoaded: boolean
    lastMovementFilterType: number
}

export const useMovementStore = defineStore({
    id: 'movement',
    state: (): IMovementStoreState => ({
        movements: [],
        isLoaded: false,
        lastMovementFilterType: MovementService.allType
    }),
    actions: {
        loadAgainOnNextTick() {
            this.isLoaded = false
        },
        async loadMovements(quest: string | null = null): Promise<Array<MovementModel>> {
            if (!this.isLoaded) {
                this.isLoaded = false
                this.movements = await MovementService.index(quest)
                this.isLoaded = true
            }
            return this.movements
        },
        setLastMovementFilterType(filter: number) {
            this.lastMovementFilterType = filter
        }
    },

    getters: {
        isLoadedOnStore(): boolean {
            return this.isLoaded
        },
        getMovements(): Array<MovementModel> {
            return this.movements
        }
    }
})