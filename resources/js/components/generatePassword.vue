<template>
    <div>
        <label for="password" class="col-md-6 col-form-label text-md-right">Slaptažodis</label>
        <div class="col-md-12">
            <p>
                <input id="password" type="text" class="form-control" name="password" v-model="password" required autofocus>
            </p>
            
            <button type="button" class="btn btn-success" @click="generate">Generuoti</button>
        </div>
    </div> 
</template>

<script>
    export default {
        data(){
            return{
                password: ""
            }
        },
        methods: {
            generate(){
                axios.post('/admin/studentai/paskyra/generuoti', {
                    password: this.password
                }).then(response => {
                    this.password = response.data
                });        
            }
        }
    }
</script>
