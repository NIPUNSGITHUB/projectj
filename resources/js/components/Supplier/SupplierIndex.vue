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
                <h3 v-if="myOrders == false" class="panel-title">Latest Orders</h3>
                <h3 v-else class="panel-title">My Orders</h3>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-1 m-0 p-0"></div>
                  <div class="col-md-11">
                    <div class="row">
                      <div class="col-md-8 pl-0 pr-2">
                        <multiselect
                          class="form-controller-sm"
                          v-model="selectedArea"
                          deselect-label="Can't remove this value"
                          track-by="id"
                          label="name"
                          placeholder="Select Area"
                          :options="areas"
                          :searchable="true"
                          :allow-empty="true"
                          @input="populateTableData()"
                          @remove="populateInitialData()"
                        ></multiselect>
                      </div>
                      <div class="col-md-1" style="padding-left: 0px;padding-top: -;">
                        <button
                          class="btn btn-info"
                          style="padding-top: 7px;margin-top: 4px;padding-bottom: 7px;padding-right: 12px;margin-right: 5px;"
                          @click="populateInitialData()"
                        >All</button>
                      </div>
                      <div class="col-md-3 ml-0" style="padding-left: 0px;padding-top: -;">
                        <button
                          class="btn btn-info"
                          style="padding-top: 7px;margin-top: 4px;padding-bottom: 7px;padding-right: 12px;margin-right: 5px;"
                          @click="poputaleConfirmedOrders()"
                        >My Orders</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="panel-body">
            <table class="table table-striped table-hover">
              <thead>
                <th>#</th>
                <th>Customer Name</th>
                <th>Item Name</th>
                <th>Qty</th>
                <th>Status</th>
                <th>Additional note</th>
                <th>Area</th>
                <th>Deliver Note</th>
                <th>Deliver Date</th>
                <th>Updated at</th>
                <th>Action</th>
              </thead>
              <tbody v-if="orderDetails.data != '' ">
                <tr v-for="orderDetail in orderDetails.data" :key="orderDetail.id">
                  <td>{{orderDetail.id}}</td>
                  <td>{{orderDetail.customer_name}}</td>
                  <td>{{orderDetail.name}}</td>
                  <td>{{orderDetail.qty}}</td>
                  <td>
                    <p v-if="orderDetail.status == 1" class="text-success">Locked</p>
                    <p v-if="orderDetail.status == 0" style="color:rgb(238, 152, 1)">Open</p>
                  </td>
                  <td>{{orderDetail.add_note}}</td>
                  <td>{{orderDetail.area_name}}</td>
                  <td
                    class="text-center"
                  >{{orderDetail.deliver_note == null ? '-' :orderDetail.deliver_note}}</td>
                  <td
                    class="text-center"
                  >{{orderDetail.deliver_date == null ? '-' :orderDetail.deliver_date}}</td>
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
                                  <td>{{orderDetail.id}}</td>
                                </tr>
                                <tr>
                                  <td>Customer Name</td>
                                  <td>{{orderDetail.customer_name}}</td>
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
                                      <datetime
                                        v-model="deliver_date"
                                        :min-datetime="minDatetime"
                                        use12-hour
                                        type="datetime"
                                        format="yyyy-MM-dd HH:mm"
                                      ></datetime>
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
                                        placeholder="Deliver note"
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
                              v-if="deliver_date == null || deliver_note == null"
                              disabled
                              type="button"
                              class="btn btn-primary"
                            >I Will Deliver</button>
                            <button
                              v-else
                              data-dismiss="modal"
                              type="button"
                              @click="confirmOrderDetails(orderDetail)"
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
      selectedArea: "",
      areas: [],
      items: [],
      orderDetails: {},
      load_data: false,
      lock_order: false,
      order_id: null,
      deliver_note: null,
      deliver_date: null,
      rpp: 10,
      minDatetime: null,
      myOrders: false
    };
  },
  mounted() {
    this.populateInitialData();
    this.populateTableData();
    this.minDatetime = new Date();
  },
  methods: {
    changStatus() {
      if (!this.lock_order) this.lock_order = true;
      else this.lock_order = false;
    },

    populateInitialData(page = 1) {
      this.myOrders = false;
      this.load_data = true;
      this.selectedArea = "";
      axios
        .get("populate/initial/data")
        .then(res => {
          console.log(res.data);
          this.items = res.data["items"];
          this.areas = res.data["areas"];
          this.load_data = false;
          this.populateTableData();
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
    poputaleConfirmedOrders(page = 1) {
      this.load_data = true;
      this.myOrders = true;
      axios
        .post("populate/supplier/orderDetails?page=" + page, {
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

    formReset() {
      (this.selectedArea = ""),
        (this.areas = []),
        (this.items = []),
        (this.orderDetails = {}),
        (this.load_data = false),
        (this.lock_order = false),
        (this.order_id = null),
        (this.deliver_note = null),
        (this.deliver_date = null),
        (this.rpp = 15);
      this.populateTableData();
    },
    confirmOrderDetails(orderDetail) {
      axios
        .post("confirm/order/details", {
          order_id: orderDetail.id,
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