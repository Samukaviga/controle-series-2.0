<?php

namespace App\Providers;

use App\Events\SeriesCreatedEvent;
use App\Listeners\LogSeriesCreated;

use App\Events\DeleteImageSerieEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\ImageUserAboutSeriesDelete;
use App\Listeners\EmailUserAboutSeriesCreated;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
   
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],


        SeriesCreatedEvent::class => [
            EmailUserAboutSeriesCreated::class,
            LogSeriesCreated::class,
        ],
        
        DeleteImageSerieEvent::class => [
            ImageUserAboutSeriesDelete::class,
        ]
    ];

   
    public function boot()
    {
        //
    }


    public function shouldDiscoverEvents()
    {
        return false;
    }
}
