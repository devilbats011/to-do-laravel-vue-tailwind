<template>
    <nav
        class="w-11/12 bg-white mx-auto my-5 py-3 px-4 rounded"
       
    >
        <div class="flex flex-col-reverse lg:flex-row-reverse">
            <div class="mx-2 my-1 px-3 py-2 text-blue-500 font-bold text-xl">
              <div> {{ user_type == "premium_user" ? "Premium User" : "Free User" }} </div>
              
            </div>
            <button class="bg-cyan-500 hover:bg-blue-700 transition-all px-5 py-2 rounded text-white font-bold " v-if="user_type == 'free_user'" @click="helperTo('/plan-package')" > GO PREMIUM! </button>
            <div class="mx-2 my-1 p-3 font-bold border text-gray-500">
                Username: {{ username }} | Name: {{ name }}
            </div>
            <div class="mx-3 pt-2 text-left flex-auto">
              
                <button
                    @click="handleLogout()"
                    class="bg-blue-400 hover:bg-blue-600 px-5 py-2  rounded text-white font-bold"
                >
                    Log Out
                </button>

                <button
                    @click="goBack()"
                    class="bg-gray-500 hover:bg-gray-700 mx-2 px-5 py-2 rounded text-white font-bold "
                >
                   Back 
                </button>
            </div>
        </div>
    </nav>
</template>
<script>
import axios from "axios";
import { kHeader } from "../../constant";
import {serviceGetUserInfo} from '../../services/api'
export default {
    name: "Navbar",
    async mounted() {
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
        goBack(){
            this.$router.go(-1)
        },
        handleLogout() {
            const router = this.$router;
            const token = localStorage.getItem("access_token");
            axios({
                method: "get",
                url: "/api/logout",
                headers: { ...kHeader, Authorization: `${token}` },
           
            })
                .then(function (res) {
                    localStorage.clear();

                    router.push({
                        path: "/",
                        query: { alertMessage: res.data.message },
                    });
                })
                .catch((err) => {
                    this.errorMessage = "Invalid Credentials";
                    if (err.response !== undefined) {
                        console.warn("error.respond", err.response);
                        this.errorMessage = err.response.data.message;
                    }
                    console.error("error", err);
                });
        },
    },
};
</script>

<style></style>
