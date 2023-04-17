<template>
    <div v-show="isShowMessage">
        <div class="message text-center" :class="type">
            <font-awesome-icon class="icon" :icon="icon"/>
            <span class="ms-2 text">
                {{ message }}
            </span>
        </div>
    </div>
</template>

<script>
    import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
    import messageEnum from "../../js/enums/messageEnum";
    import iconEnum from "../../js/enums/iconEnum";
    import CalendarTools from "../../js/tools/calendarTools";

    export default {
        name: "Message",
        data () {
            return {
                icon: iconEnum.circleCheck(),
                isShowMessage: false,
            }
        },
        computed: {
            iconEnum() {
                return iconEnum
            },
        },
        components: {
            FontAwesomeIcon
        },
        props: {
            message: String,
            type: String,
            time: {
                type: Number,
                default: CalendarTools.fiveSecondsTimeInMs()
            },
        },
        methods: {
            getIconForType() {
                if (this.type === messageEnum.messageTypeSuccess()) {
                    this.icon = iconEnum.circleCheck()
                } else if (this.type === messageEnum.messageTypeError()) {
                    this.icon = iconEnum.circleX()
                } else if (this.type === messageEnum.messageTypeInfo()) {
                    this.icon = iconEnum.circleInfo()
                } else if (this.type === messageEnum.messageTypeWarning()) {
                    this.icon = iconEnum.circleExclamation()
                }
            }
        },
        mounted() {
            this.getIconForType()
            if (this.message) {
                this.isShowMessage = true
                setTimeout(() => [this.isShowMessage = false],
                    this.time
                )
            }
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