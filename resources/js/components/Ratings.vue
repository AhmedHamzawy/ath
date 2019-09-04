<template>
  <div>
    

    
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">الطبيب</th>
      <th scope="col">التقييم</th>
    </tr>
  </thead>
  <tbody>


      
    
      <tr v-for="rating in ratings" v-bind:key="rating.id">
        <th scope="row">{{ rating.id }}</th>
        <td>{{ rating.doctor.name_ar }}</td>
        <td>{{ rating.rating }}</td>
      </tr>
     
  </tbody>
</table>


    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchRatings(pagination.prev_page_url)">السابق</a></li>

        <li class="page-item disabled"><a class="page-link text-dark" href="#">صفحة {{ pagination.current_page }} من أصل {{ pagination.last_page }}</a></li>
    
        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchRatings(pagination.next_page_url)">التالى</a></li>
      </ul>
    </nav>
    
  </div>
</template>

<script>
export default {
  props: ['auth_user_id'],
  data() {
    return {
      ratings: [],
      rating_id: '',
      pagination: {},
    };
  },
  created() {
    this.fetchRatings();
  },
  methods: {
    fetchRatings(page_url) { 
      let vm = this;
      page_url = page_url || '../public/api/allratings';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.ratings = res.data.data;
          console.log(this.ratings);
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
  }
};
</script>