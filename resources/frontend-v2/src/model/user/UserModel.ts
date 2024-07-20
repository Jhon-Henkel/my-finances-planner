export class UserModel {
    salary: number
    name: string
    email: string
    password: any
    marketPlannerValue: number

    constructor(data: any) {
        this.salary = data.salary
        this.name = data.name
        this.email = data.email
        this.marketPlannerValue = data.marketPlannerValue
    }
}