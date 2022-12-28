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
                <input type="text" id="name" v-model="query.name" class="form-control" placeholder="Search Category Name">
              </div>
              <div class="form-group col-md-8 text-right">
                  <button type="button" @click="searchData" class="btn btn-info mr-2">
                    <i class="fas fa-search"></i>
                  </button>
                  <button type="button" @click="reload" class="btn btn-warning">
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
                      <button type="button" class="btn btn-primary btn-sm mr-2" @click="editItem(category)"><i class="fa fa-edit"></i></button>
                      <button type="button" class="btn btn-danger btn-sm" @click="deleteItem(category)"><i class="fa fa-trash-alt"></i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <br>
               <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="getData()"/>
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
                    <input type="text" v-model="form.name" class="form-control" :class="errors.name ? 'is-invalid' : ''">
                    <small v-if="errors.name" class="text-danger">{{errors.name[0]}}</small>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" v-model="slug" id="slug" class="form-control" :class="errors.slug ? 'is-invalid' : ''">
                    <small v-if="errors.slug" class="text-danger">{{errors.slug[0]}}</small>
                </div>  
                <div class="form-group">
                    <label for="parent_id">Parent</label>
                    <select v-model="form.parent_id" class="form-control" name="parent_id" id="parent_id" :class="errors.parent_id ? 'is-invalid' : ''">
                        <option value="0">Select One</option>
                        <option v-for="(category, i) in categoryData" :key="i" :value="category.id">{{ category.name }}</option>
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
import Pagination from './../Components/Pagination.vue'
export default {
    name: 'Category',
    components:{
      Pagination,
    },
    data(){
      return{
        editMode: false,
        modalShow: false,
        modalTitle: '',
        tableData: [],
        categoryData: [],
        form:{
          name: '',
          slug: '',
          parent_id: ''
        },
        query:{
          name: ""
        },
        errors:{},
        pagination:{
          current_page: 1,
        }
      }
    },
    created(){
      this.getData();
      this.categoryList();
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
        this.editMode = false;
        this.errors = {};
        this.form = {
          name: '',
          slug: '',
          parent_id: '',
        }
      },
      save(){
        axios.post('categories', this.form)
        .then(res => {
            Toast.fire({
                icon: res.data.status === true ? 'success' : 'error',
                title:res.data.message
            });
            if(res.data.status == true){
              this.getData();
              this.modalShow = false;
              this.categoryData();
            }
        })
        .catch(e => {
          this.errors = e.response.data.errors;
        });
      },
      editItem(data){
        this.errors = {};
        this.editMode = true;
        this.modalShow = true;
        this.form = {
          id: data.id,
          name: data.name,
          slug: data.slug,
          parent_id: data.parent_id,
        };
        this.modalTitle = "Edit "+ data.name;
      },
      update(){
        axios.put('categories/'+this.form.id, this.form)
        .then(res => {
            Toast.fire({
                icon: res.data.status === true ? 'success' : 'error',
                title: res.data.message
            });
            if(res.data.status === true){
              this.getData();
              this.modalShow = false;
            }
        })
        .catch(error => {
          this.error = error.response.data.errors;
        })
      },
      getData(){
        axios.get('categories?page=' + this.pagination.current_page)
        .then(res => {
          this.tableData = res.data.data;
          this.pagination = res.data.meta;
        })
        .catch(error => {
          console.log(error);
        })  
      },
      searchData(){
        const query = $.param(this.query);
        axios.get('categories?page=' + this.pagination.current_page+'&'+query)
        .then(res => {
          this.tableData = res.data.data;
          his.pagination = res.data.meta;
        })
        .catch(error => {
          console.log(error);
        })
      },
      reload(){
        this.query.name = '';
        this.getData();
      },
      categoryList(){
        axios.get('category-list')
        .then(res => {
          this.categoryData = res.data.data
        })
        .catch(error => {
          console.log(error);
        })  
      },
      deleteItem(item){
        Swal.fire({
          title: `Are you sure to delete ${item.name}?`,
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes!'
        }).then((result) => {
          if (result.isConfirmed) {
            axios.delete("categories/"+item.id)
              .then(res => {
                  Toast.fire({
                      icon: res.data.status === true ? 'success' : 'error',
                      title:res.data.message
                  });
                  if(res.data.status === true)
                  {
                    this.getData();
                    this.modalShow = false;
                  }
              })
              .catch(error => {
                this.errors = error.response.data.errors;
              })
          }
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