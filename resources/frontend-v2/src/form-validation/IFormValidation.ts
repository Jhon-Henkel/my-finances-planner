import {IFormValidationReturn} from "@/form-validation/IFormValidationReturn"

export interface IFormValidation {
    validate: (data: any) => IFormValidationReturn
}