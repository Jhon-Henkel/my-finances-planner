<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" @loading-done="loadingDone = true"/>
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <h3 id="title">Calculadora de Salário</h3>
                <router-link class="btn btn-success rounded-5" to="/ferramentas">
                    <font-awesome-icon :icon="iconEnum.back()" class="me-2"/>
                    Voltar
                </router-link>
            </div>
            <hr class="mb-4">
            <form>
                <input-money :value="calculate.amount"
                             :title="'Ultimo Salario'"
                             @input-money="calculate.salary = $event"/>
                <div class="row justify-content-center mt-3 mb-4">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="calculate-hours-worked">
                                Horas trabalhadas em um mês
                            </label>
                            <input type="number"
                                   class="form-control"
                                   v-model="calculate.hourWorkedInMonth"
                                   id="calculate-hours-worked"
                                   required
                                   min="1">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3 mb-4">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="calculate-extra-hours-worked">
                                Horas Extras
                            </label>
                            <input type="number"
                                   class="form-control"
                                   v-model="calculate.extraHours"
                                   id="calculate-extra-hours-worked"
                                   required
                                   min="1">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3 mb-4">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="calculate-extra-percent">
                                Percentual de pago em cima das horas extras
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                <font-awesome-icon :icon="iconEnum.percent()" />
                            </span>
                                <input type="number"
                                       class="form-control"
                                       v-model="calculate.extraPercent"
                                       id="calculate-extra-percent"
                                       required
                                       min="1"
                                       max="100">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <hr class="mb-4">
            <div class="text-center">
                <h3>
                    Por hora você ganha aproximadamente:
                    {{ StringTools.formatFloatValueToBrString(totalPerHour) }}
                </h3>
                <h3>
                    Você vai receber aproximadamente:
                    {{ StringTools.formatFloatValueToBrString(total) }}
                </h3>
                <p>
                    <span class="text-red">*</span>
                    Não está sendo considerado descontos de INSS, IRPF e outros.
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    import LoadingComponent from "../../../components/LoadingComponent.vue";
    import InputMoney from "../../../components/inputMoneyComponent.vue";
    import iconEnum from "../../../../js/enums/iconEnum";
    import StringTools from "../../../../js/tools/stringTools";

    export default {
        name: "ExtraHoursCalculator",
        computed: {
            StringTools() {
                return StringTools
            },
            iconEnum() {
                return iconEnum
            }
        },
        components: {
            InputMoney,
            LoadingComponent
        },
        data() {
            return {
                loadingDone: false,
                calculate: {
                    salary: 0,
                    extraHours: 0,
                    extraPercent: 0,
                    hourWorkedInMonth: 170,
                },
                total: 0,
                totalPerHour: 0
            }
        },
        methods: {
            getExtraHoursResult() {
                this.totalPerHour = this.calculate.salary / this.calculate.hourWorkedInMonth;
                let extraHours = this.totalPerHour * this.calculate.extraHours
                this.total = extraHours + (extraHours * (this.calculate.extraPercent / 100));
            }
        },
        watch: {
            calculate: {
                handler() {
                    this.getExtraHoursResult();
                },
                deep: true
            }
        }
    }
</script>

<style scoped>

</style>