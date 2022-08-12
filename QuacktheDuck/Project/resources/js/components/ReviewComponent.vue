<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Review Component</div>
                    <input v-model="newReview.reviewUserId" placeholder="Recensore">
                    <input v-model="newReview.reviewDocId" placeholder="Documento">
                    <input v-model="newReview.reviewStar" placeholder="Stelle">
                    <button  v-on:click="say">ADD</button>
                    <hr>
                    <div class="card-body">
                        Reviews <br>
                        <ul id="reviews">
                            <li v-for="review in reviews">
                                {{ review.id_review_by_user }} - {{ review.id_document_reviewed }} - {{ review.stars_number }}
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
            axios.get('http://localhost/QuacktheDuck/Project/public/api/reviews').then( response => (this.reviews = response.data ) )
        },

        data() {
            return {
                reviews: [],

                newReview: {
                    'id_review_by_user': '',
                    'id_document_reviewed': '',
                    'stars_number': '',

                }
            }
        },

        methods: {
            say: function (event) {
                if (event) {
                    axios.post('http://localhost/QuacktheDuck/Project/public/api/reviews', {
                        id_review_by_user: this.newReview.reviewUserId,
                        id_document_reviewed: this.newReview.reviewDocId,
                        stars_number: this.newReview.reviewStar,


                    })
                        .then(function (response) {
                            alert("Recensione postata con successo!")
                        })
                        .catch(function (error) {
                            alert("Impossibile postare la recensione!")
                        });
                }
            }
        }
    }
</script>
