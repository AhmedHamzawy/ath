<template>
  <div>
   
<!-- Modal -->
<div class="modal fade" id="addState" tabindex="-1" role="dialog" aria-labelledby="addStateLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStateLabel">إضافة حالة جديدة</h5>
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
    <form @submit.prevent="addState" class="mb-3">
      <div class="form-group">
        <input type="text" name="name_ar" v-validate="'required'" class="form-control" placeholder="الإسم باللغة العربية" v-model="state.name_ar">
        <span>{{ errors.first('name_ar') }}</span>
      </div>
      <div class="form-group">
        <input type="text" name="name_en" v-validate="'required'" class="form-control" placeholder="الإسم باللغة الإنجليزية" v-model="state.name_en">
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

    
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">الإسم باللغة العربية</th>
      <th scope="col">الإسم باللغة الإنجليزية</th>
      <th scope="col">العمليات</th>
    </tr>
  </thead>
  <tbody>


      
    
      <tr v-for="state in states" v-bind:key="state.id">
        <th scope="row">{{ state.id }}</th>
        <td>{{ state.name_ar }}</td>
        <td>{{ state.name_en }}</td>
        <td> <button @click="editState(state)" data-toggle="modal" data-target="#addState" class="btn btn-warning"><i class="fas fa-edit"></i></button>
        <button @click="deleteState(state.id,auth_user_id)" class="btn btn-danger"><i class="fas fa-trash"></i></button>
        </td>
      </tr>
     
  </tbody>
</table>


    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchStates(pagination.prev_page_url)">السابق</a></li>

        <li class="page-item disabled"><a class="page-link text-dark" href="#">الصفحة {{ pagination.current_page }} من أصل {{ pagination.last_page }}</a></li>
    
        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchStates(pagination.next_page_url)">التالى</a></li>
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
      states: [],
      state: {
        id: '',
        name_ar: '',
        name_en: '',
        user_add: this.auth_user_id
      },
      state_id: '',
      pagination: {},
      edit: false
    };
  },
  created() {
    this.fetchStates();
  },
  methods: {
    fetchStates(page_url) {
      let vm = this;
      page_url = page_url || '../public/api/getstates';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.states = res.data;
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
    deleteState(id,user_id) {
      if (confirm('هل أنت متأكد ؟')) {
        fetch(`../public/api/deletestate/${id}/${user_id}`, {
          method: 'post',
        })
          .then(res => res.json())
          .then(data => {
            alert('تم حذف الحالة');
            this.fetchStates();
          })
          .catch(err => console.log(err));
      }
    },
    addState() {
      if (this.edit === false) {
        // Add
        if(this.validation()){
        fetch('../public/api/addstate', {
          method: 'post',
          body: JSON.stringify(this.state),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('تم إضافة حالة جديدة');
            $('#addState').modal('hide');
            $('.modal-backdrop').remove();
            this.fetchStates();
          })
          .catch(err => console.log(err));}}
       else {
        // Update
        fetch('../public/api/updatestate', {
          method: 'post',
          body: JSON.stringify(this.state),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('تم التعديل على الحالة');
            $('#addState').modal('hide');
            $('.modal-backdrop').remove();
            this.fetchStates();
          })
          .catch(err => console.log(err));
      }
    },
    editState(state) {
      this.edit = true;
      this.state.id = state.id;
      this.state.state_id = state.id;
      this.state.name_ar = state.name_ar;
      this.state.name_en = state.name_en;
    },
    clearForm() {
      this.edit = false;
      this.state.id = null;
      this.state.state_id = null;
      this.state.name_ar = '';
      this.state.name_en = '';
    },
    validation(){
      this.verrors = [];
      if(this.state.name_ar === ''){this.verrors.push('الرجاء إدخال الإسم باللغة العربية');}
      if(this.state.name_en === ''){this.verrors.push('الرجاء إدخال الإسم باللغة الإنجليزية');}
      return this.verrors.length > 0 ? false : true;
    }
  }
};
</script>