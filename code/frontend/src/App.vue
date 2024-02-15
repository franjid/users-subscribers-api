<template>
  <div id="app">
    <UserItem v-for="user in users" :key="user.uuid" :user="user" />
    <div class="pagination">
      <button @click="prevPage" :disabled="page === 1">Previous</button>
      <button @click="nextPage" :disabled="page * numResults >= totalUsers">Next</button>
    </div>
  </div>
</template>

<script>
import UserItem from './components/UserItem.vue';

export default {
  name: 'App',
  components: {
    UserItem
  },
  data() {
    return {
      users: [],
      page: 1,
      numResults: 2,
      totalUsers: 0
    };
  },
  created() {
    this.fetchUsers();
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await fetch(`/api/users?page=${this.page}&numResults=${this.numResults}`);
        const data = await response.json();

        this.users = data.results;
        this.totalUsers = data.total;
      } catch (error) {
        console.error('Error fetching users:', error);
      }
    },
    async nextPage() {
      this.page++;
      await this.fetchUsers();
    },
    async prevPage() {
      this.page--;
      await this.fetchUsers();
    }
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

.pagination {
  margin-top: 20px;
}
</style>
