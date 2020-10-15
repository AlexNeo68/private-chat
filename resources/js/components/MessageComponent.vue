<template>
  <div class="card chat-box">
    <div class="card-header d-flex justify-content-between items-center">
      <span>
        <span :class="{ 'text-danger': block }">
          {{ friend.name }} <span v-if="block">(Blocked)</span></span
        >
      </span>
      <span>
        <a
          href="#"
          class="mr-2"
          id="dropdownMenuButton"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          <i class="fas fa-ellipsis-v"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="#" @click.prevent="block = !block">{{
            this.block ? "UnBlock" : "Block"
          }}</a>
          <a class="dropdown-item" href="#" @click.prevent="chats = []"
            >Clear</a
          >
        </div>
        <a href="#" @click.prevent="$emit('close')"
          ><i class="far fa-window-close"></i
        ></a>
      </span>
    </div>

    <div class="card-body" v-chat-scroll>
      <div v-for="(chat, index) in chats" :key="`chat-${index}`">
        <div class="card-text">{{ chat.message }}</div>
      </div>
    </div>
    <div class="card-footer">
      <form class="form" @submit.prevent="send">
        <div class="form-group">
          <input
            type="text"
            :disabled="block"
            class="form-control"
            placeholder="Type your message here ..."
          />
        </div>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  name: "MessageComponent",
  props: ["friend"],
  data() {
    return {
      chats: [],
      block: false,
    };
  },
  created() {
    this.chats.push({ message: "Hello!" });
    this.chats.push({ message: "Hi!" });
    this.chats.push({ message: "How are you?" });
    this.chats.push({ message: "Fine, and you?" });
    this.chats.push({ message: "I`m fine too, thanks!" });
    this.chats.push({ message: "I`s great!" });
    this.chats.push({ message: "Hello!" });
    this.chats.push({ message: "Hi!" });
    this.chats.push({ message: "How are you?" });
    this.chats.push({ message: "Fine, and you?" });
    this.chats.push({ message: "I`m fine too, thanks!" });
    this.chats.push({ message: "I`s great!" });
    this.chats.push({ message: "Hello!" });
    this.chats.push({ message: "Hi!" });
    this.chats.push({ message: "How are you?" });
    this.chats.push({ message: "Fine, and you?" });
    this.chats.push({ message: "I`m fine too, thanks!" });
    this.chats.push({ message: "I`s great!" });
    this.chats.push({ message: "Hello!" });
    this.chats.push({ message: "Hi!" });
    this.chats.push({ message: "How are you?" });
    this.chats.push({ message: "Fine, and you?" });
    this.chats.push({ message: "I`m fine too, thanks!" });
    this.chats.push({ message: "I`s great!" });
    this.chats.push({ message: "Hello!" });
    this.chats.push({ message: "Hi!" });
    this.chats.push({ message: "How are you?" });
    this.chats.push({ message: "Fine, and you?" });
    this.chats.push({ message: "I`m fine too, thanks!" });
    this.chats.push({ message: "I`s great!" });
    this.chats.push({ message: "it is bottom" });
  },
  methods: {
    send() {
      console.log("Send Ha Ha");
    },
  },
};
</script>
<style scoped>
.chat-box {
  height: 400px;
}
.card-body {
  overflow-y: scroll;
}
</style>
