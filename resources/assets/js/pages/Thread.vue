<script>
import Replies from "../components/Replies";
import SubscribeButton from "../components/SubscribeButton";
import LockButton from "../components/LockButton";

export default {
  props: ["dataRepliesCount", "dataLocked"],

  components: { Replies, SubscribeButton, LockButton },

  data() {
    return {
      repliesCount: this.dataRepliesCount,
      locked: this.dataLocked
    };
  }
};
</script>
