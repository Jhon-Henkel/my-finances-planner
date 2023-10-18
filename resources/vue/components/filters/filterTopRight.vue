<template>
    <button type="button" class="btn btn-success me-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <font-awesome-icon :icon="iconEnum.filterMoney()" class="me-2 mt-1 filter"/>
        Filtrar
    </button>
    <ul class="dropdown-menu">
        <li class="mt-2" v-if="useDatePickerRangeFilter">
            <span>Rage de data</span>
            <mfp-date-picker-range v-model="date" @date-range-changed="date = $event" />
        </li>
        <li class="mt-2" v-if="useTypeMovementFilter">
            <span>Tipo de gasto</span>
            <select class="form-select" @change="filterTypeSelected = $event">
                <option v-for="item in filterTypeList" :key="item.id" :value="item.id">
                    {{ item.label }}
                </option>
            </select>
        </li>
        <li>
            <button class="btn btn-success btn-full mt-4" @click="callbackMethod">
                Filtrar
            </button>
        </li>
    </ul>
</template>

<script>
import iconEnum from '../../../js/enums/iconEnum'
import MfpDatePickerRange from '../date/DatePickerRange.vue'
import MovementEnum from '../../../js/enums/movementEnum'

export default {
    name: 'filterTopRight',
    computed: {
        iconEnum() {
            return iconEnum
        }
    },
    components: {
        MfpDatePickerRange
    },
    data() {
        return {
            date: [],
            mustShowFilters: false,
            filterTypeList: MovementEnum.getTypeList(),
            filterTypeSelected: MovementEnum.type.all()
        }
    },
    props: {
        useDatePickerRangeFilter: {
            type: Boolean,
            default: true
        },
        useTypeMovementFilter: {
            type: Boolean,
            default: true
        }
    },
    emits: [
        'filterQuest'
    ],
    methods: {
        callbackMethod() {
            const dateStart = this.date[0]
            const dateEnd = this.date[1]
            const quest = `?dateStart=${dateStart}&dateEnd=${dateEnd}&type=${this.filterTypeSelected}`
            this.$emit('filterQuest', quest)
        },
        alterVisibilityFilter() {
            this.mustShowFilters = !this.mustShowFilters
        }
    }
}
</script>

<style scoped lang="scss">
    .filter {
        font-size: 22px;
    }
    .dropdown-menu {
        width: 300px;
        padding: 10px;
    }

    @media (max-width: 1000px) {
        .filter {
            display: none;
        }
        .me-3 {
            margin-right: 0 !important;
        }
        .dropdown-menu {
            width: 98%;
            padding: 10px;
            margin-left: 1%;
            margin-right: 1%;
        }
    }
</style>