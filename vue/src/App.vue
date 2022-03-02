<script>

import {mapState} from 'vuex'

export default{
components:{
  
},
  computed:{
    ...mapState(['user'])

  }
}
</script>

<template>

  <router-view></router-view>

</template>

<style>

</style>
