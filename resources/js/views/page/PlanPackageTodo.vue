<template>
    <main>
        <Navbar></Navbar>
        <div v-if="user_type != 'premium_user' ">
            <section class="max-w-sm w-full lg:max-w-full mx-auto my-5" >
                <div class="flex justify-center relative h-auto">
                    <div
                        class="lg:w-60 flex-none rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                        style="
                            background-image: url('https://pbs.twimg.com/media/EPTFQaMWoAQoKk1.jpg');
                            background-size: 100% 100%;
                            height: 260px;
                        "
                        title="good cat"
                    ></div>
                    <div
                        class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal"
                    >
                        <div class="mb-4">
                            <p class="text-sm text-gray-900 flex items-center">
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
                            <h3 class="text-gray-500 font-bold text-xl mt-2">
                                One Month Premium Membership
                            </h3>
                            <h3 class="text-gray-500 font-bold text-xl mb-4">
                                Price: MYR 32.99
                            </h3>
                            <p
                                class="text-gray-700 text-md pr-16 mb-4"
                                style="max-width: 600px"
                            >
                                Benefit, Goodies, Free-Gift, consectetur adipisicing
                                elit. Voluptatibus quia, nulla! Maiores praesentium
                                Voluptatibus!
                            </p>
                            <button
                            @click="serviceGoPremium()"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full lg:w-64"
                            >
                                Select
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <section class="max-w-sm w-full lg:max-w-full mx-auto my-5">
                <div class="flex justify-center relative h-auto">
                    <div
                        class="lg:w-60 flex-none rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                        style="
                            background-image: url('https://s.keepmeme.com/files/en_posts/20200819/f9f6f589f3bc55abf4a23d8bb4a621af2-cats-with-thumbs-up-sign-like.jpg');
                            background-size: 100% 100%;
                            height: 260px;
                        "
                        title="two good cat"
                    ></div>
                    <div
                        class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal"
                    >
                        <div class="mb-4">
                            <p class="text-sm text-gray-900 flex items-center">
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
                            <h3 class="text-gray-500 font-bold text-xl mt-2">
                                Three Month Premium Membership
                            </h3>
                            <h3 class="text-gray-500 font-bold text-xl mb-4">
                                Price: MYR 62.99
                            </h3>
                            <p
                                class="text-gray-700 text-md pr-16 mb-4"
                                style="max-width: 600px"
                            >
                                Benefit, Goodies, Free-Gift, consectetur adipisicing
                                elit. Voluptatibus quia, nulla! Maiores praesentium
                                Voluptatibus!
                            </p>
                            <button @click="serviceGoPremium()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full lg:w-64" >
                                Select
                            </button>
                        </div>
                    </div>
                </div>
            </section>

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
                            <p class="text-sm text-orange-400 flex items-center">
                                <svg
                                    class="fill-current text-orange-400 w-3 h-3 mr-2"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M4 8V6a6 6 0 1 1 12 0v2h1a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h1zm5 6.73V17h2v-2.27a2 2 0 1 0-2 0zM7 6v2h6V6a3 3 0 0 0-6 0z"
                                    />
                                </svg>
                                Premium Membership
                            </p>
                            <h3 class="text-orange-400 font-bold text-xl mt-2">
                                One Year Premium Membership!
                            </h3>
                            <h3 class="text-orange-400 font-bold text-xl mb-4">
                                Price: MYR 92.99
                            </h3>
                            <p
                                class="text-md font-bold pr-16 mb-4"
                                style="max-width: 600px"
                            >
                                Benefit, Goodies, Free-Gift, consectetur adipisicing
                                elit. Voluptatibus quia, nulla! Maiores praesentium
                                Voluptatibus!
                            </p>
                            <button
                            @click="serviceGoPremium()"
                                class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded w-full lg:w-64"
                            >
                                Select Now!
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div v-else >
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
                            <h3 class="text-md text-blue-700 flex items-center p-3 ">
                                <svg
                                    class="fill-current text-blue-700 w-3 h-3 mr-2"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M4 8V6a6 6 0 1 1 12 0v2h1a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h1zm5 6.73V17h2v-2.27a2 2 0 1 0-2 0zM7 6v2h6V6a3 3 0 0 0-6 0z"
                                    />
                                </svg>
                               Your Already A  Premium Member
                            </h3>
                            <hr class="border-t-1 border-blue-200" />
                            <div class="text-md text-blue-700 flex items-center p-3 ">
                               <button
                                    @click="$router.go(-1)"
                                    class="bg-gray-500 hover:bg-gray-700 mx-2 px-5 py-2 mt-1 rounded text-white font-bold "
                               >
                                     Go Back 
                               </button>
                            </div>
                        
                       
                    
                        </div>
                    </div>
                </div>
            </section>
      
        </div>
    </main>
</template>

<script>
import { kHeader } from '../../constant';
import { serviceGetUserInfo } from '../../services/api';
import Navbar from "./Navbar.vue";
export default {
    components: {
        Navbar,
    },
    async mounted(){
        const accessToken = localStorage.getItem("access_token");
        if (accessToken == null) this.$router.push({path:'/'});

        const userInfo = await serviceGetUserInfo();
        this.name = userInfo.name;
        this.username = userInfo.username;
        this.user_type = userInfo.user_type;
    },
    data(){
        return {
            name:"",
            username:"",
            user_type:"",
        }
    },
    methods: {
      serviceGoPremium(){
        const thisVue = this
        fetch('/api/go-premium', {
          method: "get",
          headers: {...kHeader,Authorization: localStorage.getItem('access_token')},
        }).then(async(rawResponse)=>{
            const response = await rawResponse.json();
            if(rawResponse.status == 200){
              console.log('premimum-response:', response)
              if(response.message_status == "SUCCESS")
                thisVue.$router.push({path: "/"+response.to})
            }
        }).catch((err)=>{
          console.error(err);
        })
      }
    }
    
};
</script>

<style></style>
