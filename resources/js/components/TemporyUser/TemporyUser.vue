<template>
  <div>
    <!--Tempory Customer section -->
    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="list-group">
              <a class="list-group-item active main-color-bg">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Customer Dashboard
              </a>
              <button class="list-group-item" @click="changStatus()">
                <span v-if="add_order">
                  <i class="fa fa-list" aria-hidden="true"></i>
                  Order Details
                </span>
                <span v-else>
                  <i class="fa fa-plus text-success" aria-hidden="true"></i>
                  Place order
                </span>
                <span class="badge"></span>
              </button>
            </div>
          </div>
          <div class="col-md-9" style="padding-left: 0px;">
            <!-- Order details table -->
            <div v-if="add_order == false" class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Latest Orders</h3>
              </div>
              <div class="panel-body" style="padding-left: 5px;padding-right: 5px;">
                <table class="table table-striped table-hover">
                  <thead>
                    <th>Order #</th>
                    <th>Customer Name</th>
                    <th>Item Name</th>
                    <th>Qty</th>
                    <th>Additional note</th>
                    <th>Status</th>
                    <th>Deliver Note</th>
                    <th>Deliver Date</th>
                    <th>Created at</th>
                  </thead>
                  <tbody v-if="orderDetails.data != '' ">
                    <tr v-for="orderDetail in orderDetails.data" :key="orderDetail.id">
                      <td>{{orderDetail.id}}</td>
                      <td>{{orderDetail.customer_name}}</td>
                      <td>{{orderDetail.name}}</td>
                      <td>{{orderDetail.qty}}</td>
                      <td>{{orderDetail.add_note}}</td>
                      <td>
                        <p v-if="orderDetail.status == 1" class="text-success">Locked</p>
                        <p v-if="orderDetail.status == 0" style="color:rgb(238, 152, 1)">Open</p>
                      </td>
                      <td
                        class="text-center"
                      >{{orderDetail.deliver_note == null ? '-' :orderDetail.deliver_note}}</td>
                      <td
                        class="text-center"
                      >{{orderDetail.deliver_date == null ? '-' :orderDetail.deliver_date}}</td>
                      <td>{{orderDetail.updated_at}}</td>
                    </tr>
                  </tbody> 
                  <tbody v-else>
                      <p class="text-center">No orders found!</p>                    
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
                <button class="m-2 btn btn-primary float-right" @click="changStatus()">Back</button>
                <pagination
                  :data="orderDetails"
                  v-if="load_data==false"
                  :limit="2"
                  @pagination-change-page="populateTableData"
                ></pagination>
              </div>
            </div>
            <!-- Order Create -->
            <div v-else class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Place Order</h3>
              </div>
              <div class="panel-body">
                  <div class="form-group">
                  <div class="row">
                    <div class="col-md-4 ">
                      <label for>Order#</label>
                      <input type="text" disabled class="form-control" v-model="nextOrderNo" />
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                  </div>
                </div>
                <div class="form-group required">
                  <label for>Customer Name</label>
                  <input
                    type="text"
                    class="form-control"
                    name
                    id
                    aria-describedby="helpId"
                    placeholder="Enter your name"
                    v-model="customerName"
                  />
                  <span v-if="errors.customer_name">
                    <p class="text-danger">{{errors.customer_name[0]}}</p>
                  </span>
                </div>
                <div class="required">
                  <div class="row">
                    <div class="col-md-4">
                      <label class="typo__label">Select Item</label>
                      <multiselect
                        v-model="itemValue"
                        deselect-label="Can't remove this value"
                        track-by="id"
                        label="name"
                        placeholder="Select item"
                        :options="items"
                        :searchable="false"
                        :allow-empty="false"
                      ></multiselect>
                      <span v-if="errors.item_id">
                        <p class="text-danger">Please select an item.</p>
                      </span>
                    </div>
                    <div class="col-md-4">
                      <label class="typo__label">Select Area</label>
                      <multiselect
                        v-model="selectedArea"
                        deselect-label="Can't remove this value"
                        track-by="id"
                        label="name"
                        placeholder="Select area"
                        :options="areas"
                        :searchable="false"
                        :allow-empty="false"
                      ></multiselect>
                      <span v-if="errors.area_id">
                        <p class="text-danger">Please select an area.</p>
                      </span>
                    </div>
                    <div class="col-md-4">
                      <label class="typo__label">QTY.</label>
                      <input class="form-control" type="number" v-model="qty" />
                      <span v-if="errors.qty">
                        <p class="text-danger">{{errors.qty[0]}}</p>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group required">
                  <label for>Additional Note</label>
                  <textarea class="form-control" name id rows="3" v-model="additionalNote"></textarea>
                </div>
                <div class="form-group">
                  <label for>Contact Number</label>
                  <input
                    type="number"
                    class="form-control"
                    name
                    id
                    aria-describedby="helpId"
                    placeholder="Enter contact number"
                    v-model="contactNumber"
                  />
                  <span v-if="errors.contact_no">
                    <p class="text-danger">{{errors.contact_no[0]}}</p>
                  </span>
                </div>
                <div class="form-group">
                  <label for>Email (Optional)</label>
                  <input
                    type="email"
                    class="form-control"
                    name
                    id
                    aria-describedby="helpId"
                    placeholder="Enter your email address"
                    v-model="emailAddress"
                  />
                  <span v-if="errors.email">
                    <p class="text-danger">{{errors.email[0]}}</p>
                  </span>
                </div>
               
                <button
                  type="button"
                  class="btn btn-success float-right ml-2"
                  @click="storeOrderDetails"
                >Submit</button> 

                 <button
                  type="button"
                  class="btn btn-danger float-right"
                  @click="formReset"
                >Cancel</button>
              </div>
            </div>
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
  mounted() {
    this.populateInitialData();
    this.populateTableData();
  },
  data() {
    return {
      errors: [],
      qty: null,
      customerName: null,
      additionalNote: null,
      contactNumber: null,
      emailAddress: null,
      itemValue: "",
      items: [{ id: "", name: "" }],
      orderDetails: {},
      selectedArea: "",
      areas: [{ id: "", name: "" }],
      load_data: false,
      add_order: false,
      rpp: 10,
      nextOrderNo: null
    };
  },
  methods: {
    changStatus() {
      if (!this.add_order) this.add_order = true;
      else this.add_order = false;
    },
    formReset() {
      (this.qty = null),
        (this.customerName = null),
        (this.additionalNote = null),
        (this.contactNumber = null),
        (this.emailAddress = null),
        (this.itemValue = [{ id: "", name: "" }]),
        (this.items = [{ id: "", name: "" }]);
      this.load_data = false;
      this.add_order = false;
      this.populateInitialData();
      this.populateTableData();
    },

    populateTableData(page = 1) {
      this.load_data = true;
      axios
        .post("populate/orderDetails?page=" + page, {
          rpp: this.rpp
        })
        .then(res => {
          if (res.status == 200) {
            this.orderDetails = res.data;
            this.load_data = false;
          }
        });
    },

    populateInitialData(page = 1) {
      this.load_data = true;
      axios
        .get("populate/initial/data")
        .then(res => {
          this.items = res.data["items"];
          this.areas = res.data["areas"];
           this.nextOrderNo = res.data["nextOrderNo"];
          this.load_data = false;
        })
        .catch(err => {
          if (err.response.status == 422)
            this.errors = err.response.data.errors;
        });
    },

    storeOrderDetails() {
      axios
        .post("store/order/details", {
          item_id: this.itemValue.id,
          area_id:this.selectedArea.id,
          qty: this.qty,
          customer_name: this.customerName,
          add_note: this.additionalNote,
          contact_no: this.contactNumber,
          email: this.emailAddress,
          status: 1
        })
        .then(res => {
          if (res.status == 200) {
            if (res.data == 1) {
              this.$notify({
                group: "foo",
                type: "success",
                title: "Important message",
                text: "Order placed successfull!"
              });
              this.formReset();
            } else {
              this.$notify({
                group: "foo",
                type: "error",
                title: "Important message",
                text: "Order placed unsuccessfull!"
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
