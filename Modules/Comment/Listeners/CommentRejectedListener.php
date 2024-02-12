<?php

namespace Modules\Comment\Listeners;

use Modules\Comment\Notifications\CommentApprovedNotification;
use Modules\Comment\Notifications\CommentRejectedNotification;
use Modules\Comment\Notifications\CommentSubmittedNotification;

class CommentRejectedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $event->comment->user->notify(new CommentRejectedNotification($event->comment));
    }
}
