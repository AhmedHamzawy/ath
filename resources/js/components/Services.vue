<template>
  <div>
<!-- Modal -->
<div class="modal fade" id="addService" tabindex="-1" role="dialog" aria-labelledby="addServiceLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addServiceLabel">إضافة خدمة جديدة</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p v-if="verrors.length">
    <b>الرجاء قم بتصحيح الأخطاء التالية :</b>
    <ul>
      <li v-for="error in verrors" :key="error">{{ error }}</li>
    </ul>
    </p>
    <form @submit.prevent="addService" class="mb-3">
      <div class="form-group">
        <input type="text" name="name_ar" v-validate="'required'" class="form-control" placeholder="الإسم باللغة العربية" v-model="service.name_ar">
        <span>{{ errors.first('name_ar') }}</span>
      </div>
      <div class="form-group">
        <input type="text" name="name_en" v-validate="'required'" class="form-control" placeholder="الإسم باللغة الإنجليزية" v-model="service.name_en">
        <span>{{ errors.first('name_en') }}</span>
      </div>
      <div class="modal-footer">
        <button type="button" @click="clearForm()" data-dismiss="modal" class="btn btn-danger btn-block">إلغاء</button>
        <button type="submit" class="btn btn-light btn-block">إضافة</button>
      </div>
    </form>
      </div>
    </div>
  </div>
</div>
    
    <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">الإسم باللغة العربية</th>
      <th scope="col">الإسم باللغة الإنجليزية</th>
      <th scope="col">العمليات</th>
    </tr>
  </thead>
  <tbody>


      
    
           <tr v-for="service in services" v-bind:key="service.id">
      <th scope="row">{{ service.id }}</th>
      <td>{{ service.name_ar }}</td>
      <td>{{ service.name_en }}</td>
      <td>  <button @click="editService(service)" data-toggle="modal" data-target="#addService" class="btn btn-warning"><i class="fas fa-edit"></i></button>
        <button @click="deleteService(service.id,auth_user_id)" class="btn btn-danger"><i class="fas fa-trash"></i></button>
      </td>
    
           </tr>
     
  </tbody>
</table>


    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchServices(pagination.prev_page_url)">Previous</a></li>

        <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
    
        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchServices(pagination.next_page_url)">Next</a></li>
      </ul>
    </nav>
    
  </div>
</template>

<script>
export default {
  props: ['auth_user_id'],
  data() {
    return {
      verrors: [],
      services: [],
      service: {
        id: '',
        name_ar: '',
        name_en: '',
        user_add: this.auth_user_id
      },
      service_id: '',
      pagination: {},
      edit: false
    };
  },
  created() {
    this.fetchServices();
  },
  methods: {
    fetchServices(page_url) {
      let vm = this;
      page_url = page_url || '../public/api/allservices';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.services = res.data;
          vm.makePagination(res.meta, res.links);
        })
        .catch(err => console.log(err));
    },
    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev
      };
      this.pagination = pagination;
    },
    deleteService(id,user_id) {
      if (confirm('هل أنت متأكد ؟')) {
        fetch(`../public/api/deleteservice/${id}/${user_id}`, {
          method: 'post'
        })
          .then(res => res.json())
          .then(data => {
            alert('تم حذف الخدمة');
            this.fetchServices();
          })
          .catch(err => console.log(err));
      }
    },
    addService() {
      if (this.edit === false) {
        // Add
        if(this.validation()){
        fetch('../public/api/addservice', {
          method: 'post',
          body: JSON.stringify(this.service),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('تم إضافة خدمة جديدة');
            $('#addService').modal('hide');
            $('.modal-backdrop').remove();
            this.fetchServices();
          })
          .catch(err => console.log(err));}}
       else {
        // Update
        fetch('../public/api/updateservice', {
          method: 'post',
          body: JSON.stringify(this.service),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('تم التعديل على الخدمة');
            $('#addService').modal('hide');
            $('.modal-backdrop').remove();
            this.fetchServices();
          })
          .catch(err => console.log(err));
      }
    },
    editService(service) {
      this.edit = true;
      this.service.id = service.id;
      this.service.service_id = service.id;
      this.service.name_ar = service.name_ar;
      this.service.name_en = service.name_en;
    },
    clearForm() {
      this.edit = false;
      this.service.id = null;
      this.service.service_id = null;
      this.service.name_ar = '';
      this.service.name_en = '';
    },
    validation(){
      this.verrors = [];
      if(this.service.name_ar === ''){this.verrors.push('الرجاء إدخال الإسم باللغة العربية');}
      if(this.service.name_en === ''){this.verrors.push('الرجاء إدخال الإسم باللغة الإنجليزية');}
      return this.verrors.length > 0 ? false : true;
    }
  }
};
</script>