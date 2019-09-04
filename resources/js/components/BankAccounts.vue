<template>
  <div>
   

<!-- Modal -->
<div class="modal fade" id="addBankaccount" tabindex="-1" role="dialog" aria-labelledby="addBankaccountLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBankaccountLabel">إضافة حساب بنكى جديد</h5>
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
    <form @submit.prevent="addBankaccount" class="mb-3">
      <div class="form-group">
        <input type="text" name="name" v-validate="'required'" class="form-control" placeholder="إسم البنك" v-model="bankaccount.name">
        <span>{{ errors.first('name') }}</span>
      </div>
      <div class="form-group">
        <input type="text" name="iban" v-validate="'required'" class="form-control" placeholder="رقم حساب البنك" v-model="bankaccount.iban">
        <span>{{ errors.first('iban') }}</span>
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
      <th scope="col">إسم البنك</th>
      <th scope="col">رقم حساب البنك</th>
      <th scope="col">العمليات</th>
    </tr>
  </thead>
  <tbody>


      
    
           <tr v-for="bankaccount in bankaccounts" v-bind:key="bankaccount.id">
      <th scope="row">{{ bankaccount.id }}</th>
      <td>{{ bankaccount.name }}</td>
      <td>{{ bankaccount.iban }}</td>
      <td> <button @click="editBankaccount(bankaccount)" data-toggle="modal" data-target="#addBankaccount" class="btn btn-warning"><i class="fas fa-edit"></i></button>
      <button @click="deleteBankaccount(bankaccount.id,auth_user_id)" class="btn btn-danger"><i class="fas fa-trash"></i></button>
      </td>
    
           </tr>
     
  </tbody>
</table>


    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchBankaccounts(pagination.prev_page_url)">السابق</a></li>

        <li class="page-item disabled"><a class="page-link text-dark" href="#">صفحة {{ pagination.current_page }} من أصل {{ pagination.last_page }}</a></li>
    
        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchBankaccounts(pagination.next_page_url)">التالى</a></li>
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
      bankaccounts: [],
      bankaccount: {
        id: '',
        name: '',
        iban: '',
        user_add: this.auth_user_id
      },
      bankaccount_id: '',
      pagination: {},
      edit: false
    };
  },
  created() {
    this.fetchBankaccounts();
  },
  methods: {
    fetchBankaccounts(page_url) {
      let vm = this;
      page_url = page_url || '../public/api/allbankaccounts';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.bankaccounts = res.data;
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
    deleteBankaccount(id,user_id) {
      if (confirm('Are You Sure?')) {
        fetch(`../public/api/deletebankaccount/${id}/${user_id}`, {
          method: 'post'
        })
          .then(res => res.json())
          .then(data => {
            alert('Bankaccount Removed');
            this.fetchBankaccounts();
          })
          .catch(err => console.log(err));
      }
    },
    addBankaccount() {
      if (this.edit === false) {
        // Add
        if(this.validation()){
        fetch('../public/api/addbankaccount', {
          method: 'post',
          body: JSON.stringify(this.bankaccount),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('تم إضافة حساب بنكى جديد');
            $('#addBankaccount').modal('hide');
            $('.modal-backdrop').remove();
            this.fetchBankaccounts();
          })
          .catch(err => console.log(err));}}
       else {
        // Update
        fetch('../public/api/updatebankaccount', {
          method: 'post',
          body: JSON.stringify(this.bankaccount),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('تم تعديل الحساب البنكى');
            $('#addBankaccount').modal('hide');
            $('.modal-backdrop').remove();
            this.fetchBankaccounts();
          })
          .catch(err => console.log(err));
      }
    },
    editBankaccount(bankaccount) {
      this.edit = true;
      this.bankaccount.id = bankaccount.id;
      this.bankaccount.bankaccount_id = bankaccount.id;
      this.bankaccount.name = bankaccount.name;
      this.bankaccount.iban = bankaccount.iban;

    },
    clearForm() {
      this.edit = false;
      this.bankaccount.name = '';
      this.bankaccount.iban = '';

    },
    validation(){
      this.verrors = [];
      if(this.bankaccount.name === ''){this.verrors.push('الرجاء إدخال الإسم');}
      if(this.bankaccount.iban === ''){this.verrors.push('الرجاء إدخال حساب البنك');}
      
      return this.verrors.length > 0 ? false : true;
    }
  }
};
</script>