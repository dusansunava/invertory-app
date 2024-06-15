<template>
  <div class="background-container">
    
    <NavbarComponent />
    <div class="container mt-5 pb-5">

      <div class="card">
        <div class="card-header shadow">

          <!-- Switch data -->
          <div class="row justify-content-between">
            <div class="col-auto">
              <button v-for="(button, index) in buttons" :key="index" type="button" class="btn rounded-0" :class="{
                'btn-primary': activeCard === index,
                'btn-outline-primary': activeCard !== index,
              }" @click="activeCard = index">
                {{ button }}
              </button>
            </div>

            <!-- Switch filter -->
            <div class="row col-auto">
              <div v-if="filtering === 0" key="parts" class="col-auto">
                <button type="button" class="btn rounded-0 btn-outline-primary ml-0" @click="filterSwitch()">Filter
                  OFF</button>
              </div>
              <div v-if="filtering === 1" key="cars" class="col-auto">
                <button type="button" class="btn rounded-0 btn-primary" @click="filterSwitch()">Filter ON</button>
              </div>

              <Transition name="slide-fade">
                <div v-if="filtering === 1" class="row col-auto">

                  <!-- Filter for cars-->
                  <div v-if="activeCard === 0">
                    <div class="input-group">
                      <div class="input-group" id="filter-switch">
                        <button
                          :class="['btn', 'btn-outline-secondary', 'rounded-0', { 'btn-secondary active': activeFilterCar === 1 }]"
                          type="button" @click="activeFilterCar = 1">Name</button>
                        <input v-if="activeFilterCar === 1" v-model="nameFilter" type="text" class="form-control"
                          placeholder="">

                        <button
                          :class="['btn', 'btn-outline-secondary', 'rounded-0', { 'btn-secondary active': activeFilterCar === 2 }]"
                          type="button" @click="activeFilterCar = 2">Registration
                          number</button>
                        <input v-if="activeFilterCar === 2" v-model="regNumFilter" type="text" class="form-control"
                          placeholder="">

                        <button
                          :class="['btn', 'btn-outline-secondary', 'rounded-0', { 'btn-secondary active': activeFilterCar === 3 }]"
                          type="button" @click="activeFilterCar = 3">Is registered</button>
                        <select v-if="activeFilterCar === 3" class="form-control" id="isRegistered"
                          v-model="isRegFilter">
                          <option :value="true">Yes</option>
                          <option :value="false">No</option>
                        </select>
                        <buttons class="btn btn-primary" @click="applyCarFilter()">Apply filter</buttons>
                      </div>
                    </div>
                  </div>


                  <!-- Filter for parts -->
                  <div v-if="activeCard === 1">
                    <div class="input-group">
                      <div class="input-group" id="filter-switch">
                        <button
                          :class="['btn', 'btn-outline-secondary', 'rounded-0', { 'btn-secondary active': activeFilterPart === 1 }]"
                          type="button" @click="activeFilterPart = 1">Name</button>
                        <input v-if="activeFilterPart === 1" v-model="nameFilter" type="text" class="form-control"
                          placeholder="">

                        <button
                          :class="['btn', 'btn-outline-secondary', 'rounded-0', { 'btn-secondary active': activeFilterPart === 2 }]"
                          type="button" @click="activeFilterPart = 2">Serial number</button>
                        <input v-if="activeFilterPart === 2" v-model="regNumFilter" type="text" class="form-control"
                          placeholder="">

                        <button
                          :class="['btn', 'btn-outline-secondary', 'rounded-0', { 'btn-secondary active': activeFilterPart === 3 }]"
                          type="button" @click="activeFilterPart = 3">Car name</button>
                        <input v-if="activeFilterPart === 3" v-model="isRegFilter" type="text" class="form-control"
                          placeholder="">

                        <buttons class="btn btn-primary rounded-0" @click="applyPartFilter()">Apply filter</buttons>
                      </div>
                    </div>
                  </div>
                </div>
              </Transition>
            </div>

            <!-- Create new record button -->
            <div v-if="activeCard === 0" key="parts" class="col-auto">
              <button type="button" class="btn rounded-0 btn-primary" @click="openCreateCar()">Add car</button>
            </div>
            <div v-if="activeCard === 1" key="cars" class="col-auto">
              <button type="button" class="btn rounded-0 btn-primary" @click="openCreatePart()">Add part</button>
            </div>

          </div>
        </div>

        <div class="card-body">
          <div v-if="activeCard === 1" key="parts" class="card shadow-lg">
            <PartsTable ref="partsTable" @openDetailModal="handlePartDetailModal" />
          </div>
          <div v-if="activeCard === 0" key="cars" class="card shadow-lg">
            <CarsTable ref="carsTable" @openDetailModal="handleCarDetailModal" />
          </div>
        </div>

        <CarDetail ref="detailModal" :data="modalData" @closeDetailModal="handleDetailModalClose" />
        <PartDetail ref="partDetail" :data="partModalData" @closeDetailModal="handleDetailModalClose" />
        <CreateCar ref="createCar" @closeDetailModal="handleDetailModalClose" />
        <CreatePart ref="createPart" @closeDetailModal="handleDetailModalClose" />
      </div>
    </div>
  </div>
</template>

<script>
import CarsTable from './components/CarsTable.vue'
import PartsTable from './components/PartsTable.vue'
import NavbarComponent from './components/NavbarComponent.vue'
import CarDetail from './components/CarDetail.vue'
import PartDetail from './components/PartDetail.vue'
import CreateCar from './components/CreateCar.vue'
import CreatePart from './components/CreatePart.vue'

export default {
  name: 'App',
  components: {
    CarsTable,
    PartsTable,
    NavbarComponent,
    CarDetail,
    PartDetail,
    CreateCar,
    CreatePart
  },
  data() {
    return {
      activeCard: 0,
      buttons: ['Cars', 'Parts'],
      modalData: {},
      partModalData: {},
      filtering: 0,
      activeFilterCar: 1,
      activeFilterPart: 1,
      nameFilter: "",
      regNumFilter: "",
      isRegFilter: "",
      serNumFilter: "",
      carIdFilter: ""
    };
  },
  methods: {
    handleCarDetailModal(data) {
      console.log('openModal', data);
      this.modalData = data;
      this.$refs.detailModal.open();
    },
    handlePartDetailModal(data) {
      console.log('Opening parts modal', data);
      this.partModalData = data;
      this.$refs.partDetail.open();
    },
    handleDetailModalClose() {
      this.$nextTick(() => {
        if (this.$refs.partsTable) {
          this.$refs.partsTable.fetchParts();
        }
        if (this.$refs.carsTable) {
          this.$refs.carsTable.fetchCars();
        }
      });
    },
    openCreateCar() {
      this.$refs.createCar.open();
    },
    openCreatePart() {
      this.$refs.createPart.open();
    },
    filterSwitch() {
      this.filtering === 0 ? this.filtering = 1 : this.filtering = 0;
      this.filtering === 0 ? this.handleDetailModalClose() : null;
    },
    applyCarFilter() {
      switch (this.activeFilterCar) {
        case 1:
          this.$refs.carsTable.fetchFilteredCarsByName(this.nameFilter);
          break;
        case 2:
          this.$refs.carsTable.fetchFilteredCarsByRegistrationNumber(this.regNumFilter);
          break;
        case 3:
          this.$refs.carsTable.fetchFilteredCarsByIsRegistered(this.isRegFilter);
          break;
      }
    },
    applyPartFilter() {
      switch (this.activeFilterPart) {
        case 1:
          this.$refs.partsTable.fetchFilteredPartsByName(this.nameFilter);
          break;
        case 2:
          this.$refs.partsTable.fetchFilteredPartsBySerialNumber(this.regNumFilter);
          break;
        case 3:
          this.$refs.partsTable.fetchFilteredPartsByCarName(this.isRegFilter);
          break;
      }
    }
  }
}
</script>

<style>
.background-container {
  min-height: 100vh;
  position: relative;
  justify-content: center;
  align-items: center;
}

.background-container::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url('./assets/background.jpg');
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
  filter: blur(5px);
  z-index: -1;
}

.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.2s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}
</style>
