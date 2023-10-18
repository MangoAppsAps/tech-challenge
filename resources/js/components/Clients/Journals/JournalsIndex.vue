<template>
    <div class="bg-white container p-4">
        <div class="fixed right-6 bottom-6 group">
            <button @click="addJournal" type="button" data-dial-toggle="speed-dial-menu-default" aria-controls="speed-dial-menu-default" aria-expanded="false" class="flex items-center justify-center text-white bg-blue-700 rounded-full w-14 h-14 hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:focus:ring-blue-800">
                <svg class="w-5 h-5 transition-transform group-hover:rotate-45" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                </svg>
            </button>
        </div>
        <div>
            <div v-if="client.journals && client.journals.length > 0">
                <div v-for="journal in client.journals">
                    <div class="block p-3 mb-2 border border-ep-border-color rounded-md">
                        <div class="flex justify-between">
                            <div class="text-xl text-gray-700 mb-1">
                                {{journal.date}}
                            </div>
                            <div>
                                <button @click="deleteJournal(journal.id)" class="bg-red-500 text-white rounded-full p-2 hover:bg-red-600">
                                    <svg class="w-3 h-3 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="text-gray-600 w-11/12">{{journal.content}}</div>
                    </div>
                </div>
            </div>
            <div v-else><strong>{{client.name}}</strong> has currently no journals.</div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default ({
    name: "JournalsIndex",
    props:[
        'client'
    ],
    data(){
        return{
            showMenu: false
        }
    },
    methods:{
        addJournal(){
            window.location.href = `/journals/create/${this.client.id}`;
        },
        deleteJournal(journalId){
            axios.delete(`/journals/${this.client.id}/${journalId}`).then(res => {
                this.$emit('setNewLocalClient', res.data)
            })
        }
    }
})
</script>

<style scoped>
a{
    text-decoration: none;
    color: grey;
}
</style>
