<template>
  <div>
    <Navbar></Navbar>
    <main class="w-11/12 bg-white mx-auto my-5 py-3 px-4 rounded">
      <h1 class="font-bold text-xl text-center text-cyan-700 mt-2 mb-4">
        To-do List
      </h1>
      <div class="overflow-auto">
        <table class="table-auto w-full">
          <thead class="text-center border">
            <tr>
              <th class="text-slate-500">No</th>
              <th class="text-cyan-700">Title</th>
              <th class="text-cyan-700">Description</th>
              <th class="text-yellow-600">Reminder</th>
              <th class="text-slate-500">Edit</th>
              <th class="text-rose-600">Delete</th>
            </tr>
          </thead>
          <tbody class="border">
            <!-- <h1 :if="isLoading === true" > Loading ... </h1> -->
            <tr v-for="(item, index) in toDos" :key="item.created_at">
              <td>{{ index + 1 }}</td>
              <td>{{ item.title }}</td>
              <td>{{ item.description }}</td>
              <td>
                {{ item.toggle_reminder === 1 ? moment(item.date) : "No Reminder" }}
              </td>
              <td>
                <button class="bg-slate-500 py-1 px-3 rounded text-white" :data-id="item.id" @click="serviceEdit" >
                  Edit
                </button>
              </td>
              <td>
                <button
                  @click="serviceDelete"
                  class="bg-rose-500 py-1 px-3 rounded text-white"
                  :data-id="item.id"
                >
                  Del
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="flex justify-center my-3">
        <button
          @click="serviceCreate()"
          class="
            bg-emerald-500
            p-2
            rounded
            text-white
            mx-auto
            w-3/12
            bold
            text-xl
          "
        >
          + Add
        </button>
      </div>
    </main>
  </div>
</template>

<script>
import moment from "moment";
import { kHeader } from "../../constant";
import Navbar from "./Navbar.vue";
export default {
  components: {
    Navbar,
  },
  mounted() {
    const accessToken = localStorage.getItem("access_token");
    if (accessToken == null) this.$router.push({path:'/'});

    const _header = { ...kHeader, Authorization: accessToken };
    this.vueHeader = _header;

    this.isLoading = true;
    fetch(`/api/todos`, {
      method: "get",
      headers: _header,
    })
      .then(async (rawResponse) => {
        const content = await rawResponse.json();
        if (rawResponse.status === 200) {
          console.log(content, rawResponse);

          this.toDos = content.data;
        } else {
          if ((content.message !== null) | (content.message !== undefined))
            this.$router.push({ path: "/" });
        }
      })
      .catch((err) => {
        this.errorMessage = content.message;
        console.warn("caught error");
        console.error(err);
      })
      .finally(() => {
        this.isLoading = false;
      });
  },
  data() {
    return {
      isLoading: true,
      errorMessage: "",
      toDos: [],
      dataOne: "obtained",
      vueHeader: {},
    };
  },
  methods: {
    moment(date) {
      return moment(date).format("LLLL");
    },
    serviceCreate() {
      //log1:this.dataOne not obtained because spell method without 's'
      const thisVue = this;
      // console.log(this.dataOne);
      fetch("/api/todos/create", {
        method: "get",
        headers: this.vueHeader,
      })
        .then(async (rawContent) => {
          const content = await rawContent.json();
          if(rawContent.status == 200){
            const checkTodoCount = content["check-todo-count"];
            let tempString = checkTodoCount.permission;
            if (tempString.toUpperCase() === "DENIED") {
              console.log("xx",content)
              const redirect = checkTodoCount.redirect;
              thisVue.$router.push({ path: "/" + redirect });
              return null;
            }
            const to = checkTodoCount.to;
            thisVue.$router.push({ path: "/" + to });
          }
        })
        .catch((err) => {
          console.error(err);
        });
    },
    serviceDelete(event) {
      const id = event.target.getAttribute("data-id");
      fetch(`/api/todos/${id}`, {
        method: "delete",
        headers: this.vueHeader,
      })
        .then(async (rawContent) => {
          const content = await rawContent.json();
          const tempArray = this.toDos;
          const newToDos = tempArray.filter(function (item) {
            return item.id != id;
          });
          this.toDos = newToDos;
          console.log(content.message);
        })
        .catch((err) => {
          console.error(err);
        });
    },
    serviceEdit(event){
      //should put check with middle later
      this.$router.push({ path: "/edit" , query: { id: `${event.target.getAttribute('data-id')}` } });
      return null;
    }
  },
};
</script>

<style>
td,
th {
  padding: 0.5rem;
  border: 1px solid rgb(199, 198, 198);
}

tr > td:first-of-type,
tr > th:first-of-type,
tr > td:nth-of-type(n + 4) {
  text-align: center;
}
</style>