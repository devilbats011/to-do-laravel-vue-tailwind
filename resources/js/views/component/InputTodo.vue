<template>
    <div :class="rootClass ">
        <label class="block text-gray-700 text-sm font-bold mb-2" :for="label" >
            {{ label }}
        </label>
        <input
            @input="onInput"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
            :type="type"
            :placeholder="placeholder"
        />
        <p class="text-red-500 text-xs italic mb-2">
            {{ error }}
        </p>
    </div>
</template>

<script>
export default {
    // props: ["label", "inputVariable" ,"type", "error","rootClass","placeholder"],
    props: {
        inputCallback:{type:Function,default:()=>null},
        label:{type:String,default:""},
        type:{type:String,default:""},
        error:{type:String,default:""},
        rootClass:{type:String,default:""},
        placeholder:{type:String,default:""},
    },
    methods: {
        onInput(event){
            this.inputCallback(event.target.value)
        }
    }
};
</script>

<style></style>
