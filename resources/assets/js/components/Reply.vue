<template>
    <div :id="'reply-'+id" class="card top-buffer">
        <div class="card-header" :class="isBest ? 'alert-success' : ''">
            <div class="level">
                <h5 class="flex">
                    <img :src="data.owner.avatar_path" 
                            :alt="data.owner.name" 
                            width="25" 
                            height="25" 
                            class="mr-1">
                    <small><a :href="'/profiles/'+data.owner.name" v-text="data.owner.name"></a> 
                    said <span v-text="ago"></span></small>
                </h5>

                <div v-if="signedIn">
                    <favorite :reply="data"></favorite>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" id="" cols="30" rows="3" v-model="body" required></textarea>
                </div>
                <button class="btn btn-default btn-outline-success btn-sm mr-1" @click="update">
                    <i class="fa fa-save"></i>
                </button>
                <button class="btn btn-default btn-outline-danger btn-sm mr-1" @click="editing = false" type="button">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <div v-else v-html="body"></div>
        </div>
        <div class="card-footer level">
            <div v-if="authorize('updateReply', reply)">
                <button class="btn btn-default btn-info btn-sm mr-1" @click="editing = true">
                    <i class="fa fa-edit"></i>
                </button>
                <button type="submit" class="btn btn-default btn-danger btn-sm mr-1" @click="destroy">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
            <button type="button" class="btn btn-default btn-default btn-sm ml-a" @click="markBestReply" v-show="!isBest">
                <i class="fa fa-star"></i>
            </button>
        </div>
    </div>
</template>

<script>
import Favorite from "./Favorite";
import moment from "moment";

export default {
  props: ["data"],

  components: { Favorite },

  data() {
    return {
      editing: false,
      id: this.data.id,
      body: this.data.body,
      isBest: this.data.isBest,
      reply: this.data
    };
  },

  computed: {
    ago() {
      return moment(this.data.created_at).fromNow() + " ...";
    }
  },
  created() {
    window.events.$on("best-reply-selected", id => {
      this.isBest = id === this.id;
    });
  },
  methods: {
    update() {
      axios
        .patch("/replies/" + this.id, {
          body: this.body
        })
        .catch(error => {
          flash(error.response.data, "danger");
        });

      this.editing = false;

      flash("Reply was updated!");
    },

    destroy() {
      axios.delete("/replies/" + this.data.id);

      this.$emit("deleted", this.data.id);
    },

    markBestReply() {
      axios.post("/replies/" + this.data.id + "/best");

      window.events.$emit("best-reply-selected", this.data.id);
    }
  }
};
</script>

<style>
.top-buffer {
  margin-top: 20px;
}
</style>
