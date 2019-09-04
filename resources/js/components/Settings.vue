<template>
  <div>
    <form @submit.prevent="updateSettings" class="mb-3">
      <div class="form-group">
        <textarea class="form-control" placeholder="عن الموقع باللغة العربية" v-model="settings.about_ar"></textarea>
      </div>
      <div class="form-group">
        <textarea class="form-control" placeholder="عن الموقع باللغة الإنجليزية" v-model="settings.about_en"></textarea>
      </div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Facebook" v-model="settings.facebook">
      </div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Twitter" v-model="settings.twitter">
      </div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Instagram" v-model="settings.instagram">
      </div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Youtube" v-model="settings.youtube">
      </div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Google+" v-model="settings.google_plus">
      </div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Phone" v-model="settings.phone">
      </div>
      <div class="form-group">
        <textarea class="form-control" placeholder="شروط التسجيل" v-model="settings.conditions"></textarea>
      </div>
      <div class="form-group">
        <select class="form-control" v-model="psys">
          <option disabled value="">نظام الدفع</option>
          <option value="1">عدد الأشهر</option>
          <option value="2">عدد الطلبات</option>
        </select>
      </div>
      <div v-if="settings.months !=  null || psys == 1">
        <div class="form-group">
          <input type="number" class="form-control" placeholder="عدد الأشهر" v-model="settings.months">
        </div>
      </div>
      <div v-if="settings.order_no !=  null || psys == 2">
        <div class="form-group">
          <input type="number" class="form-control" placeholder="عدد الطلبات" v-model="settings.order_no">
        </div>
      </div>
      
      <div class="form-group">
        <input type="number" class="form-control" placeholder="العمولة" v-model="settings.commission">
      </div>

      <button type="submit" class="btn btn-light btn-block">Save</button>
    </form>
  </div>
</template>

<script>
export default {
  props: ['settings'],  
  data() {
    return {
      settings_id: 1,
      psys: ''
    };
  },
  methods: {
    updateSettings() {
        // Update
        fetch('../public/api/updatesettings/1', {
          method: 'post',
          body: JSON.stringify(this.settings),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            alert('Settings Updated');
          })
          .catch(err => console.log(err));
      },
  }
};
</script>