<template>
  
    <table class="table table-hover">
      <thead>
        <tr>
          <th v-for="header in headers" :key="header">
            {{ header }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="items.length === 0">
          <td colspan="3">No data</td>
        </tr>
        <tr v-else v-for="item in items" :key="item.id">
          <td>{{ item.name }}</td>
          <td>{{ item.registration_number }}</td>
          <td>{{ item.is_registered ? 'Yes' : 'No' }}</td>
          <td><button type="button" class="btn btn-info" @click="openDetailModal(item)">Edit</button></td>
        </tr>
      </tbody>
    </table>
  
</template>
<script>
import axios from 'axios';

export default {
  data() {
    return {
      items: [],
      headers: ["Name", "Registration number", "Is registered", "Edit"],
     
    };
  },
  created() {
    this.fetchCars();
  },
  methods: {
    fetchCars() {
      axios.get('http://127.0.0.1:8000/api/cars')
        .then(response => {
          this.items = response.data;
        })
        .catch(error => {
          console.error('Error fetching cars', error);
        });
    },
    openDetailModal(item) {
      this.$emit('openDetailModal', item);
    },
    fetchFilteredCarsByName(name) {
      axios.get(`http://127.0.0.1:8000/api/cars/byName/${name}`)
        .then(response => {
          this.items = response.data;
        })
        .catch(error => {
          console.error('Error fetching cars', error);
        });
    },
    fetchFilteredCarsByRegistrationNumber(registration_number) {
      axios.get(`http://127.0.0.1:8000/api/cars/byRegNum/${registration_number}`)
        .then(response => {
          console.log(response);
          this.items = response.data;
        })
        .catch(error => {
          console.error('Error fetching cars', error);
        });
    },
    fetchFilteredCarsByIsRegistered(is_registered) {
      axios.get(`http://127.0.0.1:8000/api/cars/byIsReg/${is_registered === true ? 1 : 0}`)
        .then(response => {
          this.items = response.data;
        })
        .catch(error => {
          console.error('Error fetching cars', error);
        });
    }
  }
}
</script>

<style scoped>
</style>
