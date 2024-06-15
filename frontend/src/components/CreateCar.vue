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
            <h5 class="modal-title" id="exampleModalLabel">Create new car record</h5>
          </div>
          <form @submit.prevent="saveChanges">
            <div class="modal-body">
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" v-model="formData.name">
              </div>
              <div class="form-group">
                <label for="registrationNumber">Registration Number</label>
                <input type="text" class="form-control" id="registrationNumber" v-model="formData.registration_number">
              </div>
              <div class="form-group">
                <label for="isRegistered">Is Registered</label>
                <select class="form-control" id="isRegistered" v-model="formData.is_registered">
                  <option :value="true">Yes</option>
                  <option :value="false">No</option>
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
        registration_number: '',
        is_registered: 'null',
      },
    };
  },
  methods: {
    close() {
      this.showModal = false;
      this.$emit('closeDetailModal');
    },
    open() {
      this.showModal = true;
    },
    saveChanges() {
      console.log("Data from save: ", this.formData);
      axios.post('http://127.0.0.1:8000/api/cars', {
        name: this.formData.name,
        registration_number: this.formData.registration_number,
        is_registered: this.formData.is_registered,
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
    }
  },
};
</script>

<style>
/* Add your component-specific styles here */
</style>
