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
                        <tr v-for="(item, index) in toDos" :key="index">
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.title }}</td>
                            <td>{{ item.description }}</td>
                            <td>
                                {{
                                    item.toggle_reminder === 1 &&
                                    item.date != null
                                        ? moment(item.date)
                                        : "No Reminder|no date"
                                }}
                            </td>
                            <td>
                                <button
                                    class="bg-slate-500 py-1 px-3 rounded text-white"
                                    :data-id="item.id"
                                    @click="serviceEdit"
                                >
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
                    class="bg-emerald-500 p-2 rounded text-white mx-auto w-3/12 bold text-xl"
                >
                    + Add
                </button>
            </div>
            <!--    -->
            <Pagination
                v-on:changePageEmit="onChangePage"
                :totalPage="totalPage"
                :pageDetails="pageDetails"
            ></Pagination>
            <AlertBlock />
        </main>
    </div>
</template>

<script>
import moment from "moment";
import { kHeader } from "../../constant";
import Navbar from "../component/Navbar.vue";
import Pagination from "./../component/Pagination.vue";
import AlertBlock from "./../component/AlertBlock.vue";
import  {checkCreate} from '../../services/api';

export default {
    components: {
        Navbar,
        Pagination,
        AlertBlock,
    },
    mounted() {
        const accessToken = localStorage.getItem("access_token");
        if (accessToken == null) this.$router.push({ path: "/" });

        this.vueHeader = { ...kHeader, Authorization: accessToken };
        this.paginate(1);
    },
    data() {
        return {
            isLoading: true,
            errorMessage: "",
            toDos: [],
            pageDetails: {},
            currentPage: 1,
            vueHeader: {},
            totalPage: 0,
        };
    },
    methods: {
        moment(date) {
            return moment(date).format("LLLL");
        },
        paginate(page) {
            fetch(`/api/todos?page=${page}`, {
                method: "get",
                headers: this.vueHeader,
            })
                .then(async (rawResponse) => {
                    const content = await rawResponse.json();
                    if (rawResponse.status === 200) {
                        this.pageDetails = content.data;
                        this.toDos = content.data.data;
                        this.totalPage = content.data.total;
                    } else {
                        if (
                            (content.message !== null) |
                            (content.message !== undefined)
                        )
                            this.$router.push({ path: "/" });
                    }
                })
                .catch((err) => {
                    this.errorMessage = content.message;
                    console.warn("caught error");
                    console.error(err);
                });
        },
        serviceCreate() {
            checkCreate(this);
        },
        serviceDelete(event) {
            const id = event.target.getAttribute("data-id");
            fetch(`/api/todos/${id}`, {
                method: "delete",
                headers: this.vueHeader,
            })
                .then(async (rawContent) => {
                    const content = await rawContent.json();

                    if (rawContent.status == 200) {
                        const tempArray = this.toDos;
                        const newToDos = tempArray.filter(function (item) {
                            return item.id != id;
                        });
                        this.toDos = newToDos;
                        this.totalPage = this.totalPage - 1;
                        this.paginate(this.currentPage);
                        // this.$router.push({ path: "/display",query:{alertMessage:content.message}});
                        
                    } else if (rawContent.status == 403) {
                        console.log("del-403-", content);
                    }
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        serviceEdit(event) {
            const id = event.target.getAttribute("data-id");
            const tempArray = this.toDos;

            tempArray.map((todo) => {
                if (todo.id == id) {
                    this.$router.push({
                        path: "/edit",
                        query: {
                            id: todo.id,
                            title: todo.title,
                            description: todo.description,
                        },
                    });
                    return null;
                }
            });
        },
        onChangePage(page) {
            this.currentPage = page;
            this.paginate(page);
        },
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
