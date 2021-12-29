<template>
    <div>
        <Navbar></Navbar>
        <main class="w-11/12 bg-white mx-auto my-5 py-3 px-4 rounded">
            <div class="flex flex-wrap -mx-3 mb-6">
                         <h1
                    class="text-center text-3xl w-full p-3 mb-6 mx-3"
                    style="right: 6px"
                >
                    Edit
                </h1>

                <div
                    class="w-full p-3 mb-6 mx-3 text-red-500 border border-red-500"
                >
                    <h5>Errors :</h5>
                    <p class="text-md italic">*Please fill out title</p>
                    <p class="text-md italic">*Please fill out Description</p>
                </div>

                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="grid-first-name"
                    >
                        Title
                    </label>
                    <input
                        v-model="title"
                        class="appearance-none block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="grid-first-name"
                        type="text"
                        placeholder="to-do"
                    />
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <label
                    class="w-full md:w-1/2 px-3 block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                    for="grid-last-name"
                >
                    Description
                </label>
                <textarea
                    v-model="description"
                    class="form-control block w-full mx-3 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    id="exampleFormControlTextarea1"
                    rows="3"
                    placeholder="Your description"
                ></textarea>
            </div>
            <div class="flex flex-wrap -mx-3 mb-2">
                <div class="w-full px-3 py-5">
                    <label
                        class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="grid-last-name"
                    >
                        Toggle Reminder
                    </label>
                    <div class="relative">
                        <input
                            type="checkbox"
                            class="m-1"
                            @change="numberedToggleReminder"
                        />
                    </div>
                </div>

                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                    <label
                        class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="grid-city"
                    >
                        Date
                    </label>
                    <input
                        v-model="date"
                        :disabled="toggle_reminder == 0 ? true : false"
                        class="appearance-none block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-city"
                        type="date"
                        placeholder="Albuquerque"
                    />
                </div>
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                    <label
                        class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="grid-state"
                    >
                        24 Hours
                    </label>
                    <div class="relative">
                        <input
                            v-model="hours"
                            :disabled="
                                toggle_reminder == 0 || date == ''
                                    ? true
                                    : false
                            "
                            class="appearance-none block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 focus:outline-none focus:bg-white focus:border-gray-500"
                            id="grid-city"
                            type="number"
                            max="24"
                            min="0"
                            placeholder="0"
                        />
                        <!-- <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div> -->
                    </div>
                </div>
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                    <label
                        class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="grid-zip"
                    >
                        Minutes
                    </label>
                    <input
                        v-model="minutes"
                        :disabled="
                            toggle_reminder == 0 || date == '' ? true : false
                        "
                        class="appearance-none block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-city"
                        type="number"
                        max="60"
                        min="0"
                        placeholder="0"
                    />
                </div>
                <div class="flex w-full flex-col-reverse md:flex-row mx-3">
                    <button
                        @click="helperTo('/display')"
                        class="my-5 px-3 py-1 mx-2 bg-cyan-500 rounded text-white w-full md:w-6/12 bold text-xl"
                    >
                        Back
                    </button>

                    <button
                        @click="serviceUpdate"
                        class="md:my-5 mx-2 px-3 py-1 bg-teal-500 rounded text-white w-full md:w-6/12 bold text-xl"
                    >
                        Edit
                    </button>
                    <!-- <button
                        @click="validateDate()"
                        class="md:my-5 my-5 mx-2 px-3 py-1 bg-teal-500 rounded text-white w-full md:w-6/12 bold text-xl"
                    >
                        xx
                    </button> -->
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import { kHeader } from "../../constant";
import Navbar from "./Navbar.vue";
import moment from "moment";

export default {
    components: {
        Navbar,
    },
    data() {
        return {
            title: "",
            description: "",
            date: "",
            hours: 0,
            minutes: 0,
            toggle_reminder: 0,
            token: "",
        };
    },
    computed: {
        dateFormat() {
            return `${this.date} ${this.hours}:${this.minutes}`;
        },
    },
    mounted() {
        const accessToken = localStorage.getItem("access_token");
        if (accessToken == null) this.$router.push({path:'/'});

        this.token = accessToken;
        // $route.params.id <- to get the params
        //    $route.query.id <- to get query
        // this.$router.history.current.query.logoutMessage
        console.log(
            this.$router.history.current.query,
            this.$router.history.current.params,
            " -- pparaam|qq"
        );
    },
    methods: {
        numberedToggleReminder(event) {
            // console.log(event.target.checked, "cc");
            if (event.target.checked == false) {
                this.date = "";
                this.minutes = 0;
                this.hours = 0;
            }
            this.toggle_reminder = event.target.checked == true ? 1 : 0;
        },
        validateDate(){
            if(this.toggle_reminder != 1){
                return ""
            }
            const dateformat = `${this.date} ${this.hours}:${this.minutes}`
            let date = moment(dateformat)
            let check = date.isValid()
            const result = !check ? "" : date
            // console.log(check,"-result: ",result)
            return result

        },
        serviceUpdate() {
            const thisVue = this;
            const id = thisVue.$router.history.current.query.id;
            fetch(`/api/todos/${id}`, {
                method: "put",
                headers: { ...kHeader, Authorization: this.token },
                body: JSON.stringify({
                    title: this.title,
                    description: this.description,
                    date: this.validateDate(),
                    toggle_reminder: this.toggle_reminder,
                }),
            }).then(async (rawContent) => {
                if (rawContent.status === 200) {
                    const content = await rawContent.json();
                    console.log(content);
                    if (content.message_status === "SUCCESS")
                        thisVue.$router.push({ path: "/" + content.to });
                }
            });
        },
    },
};
</script>
