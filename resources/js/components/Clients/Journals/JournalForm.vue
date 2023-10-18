<template>
    <div class="container">
        <div class=" bg-white p-10">
            <div class="flex items-center mb-4">
                <div class="relative w-6 h-6 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                    <svg class="absolute w-8 h-8 text-gray-400 -left-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                </div>
                <div class="ml-2 text-large text-xl">
                    {{current_client.name}}
                </div>
            </div>
            <div class="mb-6">
                <textarea v-model="journalText" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your journal here ..."></textarea>
                <span v-if="!isValidJournalText && formSubmitted">Journal text is required.</span>
            </div>
            <button @click="journalSubmitted" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </div>
    </div>
</template>

<script>

export default ({
    name: "JournalForm",
    props:[
        'current_client'
    ],
    data(){
        return{
            formSubmitted: false,
            journalText: ''
        }
    },
    methods:{
        journalSubmitted(){
            this.formSubmitted = true;
            const journal = {
                content: this.journalText,
                date: new Date(),
                client_id: this.current_client.id
            }
            if(this.isValidJournalText){
                axios.post('/journals', journal)
                    .then(res => {
                        window.location.href = '/clients/' + this.current_client.id;
                        console.log(res)
                    })
            }
        }
    },
    computed:{
        isValidJournalText() {
            return this.journalText.trim() !== "";
        },
    }
})
</script>

<style scoped>

</style>
