<template>
  <div>
      <div class="container-fluid">
        <div class="row">
          <div class="col">
            <h1>Home</h1>
          </div>
        </div>
        <Loading v-if="loading"/>
        <Main :cards="cards" @changePage="changePage($event)" v-else></Main>
      </div>
  </div>
</template>

<script>
import Axios from "axios";

import Loading from "../components/Loading.vue";
import Main from '../components/Main.vue';

  export default {
    name: 'Home',
    components: {
      Main,
      Loading
    },
    data() {
      return {
        loading: false,
        cards: {
          products: null,
          next_page_url: null,
          prev_page_url: null
        }
      }
    },
    created() {
      this.getProducts('http://127.0.0.1:8000/api/v1/products/random');
    },
    methods: {
      changePage(vs) {
        let url = this.cards[vs];
        if(url) {
          this.getProducts(url);
        }
      },
      getProducts(url){
        this.loading = true;
        setTimeout(() => {
          Axios.get(url).then(
            (result) => {
              console.log(result);
              this.cards.products = result.data.results.data;
              this.cards.next_page_url = result.data.results.next_page_url;
              this.cards.prev_page_url = result.data.results.prev_page_url;
              this.loading = false;
            });

        }, 2000);
          
      }
    }
  }
</script>

<style lang="scss">

</style>