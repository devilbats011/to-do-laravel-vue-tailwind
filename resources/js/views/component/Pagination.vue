<template>
    <div
        class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6"
    >
        <div class="sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div class="py-3">
                <p class="text-sm text-gray-700">
                    total :
                    <span class="font-medium">{{totalPage}}</span>
                    to-do list
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px py-3" aria-label="Pagination" >
                  
                    <button class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium  "
                            :class="pageDetails.prev_page_url === null ? 'text-gray-200 pointer-events-none cursor-default':'text-gray-500 hover:bg-gray-200'" 
                            @click="changePage($event,1)"
                    >
                      <span class="sr-only">Previous</span>
                        <!-- Heroicon name: solid/chevron-left -->
                        <svg                        
                            class="h-5 w-5"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <button
                        href="#page"
                        aria-current="page"
                        v-for="(obj, index) in pageDetails.last_page"
                        :key="index"
                        :data-number="index+1"
                        class="z-10 text-slate-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                        :class="[(index+1 === pageDetails.current_page ? active : '')]"
                        @click="changePage($event,index+1)"

                    >
                        {{index+1}}
                    </button>

                    <a
                        href="#page"
                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                        :class="pageDetails.next_page_url === null ? 'text-gray-200 pointer-events-none cursor-default':'text-gray-500 hover:bg-gray-200'" 
                        @click="changePage($event,pageDetails.last_page)"
                    >
                        <span class="sr-only">Next</span>
                        <!-- Heroicon name: solid/chevron-right -->
                        <svg
                            class="h-5 w-5"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </a>
                </nav>
               
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["totalPage","pageDetails"],
    data() {
        return {
          active: 'bg-indigo-50 border-indigo-500 text-indigo-600',
        };
    },
    methods:{
      changePage(event,index){
        // console.log(event,index,"event-index")
        this.$emit('changePageEmit',index)
      }
    },
};
</script>

<style></style>
