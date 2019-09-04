<template>
  <div>
    

    
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">المستخدم</th>
      <th scope="col">الطبيب</th>
      <th scope="col">التعليق</th>
      <th scope="col">العمليات</th>
    </tr>
  </thead>
  <tbody>


      
    
      <tr v-for="comment in comments" v-bind:key="comment.id">
        <th scope="row">{{ comment.id }}</th>
        <td>{{ comment.user.name_ar }}</td>
        <td>{{ comment.doctor.name_ar }}</td>
        <td>{{ comment.text }}</td>
        <td><button @click="deleteComment(comment.id,auth_user_id)" class="btn btn-danger"><i class="fas fa-trash"></i></button></td>
      </tr>
     
  </tbody>
</table>


    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchComments(pagination.prev_page_url)">السابق</a></li>

        <li class="page-item disabled"><a class="page-link text-dark" href="#">صفحة {{ pagination.current_page }} من أصل {{ pagination.last_page }}</a></li>
    
        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchComments(pagination.next_page_url)">التالى</a></li>
      </ul>
    </nav>
    
  </div>
</template>

<script>
export default {
  props: ['auth_user_id'],
  data() {
    return {
      comments: [],
      comment_id: '',
      pagination: {},
    };
  },
  created() {
    this.fetchComments();
  },
  methods: {
    fetchComments(page_url) { 
      let vm = this;
      page_url = page_url || '../public/api/allcomments';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.comments = res.data;
          console.log(this.comments);
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
    deleteComment(id,user_id) {
      if (confirm('Are You Sure?')) {
        fetch(`../public/api/deletecomment/${id}/${user_id}`, {
          method: 'post',
        })
          .then(res => res.json())
          .then(data => {
            alert('Comment Removed');
            this.fetchComments();
          })
          .catch(err => console.log(err));
      }
    },
  }
};
</script>