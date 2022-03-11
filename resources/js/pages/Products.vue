<template>
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h1 class="mt-5 mb-3">
                        All Products
                    </h1>
                </div>
            </div>
            <div class="row search mb-3 p-3 bg-light">
                <div class="col-12">
                    <form>
                        <h2>Search</h2>
                        <div class="row">
                            <div class="mb-3 col-2">
                                Order By Column
                                <select class="form-select form-select" name="orderbycolumn" id="orderbycolumn"
                                    v-model="form.orderbycolumn">
                                    <option value="name">Name</option>
                                    <option value="price">Price</option>
                                    <option value="created_at">Created</option>
                                    <option value="updated_at">Updated</option>
                                </select>
                            </div>
                            <div class="mb-3 col-2">
                                Order By Versus
                                <select class="form-select form-select" name="orderbysort" id="orderbysort"
                                    v-model="form.orderbysort">
                                    <option value="asc">Asc</option>
                                    <option value="desc">Desc</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-6">
                                Tags
                                <div class="d-flex align-items-center justify-content-between">
                                    <div :key="'tag-' + index" v-for="(tag, index) in tags">
                                        <input type="checkbox" name="tags[]" :value="tag.name" v-model="form.tags">
                                        <label :for="tag.name">{{tag.name}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <input class="btn btn-info" type="button" value="filtra" @click.prevent="searchProducts">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <Main :cards="cards" @changePage="changePage($event)"></Main>
    </div>
</template>

<script>
    import Axios from "axios";
    import Main from '../components/Main.vue';

    export default {
        name: 'Products',
        components: {
            Main
        },
        data() {
            return {
                tags: [],
                form: {
                    orderbycolumn: 'name',
                    orderbysort: 'desc',
                    tags: []
                },
                cards: {
                    products: null,
                    next_page_url: null,
                    prev_page_url: null
                }
            }
        },
        created() {
            this.getProducts('http://127.0.0.1:8000/api/v1/products');
            this.getTags();
        },
        methods: {
            changePage(vs) {
                let url = this.cards[vs];
                if (url) {
                    this.getProducts(url);
                }
            },
            getProducts(url) {
                Axios.get(url).then(
                    (result) => {
                        this.cards.products = result.data.results.data;
                        this.cards.next_page_url = result.data.results.next_page_url;
                        this.cards.prev_page_url = result.data.results.prev_page_url;
                    });
            },
            searchProducts() {
                console.log('search', this.form);

                const url = 'http://127.0.0.1:8000/api/v1/products/search';
                Axios.get(url, {
                    params: this.form
                }).then(
                    (result) => {
                        console.log(result);
                        this.cards.products = result.data.results.data;
                        this.cards.next_page_url = result.data.results.next_page_url;
                        this.cards.prev_page_url = result.data.results.prev_page_url;
                    });
            },
            getTags() {
                const url = 'http://127.0.0.1:8000/api/v1/tags';

                Axios.get(url).then(
                    (result) => {
                        console.log(result);
                        this.tags = result.data.results.data;
                    });
            }

        }
    }

</script>

<style lang="scss">

</style>
