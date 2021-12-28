<template>
    <div class="w-full max-w-xs mx-auto">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h1 class="text-center text-3xl text-bold mb-5 flex justify-center">
                <img
                    :src="getSvgRegister()"
                    class="relative top-1"
                    style="width: 30px"
                />
                <span>Register</span>
            </h1>
            <div class="mb-6">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="name"
                >
                    Name
                </label>
                <input
                    v-model="name"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    name="name"
                    id="name"
                    type="text"
                    placeholder="Bobby Baggins"
                />
                <p class="text-red-500 text-xs italic">
                   {{nameError}}
                </p>
            </div>
            <div class="mb-6">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="username"
                >
                    Username
                </label>
                <input
                    v-model="username"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    name="username"
                    id="username"
                    type="text"
                    placeholder="Bob64"
                />
                <p class="text-red-500 text-xs italic ">
                     {{usernameError}}
                </p>
            </div>
            <div class="mb-6">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="email"
                >
                    Email
                </label>
                <input
                    v-model="email"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    name="email"
                    id="email"
                    type="text"
                    placeholder="just@bob.com"
                />
                <p class="text-red-500 text-xs italic">
                     {{emailError}}
                </p>
            </div>
            <div class="mb-6">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="phone"
                >
                    Phone
                </label>
                <input
                    v-model="phone"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    name="phone"
                    id="phone"
                    type="text"
                    placeholder="6013456789"
                />
                <p class="text-red-500 text-xs italic">
                    {{phoneError}}
                </p>
            </div>
            <div class="mb-6">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="password"
                >
                    Password
                </label>
                <input
                    v-model="password"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    name="password"
                    id="password"
                    type="password"
                    placeholder="**********"
                />
                <p class="text-red-500 text-xs italic">
                    {{passwordError}}
                </p>
            </div>
            <div class="mb-6">
                <button
                    @click="serviceRegister()"
                    :disabled="registerDisabled"
                    :class="
                        registerDisabled
                            ? 'bg-purple-100'
                            : 'bg-purple-500 hover:bg-purple-700'
                    "
                    
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center"
                    type="button"
                >
                    Register
                </button>
            </div>
            <div>
                <button
                    @click="helperTo('/')"
                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center"
                    type="button"
                >
                    Login
                </button>
                <p class="text-center text-gray-500 text-xs mt-6">
                    &copy; 2021 TO-DO
                </p>
            </div>
        </form>
    </div>
</template>
<script>
import { kHeader } from "../../constant";

export default {
    name: "RegisterTodo",
    data() {
        return {
            registerDisabled: false,
            name: "jason",
            nameError: "",
            username: "jason94",
            usernameError:"",
            email: "jason@json.com",
            emailError: "",
            phone: "1234567890",
            phoneError: "",
            password: "pass12345",
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
