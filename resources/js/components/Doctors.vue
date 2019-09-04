<template>
  <div>
   

<!-- Modal -->
<div class="modal fade" id="addDoctor" tabindex="-1" role="dialog" aria-labelledby="addDoctorLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addDoctorLabel">إضافة طبيب جديد</h5>
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
    <form @submit.prevent="addDoctor" class="mb-3">
      <div class="form-group">
        <select class="form-control" name="hospital_id" v-validate="'required'" v-model="doctor.hospital_id">
          <option selected disabled>...اختر المستشفى</option>
          <option v-for="hospital in hospitals" :key="hospital.id" :value="hospital.id" >{{ hospital.name_ar }}</option>
        </select>
        <span>{{ errors.first('hospital_id') }}</span>
      </div>
      <div class="form-group">
        <select class="form-control" name="service_id" v-validate="'required'" v-model="doctor.service_id">
          <option selected disabled>...اختر الخدمة</option>
          <option v-for="service in services" :key="service.id" :value="service.id" >{{ service.name_ar }}</option>
        </select>
        <span>{{ errors.first('service_id') }}</span>
      </div>
      <div class="form-group">
        <input type="text" name="name_ar" v-validate="'required'" class="form-control" placeholder="الإسم باللغة العربية" v-model="doctor.name_ar">
        <span>{{ errors.first('name_ar') }}</span>
      </div>
      <div class="form-group">
        <input type="text" name="name_en" v-validate="'required'" class="form-control" placeholder="الإسم باللغة الإنجليزية" v-model="doctor.name_en">
        <span>{{ errors.first('name_en') }}</span>
      </div>
       <div class="form-group">
        <input type="text" name="certificate" v-validate="'required'" class="form-control" placeholder="الشهادات" v-model="doctor.certificate">
        <span>{{ errors.first('certificate') }}</span>
      </div>
       <div class="form-group">
        <input type="text" name="dateofbirth" v-validate="'required'" class="form-control" placeholder="تاريخ الميلاد" v-model="doctor.dateofbirth">
        <span>{{ errors.first('dateofbirth') }}</span>
      </div>
       <div class="form-group">
        <input type="text" name="cost" v-validate="'required'" class="form-control" placeholder="التكلفة" v-model="doctor.cost">
        <span>{{ errors.first('cost') }}</span>
      </div>
       <div class="form-group">
        <input type="text" name="description_ar" v-validate="'required'" class="form-control" placeholder="الوصف باللغة العربية" v-model="doctor.description_ar">
        <span>{{ errors.first('description_ar') }}</span>
      </div>
       <div class="form-group">
        <input type="text" name="description_en" v-validate="'required'" class="form-control" placeholder="الوصف باللغة الإنجليزية" v-model="doctor.description_en">
        <span>{{ errors.first('description_en') }}</span>
      </div>
      <div class="form-group">
        <input type="file" ref="image" v-validate="'required'" class="form-control" placeholder="الصورة الشخصية" @change="onImageChange">
        <span>{{ errors.first('image') }}</span>
      </div>
      <div class="form-group">
        <select class="form-control" name="status_id" v-validate="'required'" v-model="doctor.status_id">
          <option selected disabled>...اختر الخدمة</option>
          <option v-for="status in statuses" :key="status.id" :value="status.id" >{{ status.name_ar }}</option>
        </select>
        <span>{{ errors.first('service_id') }}</span>
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


      
    
      <tr v-for="doctor in doctors" v-bind:key="doctor.id">
      <th scope="row">{{ doctor.id }}</th>
      <td>{{ doctor.name_ar }}</td>
      <td>{{ doctor.name_en }}</td>
      <td> <button @click="editDoctor(doctor)" data-toggle="modal" data-target="#addDoctor" class="btn btn-warning"><i class="fas fa-edit"></i></button>
      <button @click="deleteDoctor(doctor.id)" class="btn btn-danger"><i class="fas fa-trash"></i></button>
      </td>
      </tr>
     
  </tbody>
</table>


    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchDoctors(pagination.prev_page_url)">السابق</a></li>

        <li class="page-item disabled"><a class="page-link text-dark" href="#">صفحة {{ pagination.current_page }} من أصل {{ pagination.last_page }}</a></li>
    
        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchDoctors(pagination.next_page_url)">التالى</a></li>
      </ul>
    </nav>
    
  </div>
</template>

<script>
export default {
  props: ['hospitals','services','statuses'],
  data() {
    return {
      verrors: [],
      doctors: [],
      doctor: {
        id: '',
        hospital_id: '',
        service_id: '',
        name_ar: '',
        name_en: '',
        certificate: '',
        dateofbirth: '',
        cost: '',
        image: '',
        description_ar: '',
        description_en: '',
        status_id: '',
      },
      doctor_id: '',
      pagination: {},
      edit: false
    };
  },
  created() {
    this.fetchDoctors();
  },
  methods: {
    fetchDoctors(page_url) {
      let vm = this;
      page_url = page_url || '../public/api/alldoctors';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.doctors = res.data;
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
    deleteDoctor(id) {
      if (confirm('هل أنت متأكد ؟')) {
        fetch(`../public/api/deletedoctor/${id}`, {
          method: 'post'
        })
          .then(res => res.json())
          .then(data => {
            alert('تم حذف الطبيب');
            this.fetchDoctors();
          })
          .catch(err => console.log(err));
      }
    },
    addDoctor() {
      if (this.edit === false) {
        // Add
        if(this.validation()){
        fetch('../public/api/adddoctor', {
          method: 'post',
          body: JSON.stringify(this.doctor),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('تم إضافة الطبيب');
            $('#addDoctor').modal('hide');
            $('.modal-backdrop').remove();
            this.fetchDoctors();
          })
          .catch(err => console.log(err));}}
       else {
        // Update
        fetch('../public/api/updatedoctor', {
          method: 'post',
          body: JSON.stringify(this.doctor),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('تم التعديل على بيانات الطبيب');
            $('#addDoctor').modal('hide');
            $('.modal-backdrop').remove();
            this.fetchDoctors();
          })
          .catch(err => console.log(err));
      }
    },
    editDoctor(doctor) {
      this.edit = true;
      this.doctor.id = doctor.id;
      this.doctor.doctor_id = doctor.id;
      this.doctor.hospital_id = doctor.hospital_id;
      this.doctor.service_id = doctor.service_id;
      this.doctor.name_ar = doctor.name_ar;
      this.doctor.name_en = doctor.name_en;
      this.doctor.certificate = doctor.certificate;
      this.doctor.dateofbirth = doctor.dateofbirth;
      this.doctor.cost = doctor.cost;
      this.doctor.image = doctor.image;
      this.doctor.description_ar = doctor.description_ar;
      this.doctor.description_en = doctor.description_en;
      this.doctor.status_id = doctor.status_id;

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
          this.doctor.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    clearForm() {
      this.edit = false;
      this.doctor.id = null;
      this.doctor.doctor_id = null;
      this.doctor.hospital_id = null;
      this.doctor.service_id = null;
      this.doctor.name_ar = '';
      this.doctor.name_en = '';
      this.doctor.certificate = '';
      this.doctor.dateofbirth = '';
      this.doctor.cost = '';
      this.doctor.image = '';
      this.doctor.description_ar = '';
      this.doctor.description_en = '';
      this.doctor.status_id = null;

    },
    validation(){
      this.verrors = [];
      if(this.doctor.hospital_id === ''){this.verrors.push('الرجاء اختيار المستشفى');}
      if(this.doctor.service_id === ''){this.verrors.push('الرجاء اختيار الخدمة');}
      if(this.doctor.name_ar === ''){this.verrors.push('الرجاء إدخال الإسم باللغة العربية');}
      if(this.doctor.name_en === ''){this.verrors.push('الرجاء إدخال الإسم باللغة الإنجليزية');}
      if(this.doctor.certificate === ''){this.verrors.push('الرجاء إدخال الشهادات الخاصة به');}
      if(this.doctor.dateofbirth === ''){this.verrors.push('الرجاء إدخال تاريخ الميلاد');}
      if(this.doctor.cost === ''){this.verrors.push('الرجاء إدخال التكلفة ');}
      if(this.doctor.image === ''){this.verrors.push('الرجاء إدخال الصورة');}
      if(this.doctor.description_ar === ''){this.verrors.push('الرجاء إدخال الوصف باللغة العربية');}
      if(this.doctor.description_en === ''){this.verrors.push('الرجاء إدخال الوصف باللغة الإنجليزية');}
      if(this.doctor.status_id === ''){this.verrors.push('الرجاء إدخال  حالة الطبيب');}

      return this.verrors.length > 0 ? false : true;
    }
  }
};
</script>