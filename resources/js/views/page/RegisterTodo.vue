<template>
    <div class="w-full max-w-xs mx-auto">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <title-todo  :imgSrc="getSvgRegister" :title="'Register'" :titleStyle="'width: 30px;height:36px;top:.3rem'" />
            <input-todo :rootClass="'mb-6'" :label="'Name'" :inputCallback="(value)=>name=value" :type="'text'" :error="nameError" :placeholder="'Bilbo Baggins'"  />
            <input-todo :rootClass="'mb-6'" :label="'Username'" :inputCallback="(value)=>username=value" :type="'text'" :error="usernameError" :placeholder="'justbob94'" />
            <input-todo :rootClass="'mb-6'" :label="'Email'" :inputCallback="(value)=>email=value" :type="'text'" :error="emailError" :placeholder="'just@bob94.com'" />
            <input-todo :rootClass="'mb-6'" :label="'Phone'" :inputCallback="(value)=>phone=value" :type="'text'" :error="phoneError" :placeholder="'013456789'" />
            <input-todo :rootClass="'mb-6'" :label="'Password'" :inputCallback="(value)=>password=value" :type="'password'" :error="passwordError" :placeholder="'************'" />
            <button-todo :rootClass="'mb-6 mt-6'" :name="'Register'" :btnClick="serviceRegister" :btnDisabled="registerDisabled" color="purple" />
            <button-todo :rootClass="'mb-6 mt-6'" :name="'Login'" :btnClick="()=>helperTo('/')"  />
            <div>
                <p class="text-center text-gray-500 text-xs mt-6">
                    &copy; 2021 TO-DO
                </p>
            </div>
        </form>
    </div>
</template>
<script>
import { kHeader } from "../../constant";
import InputTodo from "../component/InputTodo.vue";
import TitleTodo from "../component/TitleTodo.vue";
import ButtonTodo from "../component/ButtonTodo.vue";

export default {
    components:{
        InputTodo,
        TitleTodo,
        ButtonTodo
    },
    name: "RegisterTodo",
    data() {
        return {
            registerDisabled: false,
            name: "",
            nameError: "",
            username: "",
            usernameError:"",
            email: "",
            emailError: "",
            phone: "",
            phoneError: "",
            password: "",
            passwordError: "",
            arrayErrors:[]
        };
    },
    methods: {
        getSvgRegister() {
            return "images/register.svg";
        },
        clearErrors(){
            this.nameError = ""
            this.usernameError =""
            this.emailError = ""
            this.phoneError = ""
            this.passwordError = ""
        },
        serviceRegister() {
            this.clearErrors();
            const thisVue = this;
            this.registerDisabled = true;
            fetch("api/register", {
                method: "post",
                headers: kHeader,
                body: JSON.stringify({
                    name: this.name,
                    username: this.username,
                    email: this.email,
                    phone: this.phone,
                    password: this.password,
                }),
            })
                .then(async (rawResponse) => {
                    const content = await rawResponse.json();
                    console.log("reg-content:", content,rawResponse);
                    if (rawResponse.status == 200) {
                      if(content.message_status == "SUCCESS")
                        thisVue.$router.push({ path: "/"})
                    }
                    if (rawResponse.status == 422){
                        //validation error
                        console.log("validation");
                        const arrayErrors = content.errors;
                        thisVue.arrayErrors = arrayErrors
                        for (var key  in arrayErrors) {
                           const rawArr = arrayErrors[key];
                           thisVue[key+"Error"] = rawArr[0];
                        }
                    }
                })
                .catch((err) => {
                     console.error(err)
                })
                .finally(() => {thisVue.registerDisabled = false});
        },
    },
};
</script>
<style></style>
