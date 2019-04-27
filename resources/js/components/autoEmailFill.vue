<template>
    <div>
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">Vardas</label>

            <div class="col-md-6">
                <input v-model="name" id="name" type="text" class="form-control" name="name" required autofocus>
            </div>
        </div>

        <div class="form-group row">
            <label for="last_name" class="col-md-4 col-form-label text-md-right">Pavardė</label>

            <div class="col-md-6">
                <input v-model="last_name" id="last_name" type="text" class="form-control" name="last_name" required autofocus>
            </div>
        </div>
        
        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">El. paštas</label>

            <div class="col-md-6">
                <input v-model="email" id="email" type="email" class="form-control" name="email" required autofocus>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                name: '',
                last_name: '',
                email: '@stud.akolegija.lt'
            }
        },
        computed: {
            email: function(){
                this.email = this.name+'.'+this.last_name+this.email
            }
           
        }
    }
</script>