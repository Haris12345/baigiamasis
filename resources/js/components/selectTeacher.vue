<template>
    <div>
        <form class="form-horizontal" action="/teachers/subjects" method="post">
            <div class="row">
                <div class="col">
                    <select>
                        <option>{{name}} {{last_name}}</option>
                    </select>
                    <button type="button" class="btn btn-sm btn-success" @click="assign">Priskirti</button>
                </div>
            </div>
        </form>    
    </div>
</template>

<script>
    export default {
        props: ['group'],
        data(){
            return{
                teachers,
               name,
               last_name,
            }
        },
        methods: {
            assign(){
                axios.post("/teachers/subjects")
                .then(response => {
                    var teacher = response.data
                    this.name = teacher.name
                    this.last_name = teacher.last_name
                });
            }
        },
        mounted(){
            axios.post("/teachers/subjects/get")
            .then(response => {
                var teachers = response.data
                this.name = teachers.name
                this.last_name = teachers.last_name
            });
        }
    }
</script>