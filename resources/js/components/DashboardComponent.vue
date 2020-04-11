<template>
  <div>
    <customer-placeorder-component v-if="userdetails.user_type == 'Customer'" :userdetails="userdetails" ></customer-placeorder-component>
    <supplier-component v-else-if="userdetails.user_type == 'Supplier' "></supplier-component>

 
  </div>
</template>

<script>
export default {
  mounted() {   
   this.userdetails = JSON.parse(this.$user)
  },
  data() {
    return {
      userdetails:[]
    };
  },
  methods: { 
  }
};
</script>
