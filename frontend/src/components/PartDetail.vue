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
            <h5 class="modal-title" id="exampleModalLabel">Change details</h5>
          </div>
          <form @submit.prevent="saveChanges">
            <div class="modal-body">
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" v-model="formData.name">
              </div>
              <div class="form-group">
                <label for="serialNumber">Serial Number</label>
                <input type="text" class="form-control" id="serialNumber" v-model="formData.serialnumber">
              </div>
              <div class="form-group">
                <label for="car_id">Registered to car</label>
                <select class="form-control" id="car_id" v-model="formData.car_id">
                  <option :key="null" :value="null">No car</option>
                  <option v-for="car in carsData" :key="car.id" :value="car.id">{{ car.name }}</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="close">Close</button>
              <button type="button" class="btn btn-warning" @click="deletePart">Delete part</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
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
        car_id: '',
      },
      carsData: []
    };
  },
  created() {
    this.fetchCarsData();
  },
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  watch: {
    data: {
      handler(newVal) {
        this.formData.name = newVal.name;
        this.formData.serialnumber = newVal.serialnumber;
        this.formData.car_id = newVal.car_id;
        console.log("Form data: ", newVal);
      },
      immediate: true,
    },
  },
  methods: {
    close() {
      this.showModal = false;
      this.$emit('closeDetailModal');
    },
    open() {
      this.formData.name = this.data.name;
      this.formData.serialnumber = this.data.serialnumber;
      this.formData.car_id = this.data.car_id;
      this.showModal = true;
      this.fetchCarsData();
    },
    saveChanges() {
      console.log("Data from save: ", this.formData);
      axios.put(`http://127.0.0.1:8000/api/parts/${this.data.id}`, {
        name: this.formData.name,
        serialnumber: this.formData.serialnumber,
        car_id: this.formData.car_id,
      })
        .then(response => {
          console.log('Updated successfully:', response.data);
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
    },
    deletePart() {
      axios.delete(`http://127.0.0.1:8000/api/parts/${this.data.id}`)
        .then(response => {
          console.log('Deleted successfully:', response.data);
          this.close();
        })
        .catch(error => {
          console.error('Error deleting data:', error);
        });
    }
  },
};
</script>

<style>
</style>
