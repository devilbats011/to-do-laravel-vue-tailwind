<template>
    <div>
        <Navbar></Navbar>
        <main class="w-11/12 bg-white mx-auto my-5 py-3 px-4 rounded">
            <div class="flex flex-wrap -mx-3 mb-6">
                <h1
                    class="text-center text-3xl w-full p-3 mb-6 mx-3"
                    style="right: 6px"
                >
                    Create
                </h1>
                <div
                    class="w-full p-3 mb-6 mx-3 text-red-500 border border-red-500"
                    v-if="errorToggle == true"
                >
                    <h5>Errors :</h5>
                    <p class="text-md italic" v-if="titleError !== ''">
                        *title : {{ titleError }}
                    </p>
                    <p class="text-md italic" v-if="descriptionError !== ''">
                        *Description : {{ descriptionError }}
                    </p>
                    <p class="text-md italic" v-if="messageError !== ''">
                        *Mesage : {{ messageError }}
                    </p>
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
                            :disabled="toggle_reminder == 0 ? true : false"
                            class="appearance-none block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 focus:outline-none focus:bg-white focus:border-gray-500"
                            id="grid-city"
                            type="number"
                            max="24"
                            min="0"
                            placeholder="0"
                        />
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
                        :disabled="toggle_reminder == 0 ? true : false"
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
                        @click="serviceStore"
                        class="md:my-5 mx-2 px-3 py-1 bg-teal-500 rounded text-white w-full md:w-6/12 bold text-xl"
                        :class="
                            btnDisabled
                                ? 'bg-teal-200'
                                : 'bg-teal-500 hover:bg-teal-700'
                        "
                    >
                        + Add To Do
                    </button>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import { kHeader } from "../../constant";
import Navbar from "../component/Navbar.vue";
import  {checkCreate} from '../../services/api';

var moment = require("moment-timezone");

export default {
    components: {
        Navbar,
    },
    mounted() {
        const accessToken = localStorage.getItem("access_token");
        this.token = accessToken;
        if (accessToken == null) this.$router.push({ path: "/" });

        checkCreate(this,'create');

        // console.log(
        //     this.$router.history.current.query,
        // );
    },
    data() {
        return {
            title: "",
            description: "",
            date: "",
            hours: "",
            minutes: "",
            finalDate: "",
            toggle_reminder: 0,
            token: "",
            errorToggle: false,
            titleError: "",
            descriptionError: "",
            messageError: "",
            btnDisabled: false,
        };
    },
    computed: {
        dateFormat() {
            this.finalDate = `${this.date} ${this.hours}:${this.minutes}`;
            return `${this.date} ${this.hours}:${this.minutes}`;
        },
    },
    methods: {
        numberedToggleReminder(event) {
            this.toggle_reminder = event.target.checked == true ? 1 : 0;
        },
        validateDate() {
            if (this.toggle_reminder != 1) {
                return "";
            }
            const dateformat = `${this.date} ${this.hours}:${this.minutes}`;
            let date = moment.tz(dateformat, "Asia/Kuala_Lumpur");
            let check = date.isValid();
            console.log(check);
            return !check ? "" : date.format();
        },
        clearErrors() {
            this.errorToggle = false;
            this.titleError = "";
            this.descriptionError = "";
            this.messageError = "";
        },
        handleMilestones(milestones,to){
            if(milestones.notficition_status == "unread" ){
                const message = `Congartulation 🎉!  You have reached ${milestones.achievements} achievements and received ${milestones.badge_name} Badge~! ` ;
                this.$router.push({ path: "/" + to ,query:{alertMessage: message} });
                fetch(`/api/set-read/${milestones.badge_id}`,{
                    method: "get",
                    headers: { ...kHeader, Authorization: this.token }
                })

                return true;
            }
            else return false;

        },
        serviceStore() {
            this.clearErrors();
            this.btnDisabled = true;
            const thisVue = this;
            // const id = thisVue.$router.history.current.query.id;
            fetch(`/api/todos`, {
                method: "post",
                headers: { ...kHeader, Authorization: this.token },
                body: JSON.stringify({
                    title: this.title,
                    description: this.description,
                    date: this.validateDate(),
                    toggle_reminder: this.toggle_reminder,
                }),
            })
                .then(async (rawContent) => {
                    const content = await rawContent.json();
                    if (rawContent.status === 200) {
                        // console.log(content);
                        if (content.message_status === "SUCCESS") {
                            const isMilestone = this.handleMilestones(content.milestones, content.to)
                            if(!isMilestone) valthisVue.$router.push({ path: "/" + content.to,query:{alertMessage:content.message} });
                        }
                    } else if (rawContent.status == 403) {
                        // console.log("403-", content);
                        thisVue.$router.push({ path: "/" + content.to });
                    } else if (rawContent.status == 422) {
                        // console.log("422-", content);
                        thisVue.messageError = content.message;
                        for (var key in content.errors) {
                            thisVue[`${key}Error`] = content.errors[key][0];
                        }
                        thisVue.errorToggle = true;
                    }
                })
                .catch((err) => {
                    console.error(err);
                })
                .finally(() => (thisVue.btnDisabled = false));
        },
    },
};
</script>
