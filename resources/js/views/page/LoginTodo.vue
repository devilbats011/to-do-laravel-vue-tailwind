<template>
    <main class="w-full max-w-xs mx-auto">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 mx-auto">
            <title-todo  :imgSrc="getSvgLock" :title="'Login'" :titleStyle="'width: 40px;bottom:0rem'" />
            <input-todo :rootClass="'mb-4'" :label="'Email/Username'" :inputCallback="(value)=>email_or_username=value" :type="'text'" :placeholder="'email or username'"  />
            <input-todo :rootClass="'mb-2'" :label="'Password'" :inputCallback="(value)=>password=value" :type="'password'" :placeholder="'***********'"  />

 
            <div class="mb-6">
                <p class="text-red-500 text-md italic text-center">
                    {{ errorMessage }}
                </p>
            </div>
                <button-todo :rootClass="'my-6 '" :name="'Login'" :btnClick="handleLoginFetch" :btnDisabled="loginDisabled" />
                <button-todo :rootClass="'my-6'" :name="'Register'" :btnClick="()=>helperTo('/register')" />
                <p class="text-center text-gray-500 text-xs mt-6">
                    &copy; 2021 TO-DO
                </p>
          
        <AlertButton  />
        </form>
    </main>
</template>

<script>
import TitleTodo from "../component/TitleTodo.vue";
import ButtonTodo from "../component/ButtonTodo.vue";
import InputTodo from "../component/InputTodo.vue";
import AlertButton from "../component/AlertBlock.vue";

import { kHeader } from "./../../constant";
export default {
    components: {
        TitleTodo,
        ButtonTodo,
        InputTodo,
        AlertButton,
    },
    name: "LoginTodo",
    data() {
        return {
            messageObject:{},
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
        // alertMessageCallback:  () => () => {

        // },
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
