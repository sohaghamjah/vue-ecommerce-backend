<template>
    <div id="customer">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Categories</h4>
            <div class="card-tools" style="position: absolute;right: 1rem;top: .5rem;">
              <button type="button" @click="addItem" class="btn btn-primary mr-3">
                <i class="fas fa-plus"></i>
              </button>
            </div>
          </div>
          <div class="card-header col-nd-12">
            <div class="row">
              <div class="form-group col-md-4">
                    <input type="text" id="name" class="form-control" placeholder="Search Brand Name">
              </div>
              <div class="form-group col-md-8 text-right">
                  <button type="button" class="btn btn-info mr-2">
                    <i class="fas fa-search"></i>
                  </button>
                  <button type="button" class="btn btn-warning">
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
                    <th scope="col" class="text-center">Category Name</th>
                    <th scope="col" class="text-center">Slug</th>
                    <th scope="col" class="text-center">Parent</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">Created By</th>
                    <th scope="col" class="text-center">Created At</th>
                    <th scope="col" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-show="!tableData.length"><td class="text-danger text-center" colspan="8">No data found!</td></tr>
                  <tr v-show="tableData.length" v-for="(category, i) in tableData" :key="i">
                    <td class="text-center">{{ i+1 }}</td>
                    <td class="text-center">{{ category.name }}</td>
                    <td class="text-center">{{ category.slug }}</td>
                    <td class="text-center">{{ category.parent ? category.parent.name : '-' }}</td>
                    <td class="text-center">{{ category.status == 1 ? 'Active' : 'Inactive' }}</td>
                    <td class="text-center">{{ category.created_by.name }}</td>
                    <td class="text-center">{{ category.created_at }}</td>
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
            <button type="button" class="close" @click="modalShow = false" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
             <form>
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" v-model="form.name" class="form-control">
                </div>
                 <div class="form-group">
                      <label for="slug">Slug</label>
                      <input type="text" v-model="slug" id="slug" class="form-control" :class="errors.slug ? 'is-invalid' : ''">
                  </div>  
                <div class="form-group">
                    <label for="parent_id">Parent</label>
                    <select class="form-control" name="parent" id="parent_id">
                        <option value="">Laptop</option>
                    </select>
                </div>
            </form>
          </div>  
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="modalShow = false" data-dismiss="modal" >Close</button>
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
    name: 'Category',
    data(){
      return{
        editMode: false,
        modalShow: false,
        modalTitle: '',
        tableData: [],
        form:{
          name: '',
          slug: '',
          parent_id: ''
        },
        errors:{},
        pagination:{
          current_page: 1,
        }
      }
    },
    created(){
      this.getData();
    },
    computed:{
       slug(){
        return this.form.slug = this.generateSlug(this.form.name);
      }
    },
    methods:{
      addItem(){
        this.modalTitle = "Category Create";
        this.modalShow = true;
      },
      getData(){
        axios.get('categories?page=' + this.pagination.current_page)
        .then(res => {
          this.tableData = res.data.data
        })
        .catch(error => {
          console.log(error);
        })  
      },
      generateSlug(string)
      {
        return string.toString()
        .trim()
        .toLowerCase()
        .replace(/\s+/g,"-")
        .replace(/[^\w\-]+/g,"")
        .replace(/\-\-+/g,"-")
        .replace(/^-+/,"")
        .replace(/-+$/,"");
      }
    }
}
</script>

<style>

</style>