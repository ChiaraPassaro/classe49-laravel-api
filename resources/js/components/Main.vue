<template>
  <div class="container-fluid">
    <div class="row row-cols-1 row-cols-md-4 g-4" v-if="cards.products">
      <div class="col" v-for="(product, index) in cards.products" :key="index">
        <div class="card">
          <img :src="'/storage/'+product.image" class="card-img-top" :alt="product.name">
          <div class="card-body">
            <h5 class="card-title">{{ product.name }}</h5>
            <p class="card-text">{{ product.description }}</p>
          </div>
          <router-link class="btn btn-info" 
            :to="{ name: 'product', params: { id: product.id } }">
            View</router-link>
        </div>
      </div>
    </div>
    <div class="row mt-3 bg-light" v-if="cards.prev_page_url || cards.next_page_url">
      <ul class="list-inline bg-light p-2">
        <li class="list-inline-item"> <button v-if="cards.prev_page_url" class="btn btn-primary" @click="changePage('prev_page_url')">Prev</button></li>
        <li class="list-inline-item"> <button v-if="cards.next_page_url" class="btn btn-primary" @click="changePage('next_page_url')">Next</button></li>
      </ul>
    </div>
  </div>
</template>


<script>

  export default {
    name: "Main",
    props: ['cards'],
    methods: {
      changePage(vs) {
        this.$emit('changePage', vs);
      }
    }
  }
</script>

<style lang="scss" scoped>

</style>