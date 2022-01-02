<template>
    <div
        class="opacity-80 fixed top-0 left-0 right-0 bg-gradient-to-r from-teal-700 to-cyan-300 border-t-4 border-slate-500 rounded-b text-white px-4 py-3 shadow-md"
        :class="hidden ? 'hidden' : ''"
        @click="clickHide()"
        role="alert"
    >
        <div class="flex">
            <div class="ml-10">
                <svg
                    class="fill-current h-6 w-6 text-white mr-4 mt-2"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                >
                    <path
                        d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"
                    />
                </svg>
            </div>
            <div>
                <p class="font-bold">{{ title }}</p>
                <p class="text-sm">{{ message }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        const {alertMessage} = this.$router.history.current.query;
        console.log('alertMessage:', alertMessage)
        if(alertMessage !== undefined  && alertMessage !== ""){
            this.message = alertMessage
             
            this.hidden = false
            this.hideDelay()
        }
        else {
            this.$router.push({query:{alertMessage:""}});
        }
    },
    props: {
        title: {
            type: String,
            default: "Message",
        },
 
 
    },
    data() {
        return {
            message:"",
            hidden:true
        }
    },
    methods: {
        clickHide() {
            this.hidden = true;
        },
        hideDelay() {
            const thisVue = this;
            setTimeout(function () {
                thisVue.hidden = true;
            }, 5000);
        },
    },
};
</script>

<style></style>
