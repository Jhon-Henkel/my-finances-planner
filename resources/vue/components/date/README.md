- Library documentation https://vue3datepicker.com/installation/
- Library GitHub https://github.com/Vuepic/vue-datepicker

Internal MFP application usecase of date picker:

- Range Mode
    ```vue
        <template>
            <mfp-date-picker-range :range-date="date" @date-range-changed="date = $event"/>
        </template>

        <script>
            import MfpDatePickerRange from '../../components/date/DatePickerRange.vue'
            
            export default {
                components: {
                    MfpDatePickerRange
                },
                data() {
                    return {
                        // date range, array of date start and date end
                        date: [new Date(), new Date()]
                    }
                }
            }
        </script>
    ```
    
    Props:
    - autoApply: 
        - Boolean
        - Default: false
        - Description: this is used for auto apply date range when user select date range.
    - hideNavigation: 
        - Array 
        - Default: ['time', 'hous', 'minutes', 'seconds'] 
        - Description: this is used for hide navigations in date picker.
    - className: 
        - String 
        - Default: 'data-picker-range'
        - Description: this is used for custom class name for date picker.
    - rangeDate: 
        - Array
        - Required: false
        - Description: this is used for set date range, array of date start and date end. By default it will be current month.