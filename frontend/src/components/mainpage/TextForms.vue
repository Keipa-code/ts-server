<template>
  <v-container class="d-flex">
    <v-col cols="4">
      <v-select
          :items="items"
          @change="handleSelectChange"
          label="Поиск"
      ></v-select>
    </v-col>
    <v-col cols="6" v-show="select === 'По номеру телефона'">
      <div class="d-flex">
      <v-text-field class="ml-5" name="number" placeholder="Введите номер телефона" v-model="number"/>
      <v-btn @click="findNumber" class="ml-1 mt-2">Поиск</v-btn>
      </div>
    </v-col>
    <v-col cols="6" v-show="select === 'По ФИО'">
      <div class="d-flex">
      <v-text-field class="ml-5" placeholder="Введите ФИО" v-model="fio"/>
      <v-btn @click="findFIO" class="ml-1 mt-2">Поиск</v-btn>
      </div>
    </v-col>
    <v-col cols="6" v-show="select === 'По названию организаций'">
      <div class="d-flex">
      <v-text-field class="ml-5" placeholder="Введите название организаций" v-model="orgName"/>
      <v-btn @click="findOrgName" value="orgName1" class="ml-1 mt-2">Поиск</v-btn>
      </div>
    </v-col>
  </v-container>
</template>

<script>
import { mapMutations } from 'vuex'

export default {
  data: () => ({
    number: '',
    fio: '',
    orgName: '',
    items: ['По номеру телефона', 'По ФИО', 'По названию организаций'],
    select: ''
  }),
  methods: {
    ...mapMutations(["setQuery"]),
    findNumber() {
      this.setQuery({
        number: this.number.length > 0 ? this.number : '',
      })
      this.fetch()
    },
    findFIO() {
      this.setQuery({
        fio: this.fio.length > 0 ? this.fio : '',
      })
      this.fetch()
    },
    findOrgName() {
      this.setQuery({
        orgName: this.orgName.length > 0 ? this.orgName : '',
      })
      this.fetch()
    },
    fetch() {
      this.$store.dispatch("fetchListByNumber")
    },
    handleSelectChange(event) {
      this.select = event
    }
  },

}
</script>

<style scoped>

</style>