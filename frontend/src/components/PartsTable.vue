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
        <td>{{ item.serialnumber }}</td>
        <td>{{ getCarName(item.car_id) }}</td>
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
      headers: ["Name", "Serial number", "Car name", "Edit"],
      carsData: [],

    };
  },
  created() {
    this.fetchParts();
    this.fetchCars();
  },
  methods: {
    fetchParts() {
      axios.get('http://127.0.0.1:8000/api/parts')
        .then(response => {
          this.items = response.data;
        })
        .catch(error => {
          console.error('Error fetching parts', error);
        });
    },
    openDetailModal(item) {
      console.log("EMITING");
      this.$emit('openDetailModal', item);
    },
    fetchCars() {
      axios.get('http://127.0.0.1:8000/api/cars')
        .then(response => {
          console.log("Response data", response.data);
          this.carsData = response.data;
        })
        .catch(error => {
          console.error('Error fetching cars', error);
        });
    },
    getCarName(car_id) {
      const car = this.carsData.find(car => car.id === car_id);
      return car ? car.name : 'Unknown';
    },
    fetchFilteredPartsByName(name) {
      console.log("By name: ", name);
      axios.get(`http://127.0.0.1:8000/api/parts/byName/${name}`)
        .then(response => {
          console.log(response);
          this.items = response.data;
        })
        .catch(error => {
          console.error('Error fetching parts', error);
        });
    },
    fetchFilteredPartsBySerialNumber(serialnumber) {
      axios.get(`http://127.0.0.1:8000/api/parts/bySerNum/${serialnumber}`)
        .then(response => {
          this.items = response.data;
        })
        .catch(error => {
          console.error('Error fetching parts', error);
        });
    },
    fetchFilteredPartsByCarName(carName) {
      axios.get(`http://127.0.0.1:8000/api/parts/byCarName/${carName}`)
        .then(response => {
          this.items = response.data;
        })
        .catch(error => {
          console.error('Error fetching parts', error);
        });
    }
  }
}
</script>

<style scoped>
</style>
