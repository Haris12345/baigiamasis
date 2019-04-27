<template>
    <div class="col">
        <div class="form-group row">
            <label for="studies_program" class="col-md-4 col-form-label text-md-right">Studijų programa</label>

            <div class="col-md-6">
                <input v-model="studies_program" id="studies_program" type="text" class="form-control" name="studies_program" required autofocus>
            </div>
        </div>

        <div class="form-group row">
            <label for="studies_program_code" class="col-md-4 col-form-label text-md-right">Studijų programos kodas</label>

            <div class="col-md-6">
                <input v-model="studies_program_code" id="studies_program_code" type="text" class="form-control" name="studies_program_code" required autofocus>
            </div>
        </div>

        <div class="form-group row">
            <label for="studies_program_code_abrv" class="col-md-4 col-form-label text-md-right">Studijų programos trumpinys</label>

            <div class="col-md-6">
                <input v-model="studies_program_abrv" id="studies_program_code_abrv" type="text" class="form-control" name="studies_program_code_abrv" required autofocus>
            </div>
        </div>

        <div class="form-group row">
            <label for="studies_form" class="col-md-4 col-form-label text-md-right">Studijų forma</label>

            <div class="col-md-6">
                <select v-model="studies_form" class="form-control" name="studies_form">
                    <option>Nuolatinė</option>
                    <option>Ištestinė</option>
                </select>
            </div>
        </div>
        <div class="card mb-3"  v-for="(subject, index) in subjects">
            <div class="card-body">
                <span class="float-right" style="cursor:pointer" @click="deleteCard(index)">
                    X
                </span>
                <br>
                <div class="form-group row" >
                    <label for="subject_name" class="col-md-4 col-form-label text-md-right">Dalyko pavadinimas</label>

                    <div class="col-md-6">
                        <input v-model="subject.name" id="subject_name" type="text" class="form-control" name="subject_name[]" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="subject_status" class="col-md-4 col-form-label text-md-right">Dalyko tipas (trumpinys)</label>

                    <div  class="col-md-6">
                        <input v-model="subject.type" id="subject_status" type="text" class="form-control" name="subject_status[]" required autofocus>
                    </div>
                </div>
                <div class="form-group row" v-for="(id, index) in subject.semesters">
                    <label for="semester" class="col-md-4 col-form-label text-md-right">Semestras</label>
                    <div class="col-md-6">
                        <input type="hidden" name="id[]" :value="index">
                        <input v-model="id.semester" id="semester" type="text" class="form-control" name="semester[]" required autofocus>
                    </div>
                    <br></br>

                    <label for="semester" class="col-md-4 col-form-label text-md-right">Kreditų skaičius</label>
                    <div class="col-md-6">
                        <input v-model="id.credits" id="credits" type="text" class="form-control" name="credits[]" required autofocus>
                    </div>
                    <br></br>
    
                    <label for="semester" class="col-md-4 col-form-label text-md-right">Vertinimo forma (trumpinys)</label>
                    <div class="col-md-6">
                        <input v-model="id.evaluation_type" id="evaluation_type" type="text" class="form-control" name="evaluation_type[]" required autofocus>
                    </div>   
                </div>
                
                <span class="float-right">
                    <button type="button" name="add_semester" @click="addSemester(index)" class="btn btn-sm btn-success">Pridėti semestrą</button>
                </span> 
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="button" name="add_subject" @click="addSubject()" class="btn btn-success">Pridėti dalyką</button>
            </div>
        </div>
        <br/>
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Įkelti</button>   
            </div>
        </div>           
    </div>                   
</template>

<script>
    export default {
        data(){
            return{
                studies_program: '',
                studies_program_code: '',
                studies_program_abrv: '',
                studies_form: '',
                subjects: [{
                    name: '',
                    type: '',
                    semesters: [{
                        semester: '',
                        credits: '',
                        evaluation_type: ''
                    }] 
                }]
            }
        },
        methods: {
            addSubject(){
               this.subjects.push({
                    name: '',
                    type: '',
                    semesters: [{
                        semester: '',
                        credits: '',
                        evaluation_type: ''
                    }] 
               })
            },
            addSemester(index){
                this.subjects[index].semesters.push({
                    semester: '',
                    credits: '',
                    evaluation_type: ''
                })
                console.log(index)
            },
            deleteCard(index){
                this.subjects.splice(index, 1);
            }
        }
        
    }
</script>