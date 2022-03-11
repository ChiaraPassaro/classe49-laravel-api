<template>
  <div>
    <div class="row row-cols-1 row-cols-md-4 g-4" v-if="product">
        <div class="card">
          <img :src="'/storage/'+product.image" class="card-img-top" :alt="product.name">
          <div class="card-body">
            <h5 class="card-title">{{ product.name }}</h5>
            <p class="card-text">{{ product.description }}</p>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import Axios from "axios";

  export default {
    name: 'Product',
    props: ['id'],
    data() {
      return {
        product: null
      }
    },
    created() {
      const url = 'http://127.0.0.1:8000/api/v1/products/' + this.id;
      this.getProduct(url);
    },
    methods: {
      getProduct(url){
          Axios.get(url,  {headers: {'Authorization': 'Bearer n686yd9qnm9b56h'}}).then(
            (result) => {
              console.log(result);
              this.product = result.data.results.data;
            }).catch(error => console.log(error));
      }
    }
  }
</script>

<style lang="scss">

</style>