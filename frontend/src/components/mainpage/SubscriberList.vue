<template>
  <v-simple-table>
    <template v-slot:default>
      <thead>
      <tr>
        <th class="text-left">
          Номер телефона
        </th>
        <th class="text-left">
          Информация об абоненте
        </th>
      </tr>
      </thead>
      <tbody>
      <tr
          v-for="item in $store.getters.phoneList"
          :key="item.name"
      >
        <td>{{ item.number }}</td>
        <td>{{ item.info }}</td>
      </tr>
      </tbody>
    </template>
  </v-simple-table>
</template>

<script>
export default {
  name: "SubscriberList"
}
</script>

<style scoped>

</style>