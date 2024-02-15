<template>
  <div class="user">
    <h3>{{ user.name }} {{ user.lastName }}</h3>
    <p>UUID: {{ user.uuid }}</p>
    <p>Email: {{ user.email }}</p>
  </div>
</template>

<script>
export default {
  name: 'UserItem',
  props: {
    user: Object
  }
}
</script>
