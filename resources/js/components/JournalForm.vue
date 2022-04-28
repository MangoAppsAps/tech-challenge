<template>
    <div>
        <h1 class="mb-6">Clients -> Add Journal</h1>
        <div class="alert alert-danger" role="alert" v-for="error in errors">
            {{error }}
        </div>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="text">Name</label>
                <input type="text" id="text" class="form-control" v-model="form.text">
            </div>
            <div class="form-group">
                <label for="date">Email</label>
                <input type="date" id="date" class="form-control" v-model="form.date">
            </div>


            <div class="text-right">
                <a :href="'/clients/'+this.clientId" class="btn btn-default">Cancel</a>
                <button @click="storeJournal" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "JournalForm",
    props:['clientId'],
    data()
    {
        return{
            form:{
                date:'',
                text:'',

            },
            errors:[]
        }
    },
    methods:{
        storeJournal()
        {
            axios.post('/clients/'+this.clientId+'/journal',this.form).then(()=>{
                window.location.href = '/clients/'+this.clientId;

            }).catch(e=>{
                this.errors=e.response.data.errors;
            });

        }
    }
}
</script>

<style scoped>

</style>
