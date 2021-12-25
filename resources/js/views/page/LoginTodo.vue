<template>
 <main class="w-full max-w-xs mx-auto">
  <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 mx-auto">
    <h1 class="text-center text-3xl text-bold mb-5 flex justify-center relative" style="right:6px" > <img :src="getSvgLock()" class="relative" style="width:40px" /> <span>Login</span> </h1>
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
        email/username
      </label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="email/username">
    </div>
    <div class="mb-6">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
        password
      </label>
      <!--  border-red-500 -->
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="**********">
      <p class="text-red-500 text-xs italic hidden">Please choose a password.</p>
    </div>
    <div class="mb-6">
      <button @click="helperTo('/display')" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center" type="button"  >
        Log In
      </button>
    </div>
    <div>
      <button @click="helperTo('/register')" class="w-full bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center" type="button"  >
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
export default {
  name:"LoginTodo",
  mounted(){
  //  console.log(this.router,this.$router);
    const router = this.$router;
    function extractRouteName(url_string_) {
      var rx = /\/([\w-]+)#/g;
      var arr = rx.exec(url_string_);
      router.push({ path: arr[1]});
  }
   extractRouteName(window.location.href);
  },

  methods:{
      getSvgLock(){
          return "images/lock.svg";
      }
  }
}
</script>

<style>

</style>