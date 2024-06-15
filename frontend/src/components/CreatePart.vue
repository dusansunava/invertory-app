<template>
  <div>
    <!-- Alert -->
    <div v-if="showSuccessAlert" class="alert alert-success alert-dismissible fixed-top" role="alert">
      Changes saved successfully!
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true" style="display: block;" @click.self="close">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create new part record</h5>
          </div>
          <form @submit.prevent="saveChanges">
            <div class="modal-body">
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" v-model="formData.name">
              </div>
              <div class="form-group">
                <label for="serialNumber">Serial Number</label>
                <input type="text" class="form-control" id="registrationNumber" v-model="formData.serialnumber">
              </div>
              <div class="form-group">
                <label for="cadcarId">For car</label>
                <select class="form-control" id="carId" v-model="formData.car_id">
                  <option :key="null" :value="null">No car</option>
                  <option v-for="car in carsData" :key="car.id" :value="car.id">{{ car.name }}</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="close">Discard</button>
              <button type="submit" class="btn btn-primary">Create new record</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Backdrop -->
    <div v-if="showModal" class="modal-backdrop fade show"></div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      showModal: false,
      showSuccessAlert: false, 
      formData: {
        name: '',
        serialnumber: '',
        car_id: null,
      },
      carsData: []
    };
  },
  methods: {
    close() {
      this.showModal = false;
      this.$emit('closeDetailModal');
    },
    open() {
      this.showModal = true;
      this.fetchCarsData();
    },
    saveChanges() {
      console.log("Data from save: ", this.formData);
      axios.post('http://127.0.0.1:8000/api/parts', {
        name: this.formData.name,
        serialnumber: this.formData.serialnumber,
        car_id: this.formData.car_id === null ? undefined : this.formData.car_id,
      })
        .then(response => {
          console.log('Created successfully:', response.data);
          this.showSuccessAlert = true;
          setTimeout(() => this.showSuccessAlert = false, 3000);
          this.close();
        })
        .catch(error => {
          console.error('Error updating data:', error);
        });
    },
    fetchCarsData() {
      axios.get('http://127.0.0.1:8000/api/cars')
        .then(response => {
          console.log("Response data", response.data);
          this.carsData = response.data;
        })
        .catch(error => {
          console.error('Error fetching cars', error);
        });
    }
  },
};
</script>

<style>
</style>
