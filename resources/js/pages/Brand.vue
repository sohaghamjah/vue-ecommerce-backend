<template>
   <div id="customer">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Brands</h4>
            <div class="card-tools" style="position: absolute;right: 1rem;top: .5rem;">
              <button type="button" class="btn btn-primary mr-3" @click="addItem">
                <i class="fas fa-plus"></i>
              </button>
            </div>
          </div>
          <div class="card-header col-nd-12">
            <div class="row">
              <div class="form-group col-md-4">
                    <input type="text" id="name" class="form-control" placeholder="Search Brand Name" @click="searchData">
              </div>
              <div class="form-group col-md-8 text-right">
                  <button type="button" class="btn btn-info mr-2">
                    <i class="fas fa-search"></i>
                  </button>
                  <button type="button" class="btn btn-warning" @click="relode">
                    <i class="fas fa-sync"></i>
                  </button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <!--  Search Field  -->
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-striped">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">SL</th>
                    <th scope="col" class="text-center">Brand Name</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">Created By</th>
                    <th scope="col" class="text-center">Created At</th>
                    <th scope="col" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-show="!tableData.length"><td class="text-danger text-center" colspan="6">No data found!</td></tr>
                  <tr v-show="tableData.length" v-for="(brand, i) in tableData" :key="i">
                    <td class="text-center">{{ i++ }}</td>
                    <td class="text-left">{{ brand.name }}</td>
                    <td class="text-center">{{ brand.status === 1 ? 'Active' : 'Inactive' }}</td>
                    <td class="text-center">{{ brand.created_by }}</td>
                    <td class="text-center">{{ brand.updated_by }}</td>
                    <td class="text-center">
                      <button type="button" class="btn btn-primary btn-sm mr-2"><i class="fa fa-edit"></i></button>
                      <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Start -->
    <div v-if="modalShow" class="modal fade show" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" style="display: block; padding-right: 17px;" aria-modal="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle">{{ modalTitle }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="modalShow = false">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
             <form>
                <div class="form-group">
                    <label for="name">Brand Name</label>
                    <input type="text" v-model="form.name" id="name" class="form-control" :class="errors.name ? 'is-invalid' : ''">
                    <small v-if="errors.name" class="text-danger">{{errors.name[0]}}</small>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="modalShow = false">Close</button>
            <button type="button" class="btn btn-primary" @click="editMode == true ? update() : save()">{{ editMode == true ? 'Update' : 'Save' }}</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal End -->
  </div>
</template>

<script>
export default {
    name: 'Brand',
    data(){
      return{
        editMode: false,
        modalShow: false,
        modalTitle: "",
        tableData:[],
        query:'',
        pagination:{
          current_page: 1
        },
        form:{
          name: '',
        },
        errors:{}
      }
    },
    created(){
      this.getData();
    },
    methods:{
      getData(){
        axios.get("brands?page=" + this.current_page)
        .then(res => {
          console.log(res);
          this.tableData = res.data.data;
          this.pagination = res.data.meta;
        })
        .catch(error => {
          console.log(error);
        });
      },
      addItem(){
        this.modalTitle = "Add new brand";
        this.modalShow = true;
        this.errors = {};
      },
      save(){
        axios.post('brands', this.from)
        .then(rese => {

        })
        .catch(error => {
          this.errors = error.response.data.errors;
        })
      },
      update(){

      }
    }
}
</script>

<style>

</style>