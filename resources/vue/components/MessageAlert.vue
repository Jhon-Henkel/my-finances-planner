<template>
    <div class="vue-alert" :class="!status ?`${position}` :`${position} ${isHide?'':'active'}`">
        <div class="alert-container">
            <div class="alert-color-bar" :class="alertType"/>
            <div class="alert-icon">
                <div class="alert-icon-box" :class="alertType" style="width: 35px; height: 35px;">
                    <font-awesome-icon :icon="icon"/>
                </div>
            </div>
            <div class="alert-content">
                <h5 class="alert-head">{{ header }}</h5>
                <p class="alert-message">{{ message }}</p>
            </div>
            <div class="alert-close">
                <div @click="closeAlert" class="alert-close-button">
                    <font-awesome-icon :icon="iconEnum.xMark()"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import iconEnum from "../../js/enums/iconEnum";
    import CalendarTools from "../../js/tools/calendarTools";
    import messageEnum from "../../js/enums/messageEnum";

    export default {
        name: 'mfp-message',
        computed: {
            iconEnum() {
                return iconEnum
            }
        },
        data() {
            return {
                icon: iconEnum.info(),
                position: 'top center',
                status: false,
                isHide: false,
                alertType: 'info',
                header: 'Algo Aconteceu!',
                message: 'Mas não sei o que!',
            };
        },
        methods: {
            showAlert(alertType, alertMessage, alertHeader) {
                this.alertType = alertType
                this.header = alertHeader ? alertHeader : alertType.toUpperCase()
                this.message = alertMessage
                setTimeout(() =>{
                    this.status = true
                }, CalendarTools.oneHundredMs())
                setTimeout(() => {
                    this.isHide = false
                    this.status = false
                    this.header = ''
                    this.message = ''
                }, CalendarTools.tenSecondsTimeInMs())
            },
            closeAlert() {
                this.isHide = true
                setTimeout(() => {
                    this.isHide = false
                    this.status = false
                    this.header = ''
                    this.message = ''
                }, CalendarTools.twoHundredMs())
            },
        },
        watch: {
            message: function (message) {
                if (message !== 'Mas não sei o que!') {
                    if (this.alertType === messageEnum.alertTypeSuccess()) {
                        this.icon = iconEnum.check()
                    } else if (this.alertType === messageEnum.alertTypeError()) {
                        this.icon = iconEnum.xMark()
                    } else if (this.alertType === messageEnum.alertTypeWarning()) {
                        this.icon = iconEnum.triangleExclamation()
                    } else if (this.alertType === messageEnum.alertTypeInfo()) {
                        this.icon = iconEnum.info()
                    }
                }
            }
        }
    };
</script>

<style lang="scss" scoped>
    @import "../../sass/variables";
    .vue-alert {
        width: 400px;
        position: fixed;
        display: block;
        margin: 0;
        border: none;
        opacity: 0;
        box-shadow: 0 0 1em #000000;
        background-color: #2a2a38;
        color: #ffffff;
        text-align: center;
        z-index: 1000000;
        transition: all 300ms ease-in-out;
        padding: 10px;
    }
    .vue-alert.top {
        top: 20px;
    }
    .vue-alert.top.center {
        transform: translate(50%, -100%);
        max-width: calc(100vw - 60px);
    }
    .vue-alert.center.active {
        opacity: 1;
        transform: translate(50%, 0%);
    }
    .vue-alert.center {
        right: 50%;
    }
    .vue-alert.active {
        opacity: 1;
        transform: translate(0px, 0px);
    }
    .vue-alert > .alert-container {
        display: flex;
        position: relative;
        width: 100%;
    }
    .vue-alert > .alert-container .alert-color-bar {
        min-height: 65px;
        height: auto;
        min-width: 5px;
        border-radius: 2px;
        margin-right: 10px;
    }
    .vue-alert > .alert-container .alert-icon {
        display: flex;
        margin: auto 16px auto 6px;
    }
    .vue-alert > .alert-container .alert-icon-box {
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 100%;
        margin: auto;
    }
    .vue-alert > .alert-container .alert-content {
        display: flex;
        width: 100%;
        flex-direction: column;
        justify-content: center;
    }
    .vue-alert > .alert-container .alert-icon-box.success,
    .vue-alert > .alert-container .alert-color-bar.success {
        background-color: $pop-up-success-color;
    }
    .vue-alert > .alert-container .alert-icon-box.info,
    .vue-alert > .alert-container .alert-color-bar.info {
        background-color: $info-icon-color;
    }
    .vue-alert > .alert-container .alert-icon-box.error,
    .vue-alert > .alert-container .alert-color-bar.error {
        background-color: $danger-icon-color;
    }
    .vue-alert > .alert-container .alert-icon-box.warning,
    .vue-alert > .alert-container .alert-color-bar.warning {
        background-color: $alert-icon-color;
    }
    .vue-alert > .alert-container .alert-close {
        display: flex;
        margin: 0px 6px;
    }
    .vue-alert > .alert-container .alert-close-button {
        padding: 6px;
        margin: auto;
        border-radius: 18%;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 21px; height: 21px;
        transition: all 300ms ease-in-out;
    }
    .vue-alert > .alert-container .alert-close-button:hover {
        background-color: $danger-icon-color;
        cursor: pointer;
        filter: drop-shadow(0px 1px 3px $black-color);
    }
    .vue-alert > .alert-container .alert-content > * {
        text-align: left;
        margin: 2px 4px;
        padding-right: 6px;
    }
    .vue-alert > .alert-container .alert-content > h5.alert-head {
        font-size: 16px;
        font-weight: 600;
        color: $pop-up-font-color;
    }
    .vue-alert > .alert-container .alert-content > p.alert-message {
        font-size: 14px;
        min-width: fit-content;
        font-weight: bold;
        line-height: 1.3;
        color: $pop-up-font-color;
    }
</style>