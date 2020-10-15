<template>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">Private Chat</div>

          <div class="card-body">
            <ul class="list-group">
              <li
                class="list-group-item"
                v-for="friend in friends"
                :key="friend.id"
              >
                <a href="#" @click.prevent="openSession(friend)">{{
                  friend.name
                }}</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div v-for="friend in friends" :key="friend.id" v-if="friend.session">
          <MessageComponent
            v-if="friend.session.open"
            @close="friend.session.open = false"
            :friend="friend"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MessageComponent from "./MessageComponent";
export default {
  name: "ChatComponent",
  components: { MessageComponent },
  data() {
    return {
      open: true,
      friends: [],
    };
  },
  created() {
    this.getFriends();
  },
  methods: {
    openExistSession(friend) {
      this.closeAllSessions();
      friend.session.open = true;
    },
    async openSession(friend) {
      if (friend.session) {
        this.openExistSession(friend);
      } else {
        try {
          const res = (await axios.post("/sessions", { friend_id: friend.id }))
            .data;
          friend.session = res.data;
          this.openExistSession(friend);
        } catch (error) {
          console.log(error);
        }
      }
    },
    closeAllSessions() {
      this.friends.forEach((friend) => {
        if (friend.session) {
          friend.session.open = false;
        }
      });
    },
    async getFriends() {
      try {
        const res = (await axios.get("/users")).data;
        this.friends = res.data;
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>
