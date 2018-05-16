<script>
import Replies from "../components/Replies";
import SubscribeButton from "../components/SubscribeButton";

export default {
  props: ["thread"],

  components: { Replies, SubscribeButton },

  data() {
    return {
      repliesCount: this.thread.replies_count,
      locked: this.thread.locked,
      title: this.thread.title,
      body: this.thread.body,
      form: {},
      editing: false
    };
  },

  computed: {
    classes() {
      return ["fa", this.locked ? "fa fa-lock text-danger" : "fa fa-unlock text-success"];
    }
  },

  created () {
    this.resetForm();
  },
  
  methods: {
    toggleLock() {
      let url = `/locked-threads/${this.thread.slug}`;
      
      axios[this.locked ? 'delete' : 'post'](url);

      this.locked = ! this.locked;
    },

    update() {
      let url = `/threads/${this.thread.channel.slug}/${this.thread.slug}`;

      axios.patch(url, this.form).then(() => {
        flash('Your thread has been updated!');
        this.editing = false;
        this.title = this.form.title;
        this.body = this.form.body;
      });
    },

    resetForm() {
      this.form = {
        title: this.thread.title,
        body: this.thread.body
      }

      this.editing = false;
    }
  }
};
</script>
