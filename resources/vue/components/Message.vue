<template>
    <div>
        <div class="message text-center" :class="type">
            <font-awesome-icon v-if="type === messageEnum.messageSuccess()" class="icon" :icon="iconEnum.circleCheck()"/>
            <font-awesome-icon v-else-if="type === messageEnum.messageError()" class="icon" :icon="iconEnum.circleX()"/>
            <font-awesome-icon v-else-if="type === messageEnum.messageInfo()" class="icon" :icon="iconEnum.circleInfo()"/>
            <font-awesome-icon v-else-if="type === messageEnum.messageWarning()" class="icon" :icon="iconEnum.circleExclamation()"/>
            <span class="ms-2 text">{{ message }}</span>
        </div>
    </div>
</template>

<script>
    import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
    import messageEnum from "../../js/enums/messageEnum";
    import iconEnum from "../../js/enums/iconEnum";

    export default {
        name: "Message",
        computed: {
            iconEnum() {
                return iconEnum
            },
            messageEnum() {
                return messageEnum
            }
        },
        components: {FontAwesomeIcon},
        props: {
            message: String,
            type: String,

        }
    }
</script>

<style scoped>
    .message {
        border-radius: 10px;
        padding: 10px;
        margin: 30px auto;
        box-shadow: 0 0.5em 0.5em -0.4em #000000;
    }
    .message-success {
        color: #0f5132;
        border: 2px solid #badbcc;
        background-color: #d1e7dd;
    }
    .message-danger {
        color: #842029;
        border: 2px solid #f5c2c7;
        background-color: #f8d7da;
    }
    .message-info {
        color: #084298;
        border: 2px solid #b6d4fe;
        background-color: #cfe2ff;
    }
    .message-warning {
        color: #664d03;
        border: 2px solid #ffecb5;
        background-color: #fff3cd;
    }
    .icon {
        font-size: 20px;
    }
    .text {
        font-size: 20px;
    }
</style>