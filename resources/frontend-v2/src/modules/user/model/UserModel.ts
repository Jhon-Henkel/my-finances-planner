export class UserModel {
    name: string
    email: string
    password: any
    current_password: any

    constructor(data: any) {
        this.name = data.name
        this.email = data.email
    }
}