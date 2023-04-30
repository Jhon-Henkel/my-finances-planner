<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" @loading-done="loadingDone = true"/>
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="'Calculadora de Salário'"/>
                <router-link class="btn btn-success rounded-5" to="/ferramentas">
                    <font-awesome-icon :icon="iconEnum.back()" class="me-2"/>
                    Voltar
                </router-link>
            </div>
            <divider/>
            <form>
                <input-money :value="calculate.salary"
                             :title="'Ultimo Salario'"
                             @input-money="calculate.salary = $event"/>
                <div class="row justify-content-center mt-3 mb-4">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="calculate-days-worked">
                                Dias Trabalhados
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <font-awesome-icon :icon="iconEnum.businessTime()" />
                                </span>
                                <input type="number"
                                       class="form-control"
                                       v-model="calculate.workDays"
                                       id="calculate-days-worked"
                                       required
                                       min="1"
                                       max="31">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <divider/>
            <div class="text-center">
                <h3>
                    Você vai receber aproximadamente:
                    {{ StringTools.formatFloatValueToBrString((calculate.salary/30)*calculate.workDays) }}
                </h3>
                <p>
                    <span class="text-warning">*</span>
                    Não está sendo considerado descontos de INSS, IRPF e outros.
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    import LoadingComponent from "../../../components/LoadingComponent.vue";
    import iconEnum from "../../../../js/enums/iconEnum";
    import InputMoney from "../../../components/inputMoneyComponent.vue";
    import StringTools from "../../../../js/tools/stringTools";
    import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
    import Divider from "../../../components/DividerComponent.vue";
    import MfpTitle from "../../../components/TitleComponent.vue";

    export default {
        name: "SalaryCalculator",
        computed: {
            StringTools() {
                return StringTools
            },
            iconEnum() {
                return iconEnum
            }
        },
        components: {
            MfpTitle,
            Divider,
            FontAwesomeIcon,
            InputMoney,
            LoadingComponent
        },
        data() {
            return {
                loadingDone: false,
                calculate: {
                    salary: 0,
                    workDays: 30,
                }
            }
        },
        mounted() {
            const salary = localStorage.getItem('userSalary');
            if (salary) {
                this.calculate.salary = salary;
            }
        }
    }
</script>

<style scoped>

</style>