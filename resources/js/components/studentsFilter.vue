<template>
    <div class="form-control row">
        <label>Semestras</label>
        <select v-on:change="semester">
            <option>Rodyti viską</option>
            <option v-for="semester in 8" :key="semester">{{semester}}</option>
        </select>

        <label>Studijų forma</label>
        <select v-on:change="studiesForm">
            <option>Rodyti viską</option>
            <option>Nuolatinė</option>
            <option>Ištestinė</option>
        </select>
        
        <label>Studijų būsena</label>
        <select v-on:change="status">
            <option>Rodyti viską</option>
            <option>Studijuoja</option>
            <option>Nutrauktos studijos</option>
            <option>Pertrauktos studijos</option>
            <option>Užbaigtos studijos</option>
            <option>Išvykęs į dalines studijas</option>
            <option>Atvykęs dalinėms studijoms</option>
        </select>
    </div>
</template>

<script>
    export default {
        name: "students-filter",
        methods: {
            semester: function(s){
                console.log(s.target.value)
                axios.get('/admin/students', {
                    semester: s.target.value
                });
            },
            studiesForm: function(s){
                 console.log(s.target.value)
                 axios.get('/admin/students', {
                    studies_form: s.target.value
                });
            },
            status: function(s){
                 console.log(s.target.value)
                 axios.get('/admin/students', {
                    status: s.target.value
                });
            }  
        }
    }
</script>