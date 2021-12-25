<template>
 <div class="w-full max-w-xs mx-auto">
  <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    <h1 class="text-center text-3xl text-bold mb-5 flex justify-center" ><img :src="getSvgRegister()" class="relative top-1" style="width:30px" /> <span>Register</span> </h1>
    <div class="mb-6">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
        Name
      </label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name="name" id="name" type="text" placeholder="Bobby Baggins" >
      <p class="text-red-500 text-xs italic hidden">Please choose a username.</p>
    </div>
    <div class="mb-6">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
        Username
      </label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name="username" id="username" type="text" placeholder="Bob64" >
      <p class="text-red-500 text-xs italic hidden">Please choose a username.</p>
    </div>
    <div class="mb-6">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
        Email
      </label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name="email" id="email" type="text" placeholder="just@bob.com" >
      <p class="text-red-500 text-xs italic hidden">Please choose a username.</p>
    </div>
    <div class="mb-6">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
        Phone
      </label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name="phone" id="phone" type="text" placeholder="6013456789" >
      <p class="text-red-500 text-xs italic hidden">Please choose a phone.</p>
    </div>
    <div class="mb-6">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="password" >
        Password
      </label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" name="password" id="password" type="password" placeholder="**********">
      <p class="text-red-500 text-xs italic hidden">Please choose a password.</p>
    </div>
    <div class="mb-6" >
    <button class="w-full bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center" type="button"  >
        Register
    </button>
    </div>
    <div>
    <button @click="helperTo('/')" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center" type="button"  >
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

export default {
  name:"RegisterTodo",
  methods:{
      getSvgRegister(){
          return "images/register.svg";
      }
  }
}
</script>
<style>

</style>