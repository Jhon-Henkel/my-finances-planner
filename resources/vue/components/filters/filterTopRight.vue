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
            <select class="form-select" v-model="filterTypeSelected">
                <option v-for="item in filterTypeList"
                        :key="item.id"
                        :value="item.id"
                        @change="filterTypeSelected = $event.value">
                    {{ item.label }}
                </option>
            </select>
        </li>
        <li class="mt-2" v-if="useRadioGroupCardExpenses">
            <div class="form-check form-switch">
                <label class="form-check-label" for="group-card-expenses">
                    Desagrupar despesas cartão
                </label>
                <input class="form-check-input"
                       v-model="dontGroupCardExpenses"
                       type="checkbox"
                       role="switch"
                       id="group-card-expenses">
            </div>
        </li>
        <li>
            <button class="btn btn-success btn-full mt-4" @click="callbackMethod">
                Filtrar
            </button>
        </li>
    </ul>
</template>

<script>
import iconEnum from '~js/enums/iconEnum.js'
import MfpDatePickerRange from '~vue/components/date/DatePickerRange.vue'
import MovementEnum from '~js/enums/movementEnum.js'

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
            filterTypeSelected: MovementEnum.type.all(),
            dontGroupCardExpenses: false
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
        },
        useRadioGroupCardExpenses: {
            type: Boolean,
            default: false
        }
    },
    emits: [
        'filterQuest'
    ],
    methods: {
        callbackMethod() {
            const dateStart = this.date[0]
            const dateEnd = this.date[1]
            let quest = `?dateStart=${dateStart}&dateEnd=${dateEnd}&type=${this.filterTypeSelected}`
            if (this.dontGroupCardExpenses) {
                quest += `&dontGroupCardExpenses=${this.dontGroupCardExpenses}`
            }
            this.$emit('filterQuest', quest)
        }
    }
}
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .filter {
        font-size: 22px;
    }
    .dropdown-menu {
        width: 300px;
        padding: 10px;
    }
    .form-check-input:checked {
        background-color: $form-switch-color;
        border-color: $form-switch-color;
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