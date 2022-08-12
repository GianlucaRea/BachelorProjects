<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Document Component</div>
                    <input v-model="newDoc.docUserId" placeholder="Proprietario">
                    <input v-model="newDoc.docTitle" placeholder="Titolo">
                    <input v-model="newDoc.docUniversity" placeholder="Università">
                    <input v-model="newDoc.docCourse" placeholder="Corso di laurea">
                    <input v-model="newDoc.docSubject" placeholder="Materia">
                    <button  v-on:click="say">ADD</button>
                    <hr>
                    <div class="card-body">
                        Documents <br>
                        <ul id="documents">
                            <li v-for="doc in docs">
                                {{ doc.title }} - {{ doc.university }} - {{ doc.course }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            axios.get('http://localhost/QuacktheDuck/Project/public/api/documents').then( response => (this.docs = response.data ) )
        },

        data() {
            return {
                docs: [],

                newDoc: {
                    'docUserId': '',
                    'docTitle': '',
                    'docUniversity': '',
                    'docCourse': '',
                    'docSubject': '',
                }
            }
        },

        methods: {
            say: function (event) {
                if (event) {
                    axios.post('http://localhost/QuacktheDuck/Project/public/api/documents', {
                        id_user_document: this.newDoc.docUserId,
                        title: this.newDoc.docTitle,
                        university: this.newDoc.docUniversity,
                        course: this.newDoc.docCourse,
                        subject: this.newDoc.docSubject,

                    })
                    .then(function (response) {
                        alert("Documento creato con successo!")
                    })
                    .catch(function (error) {
                        alert("Impossibile creare il documento!")
                    });
                }
            }
        }
    }
</script>
