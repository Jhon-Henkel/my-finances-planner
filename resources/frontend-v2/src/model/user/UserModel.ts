export class UserModel {
    name: string
    email: string
    password: any
    marketPlannerValue: number

    constructor(data: any) {
        this.name = data.name
        this.email = data.email
        this.marketPlannerValue = data.marketPlannerValue
    }
}