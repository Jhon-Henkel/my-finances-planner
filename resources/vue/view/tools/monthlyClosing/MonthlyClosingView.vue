<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" />
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="'Relatório fechamento de mês'"/>
                <filter-top-right :filter="filterList" @callbackMethod="getMonthlyClosingsIndexFiltered($event)"/>
                <back-button to="/ferramentas"/>
            </div>
            <divider/>
            <table class="table table-dark table-striped table-sm table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr class="text-center">
                        <td>
                            <font-awesome-icon :icon="iconEnum.calendarCheck()" />
                            Data
                        </td>
                        <td>
                            <gain-icon/>
                            Gasto Previsto
                        </td>
                        <td>
                            <gain-icon/>
                            Gasto Real
                        </td>
                        <td>
                            <spent-icon/>
                            Ganho Previsto
                        </td>
                        <td>
                            <spent-icon/>
                            Ganho Real
                        </td>
                        <td>
                            <font-awesome-icon :icon="iconEnum.scaleBalanced()" />
                            Balanço
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center" v-for="closing in monthlyClosings" :key="closing.id">
                        <td>{{ CalendarTools.convertDateDbToBr(closing.createdAt) }}</td>
                        <td>{{ StringTools.formatFloatValueToBrString(closing.predictedExpenses) }}</td>
                        <td>{{ StringTools.formatFloatValueToBrString(closing.realExpenses) }}</td>
                        <td>{{ StringTools.formatFloatValueToBrString(closing.predictedEarnings) }}</td>
                        <td>{{ StringTools.formatFloatValueToBrString(closing.realEarnings) }}</td>
                        <td>{{ StringTools.formatFloatValueToBrString(closing.balance) }}</td>
                    </tr>
                </tbody>
            </table>
            <divider/>
        </div>
    </div>
</template>

<script>
    import Divider from "../../../components/DividerComponent.vue";
    import MfpTitle from "../../../components/TitleComponent.vue";
    import iconEnum from "../../../../js/enums/iconEnum";
    import LoadingComponent from "../../../components/LoadingComponent.vue";
    import BackButton from "../../../components/buttons/BackButton.vue";
    import MonthlyClosingEnum from "../../../../js/enums/MonthlyClosingEnum";
    import apiRouter from "../../../../js/router/apiRouter";
    import CalendarTools from "../../../../js/tools/calendarTools";
    import StringTools from "../../../../js/tools/stringTools";
    import FilterTopRight from "../../../components/filters/filterTopRight.vue";
    import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
    import GainIcon from "../../../components/icons/GainIcon.vue";
    import SpentIcon from "../../../components/icons/SpentIcon.vue";

    export default {
        name: "MonthlyClosingView",
        computed: {
            StringTools() {
                return StringTools
            },
            CalendarTools() {
                return CalendarTools
            },
            iconEnum() {
                return iconEnum
            }
        },
        components: {
            SpentIcon,
            GainIcon,
            FontAwesomeIcon,
            FilterTopRight,
            BackButton,
            LoadingComponent,
            MfpTitle,
            Divider
        },
        data() {
            return {
                loadingDone: false,
                filterList: {},
                monthlyClosings: {
                    id: 0,
                    createdAt: "",
                    predictedExpenses: 0,
                    realExpenses: 0,
                    predictedEarnings: 0,
                    realEarnings: 0,
                    balance: 0
                }
            }
        },
        methods: {
            async getMonthlyClosingsIndexFiltered(filterId) {
                this.loadingDone = false
                await apiRouter.monthlyClosing.indexFiltered(filterId).then(response => {
                    this.monthlyClosings = response
                })
                this.loadingDone = true
            }
        },
        async mounted() {
            this.filterList = MonthlyClosingEnum.getFilterList()
            await this.getMonthlyClosingsIndexFiltered(MonthlyClosingEnum.filter.thisYear())
        }
    }
</script>

<style scoped lang="scss">

</style>