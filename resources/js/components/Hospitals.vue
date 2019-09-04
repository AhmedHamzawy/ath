<template>
  <div>
    
<!-- Modal -->
<div class="modal fade" id="addHospital" tabindex="-1" role="dialog" aria-labelledby="addHospitalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addHospitalLabel">إضافة مستشفى جديد</h5>
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
    <form @submit.prevent="addHospital" class="mb-3">
      <div class="form-group">
        <select class="form-control" name="service_id" v-validate="'required'" v-model="hospital.service_id">
          <option selected disabled>...اختر الخدمة</option>
          <option v-for="service in services" :key="service.id" :value="service.id" >{{ service.name_ar }}</option>
        </select>
        <span>{{ errors.first('service_id') }}</span>
      </div>
      <div class="form-group">
        <input type="text" name="name_ar" v-validate="'required'" class="form-control" placeholder="الإسم باللغة العربية" v-model="hospital.name_ar">
        <span>{{ errors.first('name_ar') }}</span>
      </div>
      <div class="form-group">
        <input type="text" name="name_en" v-validate="'required'" class="form-control" placeholder="الإسم باللغة الإنجليزية" v-model="hospital.name_en">
        <span>{{ errors.first('name_en') }}</span>
      </div>
      <div class="form-group">
        <input type="text" name="email" v-validate="'required'" class="form-control" placeholder="البريد الإلكترونى" v-model="hospital.email">
        <span>{{ errors.first('email') }}</span>
      </div>
      <div class="form-group">
        <input type="text" name="mobile" v-validate="'required'" class="form-control" placeholder="رقم الهاتف" v-model="hospital.mobile">
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
        <input type="text" name="address" v-validate="'required'" class="form-control" placeholder="العنوان" v-model="hospital.address">
        <span>{{ errors.first('address') }}</span>
      </div>
      <div class="form-group">
        <input type="password" name="password" v-validate="'required'" class="form-control" placeholder="كلمة المرور" v-model="hospital.password">
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


      
    
      <tr v-for="hospital in hospitals" v-bind:key="hospital.id">
      <th scope="row">{{ hospital.id }}</th>
      <td>{{ hospital.name_ar }}</td>
      <td>{{ hospital.name_en }}</td>
      <td> <button @click="editHospital(hospital)" data-toggle="modal" data-target="#addHospital" class="btn btn-warning"><i class="fas fa-edit"></i></button>
      <button @click="deleteHospital(hospital.id)" class="btn btn-danger"><i class="fas fa-trash"></i></button>
      </td>
    
           </tr>
     
  </tbody>
</table>


    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchHospitals(pagination.prev_page_url)">السابق</a></li>

        <li class="page-item disabled"><a class="page-link text-dark" href="#">صفحة {{ pagination.current_page }} من أصل {{ pagination.last_page }}</a></li>
    
        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchHospitals(pagination.next_page_url)">التالى</a></li>
      </ul>
    </nav>
    
  </div>
</template>

<script>
export default {
  props: ['services'],
  data() {
    return {
      verrors: [],
      hospitals: [],
      hospital: {
        id: '',
        service_id: '',
        name_ar: '',
        name_en: '',
        email: '',
        mobile: '',
        lat: '',
        lon: '',
        image: '',
        address: '',
        password: '',
      },
      hospital_id: '',
      pagination: {},
      edit: false
    };
  },
  created() {
    this.fetchHospitals();
  },
  methods: {
    fetchHospitals(page_url) { 
      let vm = this;
      page_url = page_url || '../public/api/allhospitals';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.hospitals = res.data;
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
    deleteHospital(id) {
      if (confirm('هل أنت متأكد ؟')) {
        fetch(`../public/api/deletehospital/${id}`, {
          method: 'post'
        })
          .then(res => res.json())
          .then(data => {
            alert('تم حذف المستشفى');
            this.fetchHospitals();
          })
          .catch(err => console.log(err));
      }
    },
    addHospital() {
      this.hospital.lat = this.coordinates.lat;
      this.hospital.lon = this.coordinates.lng;
      if (this.edit === false) {
        // Add
        if(this.validation()){
        fetch('../public/api/addhospital', {
          method: 'post',
          body: JSON.stringify(this.hospital),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('تم إضافة المستشفى');
            $('#addHospital').modal('hide');
            $('.modal-backdrop').remove();
            this.fetchHospitals();
          })
          .catch(err => console.log(err));}}
       else {
        // Update
        fetch('../public/api/updatehospital', {
          method: 'post',
          body: JSON.stringify(this.hospital),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('تم التعديل على بيانات المستشفى');
            $('#addHospital').modal('hide');
            $('.modal-backdrop').remove();
            this.fetchHospitals();
          })
          .catch(err => console.log(err));
      }
    },
    editHospital(hospital) {
      this.edit = true;
      this.hospital.id = hospital.id;
      this.hospital.hospital_id = hospital.id;
      this.hospital.service_id = hospital.service_id;
      this.hospital.name_ar = hospital.name_ar;
      this.hospital.name_en = hospital.name_en;
      this.hospital.email = hospital.email;
      this.hospital.mobile = hospital.mobile;
      this.hospital.lat = hospital.lat;
      this.hospital.lon = hospital.lon;
      this.hospital.address = hospital.address;
      this.hospital.password = hospital.password;
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
          this.hospital.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    clearForm() {
      this.edit = false;
      this.hospital.id = null;
      this.hospital.hospital_id = null;
      this.hospital.service_id = null;
      this.hospital.name_ar = '';
      this.hospital.name_en = '';
      this.hospital.email = '';
      this.hospital.mobile = '';
      this.hospital.lat = '';
      this.hospital.lon = '';
      this.hospital.image = '';
      this.hospital.address = '';
      this.hospital.password = '';
    },
    validation(){
      this.verrors = [];
      if(this.hospital.service_id === null){this.verrors.push('الرجاء إدخال الخدمة');}
      if(this.hospital.name_ar === ''){this.verrors.push('الرجاء إدخال الإسم باللغة العربية');}
      if(this.hospital.name_en === ''){this.verrors.push('الرجاء إدخال الإسم باللغة الإنجليزية');}
      if(this.hospital.email === ''){this.verrors.push('الرجاء إدخال البريد الإلكترونى');}
      if(this.hospital.mobile === ''){this.verrors.push('الرجاء إدخال  رقم الهاتف');}
      if(this.hospital.lat === ''){this.verrors.push('الرجاء إدخال خط الطول');}
      if(this.hospital.lon === ''){this.verrors.push('الرجاء إدخال دائرة العرض');}
      if(this.hospital.address === ''){this.verrors.push('الرجاء إدخال العنوان');}
      if(this.hospital.password === ''){this.verrors.push('الرجاء إدخال كلمة المرور');}

      return this.verrors.length > 0 ? false : true;
    },
    updateCoordinates(location) {
      this.coordinates = {
          lat: location.latLng.lat(),
          lng: location.latLng.lng(),
      };
    },
  }
};
</script>