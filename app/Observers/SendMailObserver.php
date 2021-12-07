<?php

namespace App\Observers;

class SendMailObserver
{
    /**
     * Handle the User "created" event.
     *
     *
     * @return void
     */
    public function created($send_email)
    {
       /* dispatch(new App\Jobs\SendEmailJob($send_email));*/
    }

    /**
     * Handle the User "updated" event.
     *
     *
     * @return void
     */
    public function updated()
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     *
     * @return void
     */
    public function deleted()
    {
        //
    }

    /**
     * Handle the User "forceDeleted" event.
     *
     *
     * @return void
     */
    public function forceDeleted()
    {
        //
    }
}
