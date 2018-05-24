<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;
use App\Models\User;
use App\Notifications\YouWereMentioned;

class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
     * @param  ThreadHasNewReply  $event
     * @return void
     */
    public function handle(ThreadHasNewReply $event)
    {
        // for each menthioned user notify them
        // $mentionedUsers = $event->reply->mentionedUsers();
        // foreach ($mentionedUsers as $name) {
        //     $user = User::whereName($name)->first();

        //     if ($user) {
        //         $user->notify(new YouWereMentioned($event->reply));
        //     }
        // }

        //This using collect
        // collect($event->reply->mentionedUsers())
        //     ->map(
        //         function ($name) {
        //             return User::where('name', $name)->first();
        //         }
        //     )
        //     ->filter()
        //     ->each(
        //         function ($user) use ($event) {
        //             $user->notify(new YouWereMentioned($event->reply));
        //         }
        //     );

        //more refactor
        User::whereIn('name', $event->reply->mentionedUsers())
            ->get()
            ->each(
                function ($user) use ($event) {
                    $user->notify(new YouWereMentioned($event->reply));
                }
            );
    }
}
