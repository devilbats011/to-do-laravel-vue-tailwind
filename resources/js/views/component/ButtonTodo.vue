<template>
    <div :class="rootClass" >
        <button
            @click="btnClick()"
            :disabled="btnDisabled"
             class=" w-full text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center"
            :class="btnDisabled ? classDisabled : classEnabled"
            type="button"
        >
            {{name}}
        </button>
    </div>
</template>

<script>
export default {
    props: {
        rootClass: {
            type:String,
            default: ""
        },
        name:{
            type:String,
            default: "No-Name"
        },
        btnClick: {
            type: Function,
            default: () => null,
        },
        btnDisabled:{
            type: Boolean,
            default:false,
        },
        _btnColor: {
            type: String,
            default: "blue",
        },
    },
    mounted() {
        this.colorFactory(this._btnColor);
    },
    data() {
        return {
            classEnabled: "",
            classDisabled: "",
        }
    },
    methods: {
        colorFactory(_color) {
            const color = _color;
            console.log('color:', color)
            this.classEnabled = `bg-${color}-500 hover:bg-${color}-700`
            this.classDisabled = `bg-gray-300`
        },
    },
};
</script>
<style>

</style>
