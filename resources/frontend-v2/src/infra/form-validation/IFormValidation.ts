import {IFormValidationReturn} from "@/infra/form-validation/IFormValidationReturn"

export interface IFormValidation {
    validate: (data: any) => IFormValidationReturn
}
