import {ApiRouter} from "@/api/ApiRouter"
import {UserModel} from "@/model/user/UserModel"

export const UserService = {
    get: async (id: number): Promise<UserModel> => {
        const user = await ApiRouter.user.get(id)
        return new UserModel(user)
    },
    update: async (id: number, data: UserModel): Promise<UserModel> => {
        const user = await ApiRouter.user.update(id, data)
        return new UserModel(user)
    },
    makeEmptyUser: (): UserModel => {
        return new UserModel({
            email: '',
            name: '',
            marketPlannerValue: 0,
        })
    }
}