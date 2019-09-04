<template>
  <div>
    

    
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">العميل</th>
      <th scope="col">الطبيب</th>
      <th scope="col">حالة الطبيب</th>
      <th scope="col">التكلفة</th>
    </tr>
  </thead>
  <tbody>


      
    
      <tr v-for="order in orders" v-bind:key="order.id">
      <th scope="row">{{ order.id }}</th>
      <td>{{ order.client.name_ar }}</td>
      <td>{{ order.doctor.name_ar }}</td>
      <td>{{ order.state.name_ar }}</td>
      <td>{{ order.cost }}</td>
      </tr>
     
  </tbody>
</table>


    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchOrders(pagination.prev_page_url)">السابق</a></li>

        <li class="page-item disabled"><a class="page-link text-dark" href="#">الصفحة {{ pagination.current_page }} من أصل {{ pagination.last_page }}</a></li>
    
        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchOrders(pagination.next_page_url)">التالى</a></li>
      </ul>
    </nav>
    
  </div>
</template>

<script>
export default {
  data() {
    return {
      orders: [],
      pagination: {},
    };
  },
  props: ['hospital_id'],
  created() {
    this.fetchOrders();
  },
  methods: {
    fetchOrders(page_url) { 
      let vm = this;
      page_url = page_url || `../api/showhospitalorders/${this.hospital_id}`;
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.orders = res.data;
          console.log(this.orders);
          vm.makePagination(res.meta, res.links);
        })
        .catch(err => console.log(err));
    },
    fetchSettings() { 
      page_url = `../api/getsettings/1`;
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.settings = res.data;
          console.log(this.settings);
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
  }
};
</script>