<template>
    <div :class="rootClass">
        <h1 class="text-center text-3xl text-bold mb-5 flex justify-center">
            <img
                :src="imgSrc()"
                class="relative"
                :style="titleStyle"
            />
            <span>{{ title }}</span>
        </h1>
    </div>
</template>

<script>
export default {
    props: {
        rootClass:{
            type:String,
            default:""
        },
        titleStyle: {
            type:String,
            default: "width: 30px;height:36px"
        },
        title: {
            type: String,
            default: "",
        },
        imgSrc: {
            type: Function,
        },
    },
};
</script>

<style></style>
