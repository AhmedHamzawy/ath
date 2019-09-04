<template>
  <div>
    

    
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">الإسم</th>
      <th scope="col">البريد الإلكترونى</th>
      <th scope="col">محتوى الرسالة</th>
    </tr>
  </thead>
  <tbody>


      
    
      <tr v-for="contact in contacts" v-bind:key="contact.id">
      <th scope="row">{{ contact.id }}</th>
      <td>{{ contact.name }}</td>
      <td>{{ contact.email }}</td>
      <td>{{ contact.text }}</td>
      </tr>
     
  </tbody>
</table>


    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchContacts(pagination.prev_page_url)">Previous</a></li>

        <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
    
        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchContacts(pagination.next_page_url)">Next</a></li>
      </ul>
    </nav>
    
  </div>
</template>

<script>
export default {
  data() {
    return {
      contacts: [],
      contact_id: '',
      pagination: {},
    };
  },
  created() {
    this.fetchContacts();
  },
  methods: {
    fetchContacts(page_url) { 
      let vm = this;
      page_url = page_url || '../public/api/allcontacts';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.contacts = res.data;
          console.log(this.contacts);
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