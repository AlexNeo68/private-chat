<template>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">Private Chat</div>

          <div class="card-body">
            <ul class="list-group">
              <li
                class="list-group-item d-flex justify-content-between align-items-center"
                v-for="friend in friends"
                :key="friend.id"
              >
                <a href="#" @click.prevent="openSession(friend)"
                  >{{ friend.name }}
                  <span
                    class="text-danger"
                    v-if="friend.session && friend.session.unreadMessageCount"
                    >{{ friend.session.unreadMessageCount }}</span
                  ></a
                >
                <i
                  v-if="friend.online"
                  class="fas fa-circle-notch text-success"
                ></i>
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
    Echo.channel("Chat").listen("SessionEvent", (e) => {
      let friend = this.friends.find((fr) => fr.id == e.session_by);
      friend.session = e.session;
      this.listenEverySession(friend);
    });
    Echo.join(`Chat`)
      .here((users) => {
        this.friends.forEach((friend) => {
          users.forEach((user) => {
            if (user.id == friend.id) friend.online = true;
          });
        });
      })
      .joining((user) => {
        this.friends.forEach((friend) => {
          if (user.id == friend.id) friend.online = true;
        });
      })
      .leaving((user) => {
        this.friends.forEach((friend) => {
          if (user.id == friend.id) friend.online = false;
        });
      });
  },
  methods: {
    listenEverySession(friend) {
      Echo.private(`Chat.${friend.session.id}`).listen(
        "PrivateChatEvent",
        (e) => {
          if (!friend.session.open) {
            friend.session.unreadMessageCount++;
          }
        }
      );
    },
    openExistSession(friend) {
      this.closeAllSessions();
      friend.session.open = true;
      friend.session.unreadMessageCount = 0;
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
        this.friends.forEach((friend) => {
          if (friend.session) this.listenEverySession(friend);
        });
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>
