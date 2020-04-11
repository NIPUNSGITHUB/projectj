<template>
  <div>
    <!-- Customer section -->
    <section id="main">
      <div class="container">
        <!-- Order details table -->
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="row">
              <div class="col-md-6">
                <h3 class="panel-title">Latest Orders</h3>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6 pl-10">
                  
                  </div>
                  <div class="col-md-6 pl-15">
                    <multiselect
                      class="form-controller-sm"
                      v-model="selectedArea"
                      deselect-label="Can't remove this value"
                      track-by="id"
                      label="name"
                      placeholder="Select Area"
                      :options="areas"
                      :searchable="false"
                      :allow-empty="false"
                      @input="populateTableData()"
                    ></multiselect>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="panel-body">
            <table class="table table-striped table-hover">
              <thead>
                <th>#</th>
                <th>Item Name</th>
                <th>Qty</th>
                <th>Status</th>
                <th>Additional note</th>
                <th>Area</th>
                <th>Updated at</th>
                <th>Action</th>
              </thead>
              <tbody v-if="orderDetails.data != '' ">
                <tr  v-for="orderDetail in orderDetails.data" :key="orderDetail.id">
                  <td>{{orderDetail.id}}</td>
                  <td>{{orderDetail.name}}</td>
                  <td>{{orderDetail.qty}}</td>
                  <td>
                    <p v-if="orderDetail.status == 1" class="text-success">Locked</p>
                    <p v-if="orderDetail.status == 0" class="text-warning">Open</p>
                  </td>
                  <td>{{orderDetail.add_note}}</td>
                  <td>{{orderDetail.area_name}}</td>
                  <td>{{orderDetail.updated_at}}</td>
                  <td>
                    <button
                      v-if="orderDetail.status == 1"
                      disabled
                      type="button"
                      class="btn btn-success"
                      data-toggle="modal"
                      data-target="#exampleModalCenter"
                    >I Will Deliver</button>
                    <button
                      v-else
                      type="button"
                      class="btn btn-success"
                      data-toggle="modal"
                      data-target="#exampleModalCenter"
                    >I Will Deliver</button>
                    <!-- Modal -->
                    <div
                      class="modal fade"
                      id="exampleModalCenter"
                      tabindex="-1"
                      role="dialog"
                      aria-labelledby="exampleModalCenterTitle"
                      aria-hidden="true"
                    >
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5
                              class="modal-title"
                              id="exampleModalLongTitle"
                            >Pick your deliver date and confirm delivery</h5>
                          </div>
                          <div class="modal-body">
                            <table class="table">
                              <tbody>
                                <tr>
                                  <td>Order ID</td>
                                  <td>{{order_id = orderDetail.id}}</td>
                                </tr>
                                <tr>
                                  <td>Customer Name</td>
                                  <td>{{orderDetail.name}}</td>
                                </tr>
                                <tr>
                                  <td>Item</td>
                                  <td>{{orderDetail.name}}</td>
                                </tr>
                                <tr>
                                  <td>Additional Note</td>
                                  <td>{{orderDetail.add_note}}</td>
                                </tr>
                                <tr>
                                  <td>Contact No</td>
                                  <td>{{orderDetail.contact_no}}</td>
                                </tr>
                                <tr>
                                  <td>Email</td>
                                  <td>{{orderDetail.email}}</td>
                                </tr>
                                <tr>
                                  <td>Deliver Date</td>
                                  <td>
                                    <div class="form-group">
                                      <input
                                        type="date"
                                        class="form-control"
                                        required
                                        v-model="deliver_date"
                                        name
                                        id
                                        aria-describedby="helpId"
                                        placeholder
                                      />
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Deliver Note</td>
                                  <td>
                                    <div class="form-group">
                                      <input
                                        type="text"
                                        class="form-control"
                                        required
                                        v-model="deliver_note"
                                        name
                                        id
                                        aria-describedby="helpId"
                                        placeholder
                                      />
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <div class="modal-footer">
                            <button
                              type="button"
                              class="btn btn-secondary"
                              data-dismiss="modal"
                            >Close</button>
                            <button
                              type="button"
                              @click="confirmOrderDetails()"
                              class="btn btn-primary"
                            >I Will Deliver</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
              <tbody v-else>
                  <p class="text-center">Not found!</p>
              </tbody>
            </table>
          </div>
          <div
            class="panel-footer"
            style="
                        height: 71px;
                        padding-top: 0px;
                        padding-right: 0px;
                        padding-bottom: 0px;
                        padding-left: 15px;
                    "
          >
            <pagination
              :data="orderDetails"
              v-if="load_data==false"
              :limit="2"
              @pagination-change-page="populateTableData"
            ></pagination>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import Multiselect from "vue-multiselect";
export default {
  components: {
    Multiselect
  },
  props: ["userdetails"],
  data() {
    return {     
     
      selectedArea: '',
      areas: [{ id: "", name: "" }],
      items: [{ id: "", name: "" }],
      orderDetails: {},
      load_data: false,
      lock_order: false,
      order_id: null,
      deliver_note: null,
      deliver_date: null,
      rpp: 5
    };
  },
  mounted() {
    this.populateInitialData();
    this.populateTableData();
  },
  methods: {
    changStatus() {
      if (!this.lock_order) this.lock_order = true;
      else this.lock_order = false;
    },

    populateInitialData(page = 1) {
      this.load_data = true;

      axios
        .get("populate/initial/data")
        .then(res => {
          console.log(res.data);
          this.items = res.data["items"];
          this.areas = res.data["areas"];
          this.load_data = false;
        })
        .catch(err => {
          if (err.response.status == 422)
            this.errors = err.response.data.errors;
        });
    },

    populateTableData(page = 1) {
      this.load_data = true;
      axios
        .post("populate/all/orderDetails?page=" + page, {
          rpp: this.rpp,
          selectedArea: this.selectedArea.name
        })
        .then(res => {
          if (res.status == 200) {
            this.orderDetails = res.data;
            this.load_data = false;
          }
        });
    },

    confirmOrderDetails() {
      axios
        .post("confirm/order/details", {
          order_id: this.order_id,
          deliver_note: this.deliver_note,
          deliver_date: this.deliver_date,
          status: 1
        })
        .then(res => {
          if (res.status == 200) {
            if (res.data == 1) {
              this.$notify({
                group: "foo",
                type: "success",
                title: "Important message",
                text: "Deliver confirm successfull!"
              });
              this.formReset();
            } else {
              this.$notify({
                group: "foo",
                type: "error",
                title: "Important message",
                text: "Deliver confirm unsuccessfull!"
              });
            }
          } else if (res.data == 500) {
            this.$notify({
              group: "foo",
              type: "error",
              title: "Important message",
              text: "Server error!"
            });
          }
        })
        .catch(err => {
          if (err.response.status == 422)
            this.errors = err.response.data.errors;
        });
    }
  }
};
</script>