import MovementEnum from "./movementEnum";

const THIS_YEAR = 4;
const THIS_YEAR_LABEL = 'Este Ano';
const LAST_YEAR = 5;
const LAST_YEAR_LABEL = 'Último Ano';
const LAST_FIVE_YEARS = 6;
const LAST_FIVE_YEARS_LABEL = 'Últimos 5 Anos';

const MonthlyClosingEnum = {
    getFilterList: () => {
        return [
            { id: THIS_YEAR, label: THIS_YEAR_LABEL },
            { id: LAST_YEAR, label: LAST_YEAR_LABEL },
            { id: LAST_FIVE_YEARS, label: LAST_FIVE_YEARS_LABEL },
        ];
    },
    filter: {
        thisYear: () => THIS_YEAR,
        lastYear: () => LAST_YEAR,
        lastFiveYears: () => LAST_FIVE_YEARS,
    }
}
export default MonthlyClosingEnum;