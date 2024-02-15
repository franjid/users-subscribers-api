<template>
  <div>
    <input v-model="email" type="email" placeholder="Email">
    <input v-model="name" type="text" placeholder="Name">
    <input v-model="lastName" type="text" placeholder="Last Name">
    <button @click="addUser">Add</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: '',
      name: '',
      lastName: ''
    };
  },
  methods: {
    async addUser() {
      const uuid = this.generateUUID();
      const userData = {
        uuid,
        email: this.email,
        name: this.name,
        lastName: this.lastName
      };
      try {
        const response = await fetch('/api/users', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(userData)
        });
        if (response.ok) {
          this.$emit('user-added');
          this.resetForm();
        } else {
          console.error('Failed to add user:', response.statusText);
        }
      } catch (error) {
        console.error('Error adding user:', error);
      }
    },
    generateUUID() {
      return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        const r = Math.random() * 16 | 0,
            v = c === 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
      });
    },
    resetForm() {
      this.email = '';
      this.name = '';
      this.lastName = '';
    }
  }
}
</script>
