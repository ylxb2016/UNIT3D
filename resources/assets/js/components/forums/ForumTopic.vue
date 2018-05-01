<template>
    <tr>
        @if($t->pinned == 0)
        <td class="f-display-topic-icon"><img src="{{ url('img/f_icon_read.png') }}"></td>
        @else
        <td class="f-display-topic-icon"><span class="text-green"><i
                class="fa fa-thumb-tack fa-2x"></i></span></td>
        @endif
        <td class="f-display-topic-title">

            <strong>
                <a href="">
                    {{ topic.name }}
                </a>
            </strong>

            @if($t->state == "close") <span
                class='label label-sm label-default'>Closed</span> @endif
            @if($t->approved == "1") <span
                class='label label-sm label-success'>{{ strtoupper(trans('forum.approved')) }}</span> @endif
            @if($t->denied == "1") <span
                class='label label-sm label-danger'>{{ strtoupper(trans('forum.denied')) }}</span> @endif
            @if($t->solved == "1") <span
                class='label label-sm label-info'>{{ strtoupper(trans('forum.solved')) }}</span> @endif
            @if($t->invalid == "1") <span
                class='label label-sm label-warning'>{{ strtoupper(trans('forum.invalid')) }}</span> @endif
            @if($t->bug == "1") <span
                class='label label-sm label-danger'>{{ strtoupper(trans('forum.bug')) }}</span> @endif
            @if($t->suggestion == "1") <span
                class='label label-sm label-primary'>{{ strtoupper(trans('forum.suggestion')) }}</span> @endif
            @if($t->implemented == "1") <span
                class='label label-sm label-success'>{{ strtoupper(trans('forum.implemented')) }}</span> @endif
        </td>
        <td class="f-display-topic-started">
            <a href="">
                {{ topic.first_post_username }}
            </a>
        </td>
        <td class="f-display-topic-stats">
            {{ topic.posts_count }} Replies
            \ {{ topic.views }} Views
        </td>

        <td class="f-display-topic-last-post">
            <a href="">{{ topic.last_post_username }}</a>
            on
            <time :datetime="">
                {{  }}
            </time>
        </td>
    </tr>
</template>
<script>
    export default {
      name: "forum-topic",
      props: {
        topic: {required: true}
      }
    }
</script>