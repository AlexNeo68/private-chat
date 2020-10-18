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
          <a class="dropdown-item" href="#" @click.prevent="clear">Clear</a>
        </div>
        <a href="#" @click.prevent="$emit('close')"
          ><i class="far fa-window-close"></i
        ></a>
      </span>
    </div>

    <div class="card-body" v-chat-scroll>
      <div v-for="(chat, index) in chats" :key="`chat-${index}`">
        <div
          class="card-text"
          :class="{ 'text-right': !chat.type, 'text-success': chat.read_at }"
        >
          {{ chat.message }}
          <span v-if="chat.read_at" style="font-size: 9px; display: block">{{
            chat.read_at
          }}</span>
        </div>
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
            v-model="message"
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
      message: null,
    };
  },
  created() {
    this.readSession();
    this.getChats();
    Echo.private(`Chat.${this.friend.session.id}`).listen(
      "PrivateChatEvent",
      (e) => {
        if (this.friend.session.open) this.readSession();
        this.chats.push({
          id: e.chat.id,
          message: e.chat.message.content,
          type: e.chat.type,
          send_at: "just now",
          read_at: null,
        });
      }
    );
    Echo.private(`Chat.${this.friend.session.id}`).listen(
      "MessageReadEvent",
      (e) => {
        console.log(e.chat);
        this.chats.forEach((chat) => {
          if (chat.id == e.chat.id) chat.read_at = e.chat.read_at;
        });
      }
    );
  },
  methods: {
    async clear() {
      try {
        const res = (
          await axios.delete(`/sessions/${this.friend.session.id}/clear`)
        ).data;
        this.chats = [];
      } catch (error) {
        console.log(error);
      }
    },
    async readSession() {
      try {
        const res = (
          await axios.get(`/sessions/${this.friend.session.id}/read`)
        ).data;
      } catch (error) {
        console.log(error);
      }
    },
    async getChats() {
      try {
        const res = (
          await axios.get(`/sessions/${this.friend.session.id}/chats`)
        ).data;
        this.chats = res.data;
      } catch (error) {
        console.log(error);
      }
    },
    async send() {
      try {
        const res = (
          await axios.post(`/sessions/${this.friend.session.id}/chats`, {
            content: this.message,
            userTo: this.friend.id,
          })
        ).data;
        this.chats.push({
          id: res,
          message: this.message,
          type: 0,
          send_at: "just now",
          read_at: null,
        });
        this.message = null;
      } catch (error) {
        console.log(error);
      }
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
