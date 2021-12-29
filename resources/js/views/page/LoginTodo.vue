<template>
    <main class="w-full max-w-xs mx-auto">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 mx-auto">
            <h1
                class="text-center text-3xl text-bold mb-5 flex justify-center relative"
                style="right: 6px"
            >
                <img :src="getSvgLock()" class="relative" style="width: 40px" />
                <span>Login</span>
            </h1>
            <div class="mb-4">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="username"
                >
                    email/username
                </label>
                <!-- coolguy@cool.com or coolguy94 -->
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="username"
                    type="text"
                    placeholder="email or username"
                    v-model="email_or_username"
                />
            </div>
            <div class="mb-6">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="password"
                >
                    password
                </label>
                <!--  border-red-500 -->
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    id="password"
                    type="password"
                    placeholder="**********"
                    v-model="password"
                />
                <p class="text-red-500 text-md italic text-center">
                    {{ errorMessage }}
                </p>
            </div>
            <div class="mb-6">
                <!-- class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center" -->
                <button
                    @click="handleLoginFetch()"
                    type="button"
                    class="w-full text-white font-bold py-2 px-4 rounded text-center"
                    :class="
                        loginDisabled
                            ? 'bg-blue-200'
                            : 'bg-blue-500 hover:bg-blue-700'
                    "
                    :disabled="loginDisabled"
                >
                    Log In
                </button>
            </div>
            <div>
                <button
                    @click="helperTo('/register')"
                    class="w-full bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center"
                    type="button"
                >
                    Register
                </button>
                <p class="text-center text-gray-500 text-xs mt-6">
                    &copy; 2021 TO-DO
                </p>
            </div>
        </form>
    </main>
</template>

<script>
// import axios from "axios";
import { kHeader } from "./../../constant";
export default {
    name: "LoginTodo",
    data() {
        return {
            email_or_username: "",
            password: "",
            loginDisabled: false,
            errorMessage: "",
            _header: null,
        };
    },
    mounted() {

        this._header = kHeader;
        if(localStorage.getItem("access_token") != null)
          this.$router.push({ path:"/display" });

    },

    methods: {
        getSvgLock() {
            return "images/lock.svg";
        },
        async handleLoginFetch() {
            const router = this.$router;
            const _email_or_username = this.email_or_username;
            const _password = this.password;

            this.loginDisabled = true;
            const rawResponse = await fetch(
                `/api/login?timestamp=${new Date().getTime()}`,
                {
                    method: "POST",
                    headers: this._header,
                    body: JSON.stringify({
                        email_or_username: _email_or_username,
                        password: _password,
                    }),
                }
            )
                .catch((err) => {
                    this.errorMessage = "Something wrong..";
                    console.warn(err);
                })
                .finally(() => {
                    this.loginDisabled = false;
                });

            const content = await rawResponse.json();
            if (rawResponse.status === 200) {
                localStorage.setItem(
                    "access_token",
                    `Bearer ${content.access_token}`
                );
                router.push({ path: "/" + content.to });
            } else {
                if (
                    (content.message !== null) |
                    (content.message !== undefined)
                )
                    this.errorMessage = content.message;
            }
            console.log(content, rawResponse);
        },
    },
};
</script>

<style></style>
