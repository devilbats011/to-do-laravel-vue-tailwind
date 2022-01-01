<template>
    <section class="max-w-sm w-full lg:max-w-full mx-auto my-5">
        <div class="flex justify-center relative h-auto">
            <div
                class="lg:w-60 flex-none rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                :style="`
                    background-image: url(${imgUrl});
                    background-size: 100% 100%;
                    height: 260px;
                `"
                title="good cat"
            ></div>
            <div
                class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal"
            >
                <div class="mb-4">
                    <p class="text-sm text-gray-900 flex items-center"
                        :class="gold ? 'text-orange-400' : 'text-gray-900'"
                    >
                        <svg
                            class="fill-current text-gray-500 w-3 h-3 mr-2"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M4 8V6a6 6 0 1 1 12 0v2h1a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h1zm5 6.73V17h2v-2.27a2 2 0 1 0-2 0zM7 6v2h6V6a3 3 0 0 0-6 0z"
                            />
                        </svg>
                        Premium Membership
                    </p>
                    <h3 class="text-gray-500 font-bold text-xl mt-2"
                        :class="gold ? 'text-orange-500' : 'text-gray-500'"
                    >
                        {{ titleMonthsPremium }}
                        
                    </h3>
                    <h3 class="text-gray-500 font-bold text-xl mb-4"
                        :class="gold ? 'text-orange-500' : 'text-gray-500'"
                    >
                        Price: MYR {{ price }}
                    </h3>
                    <p
                        class="text-gray-700 text-md pr-16 mb-4"
                        style="max-width: 600px"
                    >
                        {{ description }}
                    </p>

                    <button
                        @click="serviceGoPremium()"
                        class="text-white font-bold py-2 px-4 rounded w-full lg:w-64"
                        :class="gold ? 'bg-orange-400 hover:bg-orange-700 ' : 'bg-blue-500 hover:bg-blue-700'"
                    >
                        Select
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    props: {
        titleMonthsPremium: {
            type: String,
            default: "",
        },
        imgUrl: {
            type: String,
            default: "",
        },
        price: {
            type: String,
            default: "",
        },
        description: {
            type: String,
            default: `Benefit, Goodies, Free-Gift, consectetur adipisicing
                      elit. Voluptatibus quia, nulla! Maiores praesentium
                    Voluptatibus!`,
        },
        gold:{
            type:Boolean,
            default:false
        },
        serviceGoPremium: {
            type: Function,
            default: () => null,
        },

    },
};
</script>

<style></style>
