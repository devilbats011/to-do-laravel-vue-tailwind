<template>
    <main>
        <Navbar></Navbar>
        <div v-if="user_type != 'premium_user'">
            <PlanPackageCard
                :serviceGoPremium="serviceGoPremium"
                :titleMonthsPremium="'One Month Premium Membership'"
                :price="'39.33'"
                :imgUrl="'https://pbs.twimg.com/media/EPTFQaMWoAQoKk1.jpg'"
            />
            <PlanPackageCard
                :serviceGoPremium="serviceGoPremium"
                :titleMonthsPremium="'Three Month Premium Membership'"
                :price="'62.99'"
                :imgUrl="'https://s.keepmeme.com/files/en_posts/20200819/f9f6f589f3bc55abf4a23d8bb4a621af2-cats-with-thumbs-up-sign-like.jpg'"
            />
            <PlanPackageCard
                :gold="true"
                :serviceGoPremium="serviceGoPremium"
                :titleMonthsPremium="'One Year Premium Membership'"
                :price="'93.33'"
                :imgUrl="'https://memegenerator.net/img/images/14741106.jpg'"
            />
        </div>
        <div v-else>
            <section class="max-w-sm w-full lg:max-w-full mx-auto my-5">
                <div class="flex justify-center relative h-auto">
                    <div
                        class="lg:w-60 flex-none rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                        style="
                            background-image: url('https://memegenerator.net/img/images/14741106.jpg');
                            background-size: 100% 100%;
                            height: 260px;
                        "
                        title="good cat"
                    ></div>
                    <div
                        class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal"
                    >
                        <div class="mb-4">
                            <h3
                                class="text-md text-blue-700 flex items-center p-3"
                            >
                                <svg
                                    class="fill-current text-blue-700 w-3 h-3 mr-2"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M4 8V6a6 6 0 1 1 12 0v2h1a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h1zm5 6.73V17h2v-2.27a2 2 0 1 0-2 0zM7 6v2h6V6a3 3 0 0 0-6 0z"
                                    />
                                </svg>
                                Your Already A Premium Member
                            </h3>
                            <hr class="border-t-1 border-blue-200" />
                            <div
                                class="text-md text-blue-700 flex items-center p-3"
                            >
                                <button
                                    @click="$router.go(-1)"
                                    class="bg-gray-500 hover:bg-gray-700 mx-2 px-5 py-2 mt-1 rounded text-white font-bold"
                                >
                                    Go Back
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
         <AlertBlock />
    </main>
</template>

<script>
import { kHeader } from "../../constant";
import { serviceGetUserInfo } from "../../services/api";
import Navbar from "../component/Navbar.vue";
import AlertBlock from "../component/AlertBlock.vue";
import PlanPackageCard from "../component/PlanPackageCard.vue";

export default {
    components: {
        Navbar,
        PlanPackageCard,
        AlertBlock
    },
    async mounted() {
        const accessToken = localStorage.getItem("access_token");
        if (accessToken == null) this.$router.push({ path: "/" });

        const userInfo = await serviceGetUserInfo();
        this.name = userInfo.name;
        this.username = userInfo.username;
        this.user_type = userInfo.user_type;
    },
    data() {
        return {
            name: "",
            username: "",
            user_type: "",
        };
    },
    methods: {
        serviceGoPremium() {
            const thisVue = this;
            fetch("/api/go-premium", {
                method: "get",
                headers: {
                    ...kHeader,
                    Authorization: localStorage.getItem("access_token"),
                },
            })
                .then(async (rawResponse) => {
                    const response = await rawResponse.json();
                    if (rawResponse.status == 200) {
                        console.log("premimum-response:", response);
                        if (response.message_status == "SUCCESS")
                            thisVue.$router.push({ path: "/" + response.to, query:{alertMessage:response.message} });
                    }
                })
                .catch((err) => {
                    console.error(err);
                });
        },
    },
};
</script>

<style></style>
