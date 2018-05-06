<template>
  <div>
        <div v-if="signedIn">
            <div class="form-group">
                <label for="body">Body</label>
                <textarea name="body" 
                            id="body" 
                            class="form-control" 
                            placeholder="Have somethign to say!" 
                            rows="5"
                            required
                            v-model="body"></textarea>
            </div>
            <button type="submit" class="btn btn-default" @click="addReply">Submit</button>
        </div>
        <p class="text-center" v-else>
            Please <a href="/login">Sign in</a> to Reply
        </p>
  </div>
</template>

<script>
export default {
  props: ["endpoint"],

  data() {
    return {
      body: ""
    };
  },

  computed: {
    signedIn() {
      return window.App.signedIn;
    }
  },

  methods: {
    addReply() {
      axios.post(this.endpoint, { body: this.body }).then(data => {
        this.body = "";
        flash("Your message has been posted!");

        this.$emit("created", data.data);
      });
    }
  }
};
</script>
