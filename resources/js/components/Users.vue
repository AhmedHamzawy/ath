<template>
  <div>
   

<!-- Modal -->
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUserLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserLabel">إضافة مستخدم جديد</h5>
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
    <form @submit.prevent="addUser" class="mb-3">
     
      <div class="form-group">
        <input type="text" name="name_ar" v-validate="'required'" class="form-control" placeholder="الإسم باللغة العربية" v-model="user.name_ar">
        <span>{{ errors.first('name_ar') }}</span>
      </div>
      <div class="form-group">
        <input type="text" name="name_en" v-validate="'required'" class="form-control" placeholder="الإسم باللغة الإنجليزية" v-model="user.name_en">
        <span>{{ errors.first('name_en') }}</span>
      </div>
      <div class="form-group">
        <input type="text" name="email" v-validate="'required'" class="form-control" placeholder="البريد الإلكترونى" v-model="user.email">
        <span>{{ errors.first('email') }}</span>
      </div>
      <div class="form-group">
        <input type="text" name="mobile" v-validate="'required'" class="form-control" placeholder="رقم الهاتف" v-model="user.mobile">
        <span>{{ errors.first('mobile') }}</span>
      </div>
      <div class="form-group">
       <GmapMap
        :center="{lat:24.774265, lng:46.738586}"
        :zoom="7"
        map-type-id="terrain"
        style="width: 100%; height: 300px"
        >
        <gmap-marker :position="{lat:24.774265, lng:46.738586}" :draggable="true" @drag="updateCoordinates" />
        </GmapMap>
      </div>
      <div class="form-group">
        <input type="text" name="address" v-validate="'required'" class="form-control" placeholder="العنوان" v-model="user.address">
        <span>{{ errors.first('address') }}</span>
      </div>
      <div class="form-group">
        <input type="password" name="password" v-validate="'required'" class="form-control" placeholder="كلمة المرور" v-model="user.password">
        <span>{{ errors.first('password') }}</span>
      </div>
      <div class="form-group">
        <input type="file" ref="image" v-validate="'required'" class="form-control" placeholder="الصورة الشخصية" @change="onImageChange">
        <span>{{ errors.first('image') }}</span>
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

    <h2>المستخدمين</h2>
    
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


      
    
           <tr v-for="user in users" v-bind:key="user.id">
      <th scope="row">{{ user.id }}</th>
      <td>{{ user.name_ar }}</td>
      <td>{{ user.name_en }}</td>
      <td> <button @click="editUser(user)" data-toggle="modal" data-target="#addUser" class="btn btn-warning"><i class="fas fa-edit"></i></button>
      <button @click="deleteUser(user.id)" class="btn btn-danger"><i class="fas fa-trash"></i></button>
      </td>
    
           </tr>
     
  </tbody>
</table>


    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchUsers(pagination.prev_page_url)">السابق</a></li>

        <li class="page-item disabled"><a class="page-link text-dark" href="#">الصفحة {{ pagination.current_page }} من أصل {{ pagination.last_page }}</a></li>
    
        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchUsers(pagination.next_page_url)">التالى</a></li>
      </ul>
    </nav>
    
  </div>
</template>

<script>
export default {
  data() {
    return {
      verrors: [],
      users: [],
      user: {
        id: '',
        name_ar: '',
        name_en: '',
        email: '',
        mobile: '',
        lat: '',
        lon: '',
        address: '',
      },
      user_id: '',
      pagination: {},
      edit: false
    };
  },
  created() {
    this.fetchUsers();
  },
  methods: {
    fetchUsers(page_url) { 
      let vm = this;
      page_url = page_url || '../public/api/allusers';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.users = res.data;
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
    deleteUser(id) {
      if (confirm('هل أنت متأكد ؟')) {
        fetch(`../public/api/deleteuser/${id}`, {
          method: 'post'
        })
          .then(res => res.json())
          .then(data => {
            alert('تم حذف المستخدم');
            this.fetchUsers();
          })
          .catch(err => console.log(err));
      }
    },
    addUser() {
      this.user.lat = this.coordinates.lat;
      this.user.lon = this.coordinates.lng;
      if (this.edit === false) {
        // Add
        if(this.validation()){
        fetch('../public/api/adduser', {
          method: 'post',
          body: JSON.stringify(this.user),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('تم إضافة المستخدم');
            $('#addUser').modal('hide');
            $('.modal-backdrop').remove();
            this.fetchUsers();
          })
          .catch(err => console.log(err));}}
       else {
        // Update
        fetch('../public/api/updateuser', {
          method: 'post',
          body: JSON.stringify(this.user),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('تم التعديل على بيانات المستخدم');
            $('#addUser').modal('hide');
            $('.modal-backdrop').remove();
            this.fetchusers();
          })
          .catch(err => console.log(err));
      }
    },
    editUser(user) {
      this.edit = true;
      this.user.id = user.id;
      this.user.user_id = user.id;
      this.user.name_ar = user.name_ar;
      this.user.name_en = user.name_en;
      this.user.email = user.email;
      this.user.mobile = user.mobile;
      this.user.lat = user.lat;
      this.user.lon = user.lon;
      this.user.address = user.address;
    },
   onImageChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length)
          return;
      this.createImage(files[0]);
    },
    createImage(file) {
      let reader = new FileReader();
      reader.onload = (e) => {
          this.user.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    clearForm() {
      this.edit = false;
      this.user.id = null;
      this.user.user_id = null;
      this.user.service_id = null;
      this.user.name_ar = '';
      this.user.name_en = '';
      this.user.email = '';
      this.user.mobile = '';
      this.user.lat = '';
      this.user.lon = '';
      this.user.address = '';
    },
    validation(){
      this.verrors = [];
      if(this.user.name_ar === ''){this.verrors.push('الرجاء إدخال الإسم باللغة العربية');}
      if(this.user.name_en === ''){this.verrors.push('الرجاء إدخال الإسم باللغة الإنجليزية');}
      if(this.user.email === ''){this.verrors.push('الرجاء إدخال البريد الإلكترونى');}
      if(this.user.mobile === ''){this.verrors.push('الرجاء إدخال  رقم الهاتف');}
      if(this.user.lat === ''){this.verrors.push('الرجاء إدخال خط الطول');}
      if(this.user.lon === ''){this.verrors.push('الرجاء إدخال دائرة العرض');}
      if(this.user.address === ''){this.verrors.push('الرجاء إدخال العنوان');}

      return this.verrors.length > 0 ? false : true;
    },
    updateCoordinates(location) {
      this.coordinates = {
          lat: location.latLng.lat(),
          lng: location.latLng.lng(),
      };
    }
  },
  
};
</script>